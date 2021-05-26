<?php

function endswith($string, $test)
{
    $strlen = strlen($string);
    $testlen = strlen($test);
    if ($testlen > $strlen) return false;
    return substr_compare($string, $test, $strlen - $testlen, $testlen) === 0;
}

/**
 * 
 */
function KatilimciVarMi($etkinlik_id, $kullanici_id)
{
    $sql = "SELECT * FROM katilimci where etkinlik_id = $etkinlik_id and kullanici_id = $kullanici_id";

    $con = BAGLANTI_GETIR();
    $result = $con->query($sql);
    //  var_dump($sql);
    if ($result->num_rows > 0)
        return TRUE;
    else
        return FALSE;
}

/**
 * Verilen bilgileri etkinlik tablosuna kaydeder.
 *
 * @param string $isim kullanıcının adı
 * @param string $aciklama kullanıcının soyadı
 * @param string $tarih  kullanıcının mail adresi
 * @param string $adres kullanıcının parolası
 * @param int $duzenleyen_id kullanıcının adı
 * @param string $seviye kullanıcının soyadı
 * @param string $tel  kullanıcının mail adresi
 * @param string $sehir kullanıcının parolası
 * @return bool kaydetme işlemi başarılı ise true değil ise false döner
 */
function EtkinlikKaydet($etkinlik_kodu, $isim, $aciklama, $tarih, $adres, $duzenleyen_id, $seviye, $tel, $sehir, $k_aciklama, $tip)
{
    $sql = "INSERT INTO etkinlik (kodu, isim, aciklama, k_aciklama, tarih, adres, duzenleyen_id, seviye, tel, sehir, tip)
    VALUES ('$etkinlik_kodu','$isim','$aciklama', '$k_aciklama' ,'$tarih','$adres','$duzenleyen_id','$seviye','$tel','$sehir', '$tip')";

    return SQLInsertCalistir($sql);
}


/**
 * TODO
 */
function EtkinligeKayitOl($kullanici_id, $etkinlik_id)
{
    $sql = "INSERT INTO katilimci (kullanici_id, etkinlik_id, kayit_tarihi)
    VALUES ('$kullanici_id', '$etkinlik_id', CURDATE())";

    return SQLInsertCalistir($sql);
}

/**
 * TODO
 */
function EtkinligiIptalEt($kullanici_id, $etkinlik_id)
{
    $sql = "DELETE FROM katilimci WHERE kullanici_id='" . $kullanici_id . "'AND etkinlik_id='" . $etkinlik_id . "'";

    return SQLDeleteCalistir($sql);
}

/**
 * Databasedeki tüm etkinlikleri döner
 *  @return array gelen sonucu döner,sonuç boş ise NULL döner 
 */
function EtkinlikleriGetir($limit = 50)
{
    $sql = "SELECT * FROM etkinlik order by id desc LIMIT $limit ";

    return SQLCalistir($sql);
}

/**
 * 
 */
function EtkinlikAra($search, $tip, $city, $timeOperator, $time_start, $time_end, $skip = 0, $limit = 50)
{
    $sql = "SELECT * FROM etkinlik where";
    if (!empty($time_start) && !empty($time_end)) {
        $sql = $sql . " etkinlik.tarih > '$time_start' and etkinlik.tarih < '$time_end' and";
    } else {
        if (!empty($time_start) && !empty($timeOperator)) {
            $sql = $sql . " etkinlik.tarih $timeOperator '$time_start' and";
        }
    }

    if (!empty($tip))
        $sql = $sql . " etkinlik.tip = '$tip' and";


    if (!empty($city))
        $sql = $sql . " etkinlik.sehir = '$city' and";

    if (!empty($search))
        $sql = $sql . " (etkinlik.isim LIKE '%$search%' or etkinlik.aciklama LIKE '%$search%') and";

    $sql = trim($sql);

    // echo "<br>" . $sql . "  " . endsWith($sql, "and") . "<br>";
    if (endsWith($sql, "and") == 1)
        $sql = substr($sql, 0, -3);

    // echo "<br>" . $sql . "<br>";
    if (endsWith($sql, "where") == 1)
        return GelecekEtkinlikleriGetir($skip, $limit);

    // echo "<br> order öncesi : " . $sql . "<br>";
    $sql = $sql . " order by id desc LIMIT $limit ";

    // echo "<br> <br>  <br>  SQL : " . $sql . "<br>";

    return SQLCalistir($sql);
}


