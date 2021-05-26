<?php
 
    session_start();
    if(!isset($_SESSION["kullanici_id"])){
        header('Location: index.php'); 
    }

    
    include '../includes/page-common.php';
    include '../database/database.php';
    
    $baglanti = BAGLANTI_GETIR();

    $isim=$_POST["etkinlik_adi"];
    $adres= mysqli_real_escape_string($baglanti, $_POST["adres"]);
    $sehir= mysqli_real_escape_string($baglanti, $_POST["sehir"]);
    $seviye=$_POST["seviye"];
    $aciklama=mysqli_real_escape_string($baglanti, $_POST["aciklama"]);
    $tel=$_POST["telefon"];
    $tarih=$_POST["etkinlik_tarihi"];
    $k_aciklama=mysqli_real_escape_string($baglanti, $_POST["k_aciklama"]);
    $tip=$_POST["tip"];


    echo $isim. "</br>" ;
    echo $adres. "</br>" ;
    echo $sehir. "</br>" ;
    echo $seviye. "</br>" ;
    echo $aciklama. "</br>" ;
    echo $tel. "</br>" ;
    echo $tarih. "</br>" ;
    echo $tip. "</br>" ;

    function GUID()
    {
        if (function_exists('com_create_guid') === true)
        {
            return trim(com_create_guid(), '{}');
        }

        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }
    
    /**
     * 
     */
    function ResimYukle($etkinlik_kodu){

        if(!isset($_FILES["etkinlik_resim"]) || $_FILES['etkinlik_resim']['size'] == 0){
            echo $etkinlik_kodu. " koduna sahip etkinliğin resmi yüklenmedi. varsayılan resimlerden tipine göre olan eklenecektir";
            
            $yeni_resim =  __DIR__ . "/../files/images/event/" . $etkinlik_kodu . ".png";
            $varsayılan_resim =  __DIR__ . "/../files/images/" . ToEnglish($_POST["tip"]) . ".png";

            echo "<br> yeni resim : ". $yeni_resim . "<br>";
            echo "<br>varsayılan_resim : ". $varsayılan_resim . "<br>";

            copy($varsayılan_resim,  $yeni_resim);
            return;
        }

        $filename = $_FILES["etkinlik_resim"]["name"];
        $file_basename = substr($filename, 0, strripos($filename, '.')); // get file extention
        $file_ext = substr($filename, strripos($filename, '.')); // get file name

        $file_ext = strtolower($file_ext);

        $filesize = $_FILES["etkinlik_resim"]["size"];
        $allowed_file_types = array('.jpg','.png','.jpeg');	
    
        if (in_array($file_ext,$allowed_file_types) && ($filesize < 3000000))
        {	
            // Rename file
            $newfilename = $etkinlik_kodu . ".png";
            
            $yeni_resim =  __DIR__ . "/../files/images/event/" . $newfilename;
            move_uploaded_file($_FILES["etkinlik_resim"]["tmp_name"],  $yeni_resim);
            echo "File uploaded successfully.";		
        }
        elseif (empty($file_basename))
        {	
            // file selection error
            echo "Please select a file to upload.";
        } 
        elseif ($filesize > 3000000)
        {	
            // file size error
            echo "The file you are trying to upload is too large.";
        }
        else
        {
            // file type error
            echo "Only these file typs are allowed for upload: " . implode(', ',$allowed_file_types);
            unlink($_FILES["etkinlik_resim"]["tmp_name"]);
        }
    }


     $etkinlik_kodu =  GUID();

    if(EtkinlikKaydet($etkinlik_kodu, $isim, $aciklama, $tarih, $adres, $_SESSION["kullanici_id"], $seviye, $tel, $sehir, $k_aciklama, $tip) === TRUE){
        ResimYukle($etkinlik_kodu);

        $_SESSION["_success"] = "Etkinlik oluşturuldu";

        $etkinlik = EtkinlikBilgileriniGetir_Kod($etkinlik_kodu);
        LogYaz_EtkinlikOlusturma($_SESSION["kullanici_id"], $etkinlik["id"]);

        header('Location: ../index.php'); 
    }else {
        $_SESSION["_error"] = "Etkinlik oluşturulamadı.";
        header('Location: ../index.php'); 
    }
?>