function EtkinlikAra_Text($search, $onlyFeature = false, $skip = 0, $limit = 50)
{
    if (empty($search))
        return GelecekEtkinlikleriGetir($skip, $limit);

    $sql = "SELECT * FROM etkinlik where";
    if ($onlyFeature)
        $sql = $sql . " etkinlik.tarih > CURDATE() and";

    $sql = $sql . " etkinlik.isim LIKE '%$search%' or etkinlik.aciklama LIKE '%$search%'  or etkinlik.adres LIKE '%$search%')";

    if (endsWith($sql, "and") == 1) {
        $sql = substr($$sql, 0, -3);
    }

    if (endsWith($sql, "where") == 1) {
        return GelecekEtkinlikleriGetir($skip, $limit);
    }

    $sql = $sql . " order by id desc LIMIT $limit ";

    return SQLCalistir($sql);
}

/**
 * Id parametre olarak verilen etkinliğin bilgilerini getirir
 * @param string $event_id etkinliğin id'si
 * @return string gelen sonucu döner,sonuç boş ise NULL döner 
 */
function EtkinlikBilgileriniGetir($event_id)
{
    // var_dump($event_id);
    $sql = "SELECT * FROM etkinlik where id = " . $event_id . "";

    return SQLTekliKayitGetir($sql);
}

/**
 * Id parametre olarak verilen etkinliğin bilgilerini getirir
 * @param string $kodu etkinliğin kodu
 * @return string gelen sonucu döner,sonuç boş ise NULL döner 
 */
function EtkinlikBilgileriniGetir_Kod($kodu)
{
    $sql = "SELECT * FROM etkinlik where kodu ='" . $kodu . "'";

    return SQLTekliKayitGetir($sql);
}

/**
 * 
 */
function KullaniciYeniEtkinlikleriniGetir($kullanici_id)
{
    $sql = "SELECT etkinlik.* FROM etkinlik INNER JOIN katilimci 
        ON katilimci.etkinlik_id=etkinlik.id where katilimci.kullanici_id='" . $kullanici_id . "' and etkinlik.tarih > CURDATE()";

    return SQLCalistir($sql);
}

/**
 * 
 */
function KullaniciEskiEtkinlikleriniGetir($kullanici_id)
{
    $sql = "SELECT etkinlik.* FROM etkinlik INNER JOIN katilimci 
        ON katilimci.etkinlik_id=etkinlik.id where katilimci.kullanici_id='" . $kullanici_id . "' and etkinlik.tarih < CURDATE()";

    return SQLCalistir($sql);
}

function EtkinlikDuzenle($isim, $aciklama, $tarih, $adres, $seviye, $tel, $sehir, $k_aciklama, $tip, $event_id)
{
    $sql = "UPDATE etkinlik SET isim = '$isim', aciklama = '$aciklama', tarih = '$tarih', adres ='$adres', seviye = '$seviye',
    tel = '$tel', sehir = '$sehir', k_aciklama = '$k_aciklama',tip = '$tip' WHERE id=$event_id";

    return SQLUpdateCalistir($sql);
}

function EtkinlikSil($event_id)
{
    $sql = "DELETE FROM etkinlik  WHERE  id=$event_id";

    return SQLDeleteCalistir($sql);
}

/**
 * Gelecek etkinlikleri etkinlik tarihi sırasına göre getirir.
 * @param int $limit sorgu sonucu kayıt limiti
 */
function GelecekEtkinlikleriGetir($skip = 0, $limit = 50)
{
    $sql = "SELECT etkinlik.* FROM etkinlik WHERE etkinlik.tarih > CURDATE() 
    order by etkinlik.tarih LIMIT $limit";

    return SQLCalistir($sql);
}

function DuzenledigiEtkinlikleriGetir($kullanici_id)
{
    $sql = "SELECT etkinlik.* FROM etkinlik WHERE duzenleyen_id=" . $kullanici_id . " AND etkinlik.tarih > CURDATE()";

    return SQLCalistir($sql);
}
function  DuzenledigiGecmisEtkinlikleriGetir($kullanici_id)
{
    $sql = "SELECT etkinlik.* FROM etkinlik WHERE duzenleyen_id=" . $kullanici_id . " AND etkinlik.tarih < CURDATE()";

    return SQLCalistir($sql);
}

function EtkinlikKatilimcilariniGetir($event_id)
{
    $sql = "SELECT kullanici.* FROM kullanici INNER JOIN katilimci 
    ON katilimci.kullanici_id=kullanici.id where katilimci.etkinlik_id=" . $event_id . "";

    return SQLCalistir($sql);
}


function EtkinlikSehirleriniGetir()
{
    $sql = "SELECT DISTINCT(sehir) FROM etkinlik order by sehir";
    return SQLCalistir($sql);
}

function EtkinlikTipleriniGetir()
{
    $sql = "SELECT DISTINCT(tip) FROM etkinlik order by tip";
    return SQLCalistir($sql);
}
