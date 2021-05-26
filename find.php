<?php
$page_title = "Etkinlik Ara";
include 'includes/page-common.php';
include 'includes/head.php';
?>

<!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/js/tempusdominus-bootstrap-4.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/css/tempusdominus-bootstrap-4.min.css" /> -->

<!-- NAVBAR BURADA -->
<style>
.arama-sonuc {
    font-weight: 600;
    font-size: 24px;
    color: #2115068f;
    margin-bottom: 10px;
}
</style>

<?php
include 'includes/nav-bar.php';
$etkinlikler = [];

$sehirler = EtkinlikSehirleriniGetir();
$tipler = EtkinlikTipleriniGetir();

$find_search = "";
$find_tip = "";
$find_city = "";
$find_time = "";

$find_time_start = "";
$find_time_end = "";
$find_time_operator = "=";

$arama_mesaj = "Arama sonucu";

if (isset($_GET["search"]) || isset($_GET["tip"]) || isset($_GET["city"]) || isset($_GET["time"])) {

    if (isset($_GET["search"]))
        $find_search = $_GET["search"];
    if (isset($_GET["tip"]))
        $find_tip = $_GET["tip"];
    if (isset($_GET["city"]))
        $find_city = $_GET["city"];

    if (isset($_GET["time"])) {
        $find_time = $_GET["time"];
        $find_time = FirstItemFrom($find_time);

        $arama_zaman_parametreleri =  AramaZamanıParametresiAyarla($find_time);
        $find_time_operator = $arama_zaman_parametreleri[0];
        $find_time_start = $arama_zaman_parametreleri[1];
        $find_time_end = $arama_zaman_parametreleri[2];
    }

    

    $etkinlikler = EtkinlikAra($find_search, $find_tip,  $find_city, $find_time_operator, $find_time_start, $find_time_end, 0, 50);

    if (!empty($find_city)) {
        $arama_mesaj = $find_city . " konumundaki etkinlikler...";
    }
    
    if (!empty($find_city) && !empty($find_tip)) {
        $arama_mesaj = "$find_city konumundaki $find_tip etkinlikleri...";
    }
    
    if (empty($find_city) && !empty($find_tip)) {
        $arama_mesaj = "$find_tip etkinlikleri...";
    }
    
    if (!empty($find_time) && $find_time == "9")
        $arama_mesaj = "Geçmiş etkinlikler...";

        if ($etkinlikler == NULL || count($etkinlikler) == 0)
    $arama_mesaj = "İstenilen kriterlere uygun etkinlik bulunamadı!";


} else {
   // $etkinlikler = GelecekEtkinlikleriGetir();
//    $arama_mesaj = "Arama sonuçları:";
}


?>

<body>
    <div class="container">
        <!-- Arama çubuğu -->
        <div class="">
            <div class="row text-center pb-4">
                <div class="col-md-12">
                    <h2 class="text-white siyah-cerceve">Etkinlik Ara</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card acik-renk-form">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group ">
                                        <select id="city" class="form-control">
                                            <option value="0" selected>Şehir Seçiniz</option>
                                            <?php
                                            for ($i = 0; $i < count($sehirler); $i++) {
                                                $sehir = $sehirler[$i]['sehir'];
                                                if (!empty($find_city) && $find_city == $sehir)
                                                    echo "<option selected value='$sehir'>" . $sehir . "</option>";
                                                else
                                                    echo "<option value='$sehir'>" . $sehir . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group ">
                                        <select id="time" class="form-control">
                                            <?php
                                            foreach ($ARAMA_ZAMANLARI as $key => $value) {
                                                if (!empty($find_time) && $find_time == $key)
                                                    echo "<option selected value='$key'>" . $value . "</option>";
                                                else
                                                    echo "<option value='$key'>" . $value . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group ">
                                        <select class="selectpicker form-control" id="tip" name="tip"
                                            class="form-control">
                                            <option value="0" selected>Etkinlik Türü Seçin</option>
                                            <?php
                                            for ($i = 0; $i < count($tipler); $i++) {
                                                $tip = $tipler[$i]['tip'];
                                                if (!empty($find_tip) && $find_tip == $tip)
                                                    echo "<option selected value='$tip'>" . $tip . "</option>";
                                                else
                                                    echo "<option value='$tip'>" . $tip . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <p class="font-weight-light text-dark">ya da</p>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group ">
                                        <input id="searchtext" type="text" class="form-control"
                                            value="<?php echo $find_search;?>"
                                            placeholder="Etkinlik adı, konum, anahtar kelime">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <button id="btnAra" type="button" class="btn btn-warning  pl-5 pr-5">Ara</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- Etkinlik Kartları -->
        <div class="">
            <hr>
            <section class="">
                <!-- Etkinlik Kartları -->
                <div class="arama-sonuc">
                    <?php
                    if (!empty($arama_mesaj))
                        echo $arama_mesaj;
                    ?>
                </div>
                <div class="row justify-content-center">
                    <?php
                    if ($etkinlikler != NULL)
                        for ($i = 0; $i < count($etkinlikler); $i++) {
                            $etkinlik = $etkinlikler[$i];

                            $isim =  $etkinlik["isim"];
                            $id =  $etkinlik["id"];

                            $meaningFullUrl = ToMeaningfullUrl($etkinlik["sehir"] . "-" . $etkinlik["isim"], $id);
                            ?>

                    <div class="col-sm-4">
                        <div class="card-section">
                            <div class="card-section-image">
                                <a class='cat-image-link' href='event.php?event=<?php echo $meaningFullUrl; ?>'>
                                    <img class="etkinlik-resim"
                                        src="files/images/event/<?php echo $etkinlik["kodu"] ?>.png"
                                        onerror="this.onerror=null; this.src='files/images/<?php echo ToEnglish($etkinlik["tip"]); ?>.png'">
                                </a>
                                <div class="event-card-footer">
                                    <a class="<?php echo ToLowerandEnglish($etkinlik["tip"]) ?> event-tag"
                                        href="<?php echo "event/" . ToLowerandEnglish($etkinlik["tip"]) ?>.php">
                                        <?php echo $etkinlik["tip"] ?>
                                    </a>
                                </div>
                            </div>
                            <div class="card-desc">
                                <div class="event-title">
                                    <a href='event.php?event=<?php echo $meaningFullUrl; ?>'>
                                        <h3><?php echo $isim ?></h3>
                                    </a>
                                </div>
                                <div class="card-info">
                                    <ul class="list-unstyle">
                                        <li><i class="fas fa-clock"></i>
                                            <?php echo turkcetarih_formati("d M Y", $etkinlik["tarih"]); ?></li>
                                        <li><i
                                                class="fas fa-map-marker-alt"></i><?php echo " " . $etkinlik["sehir"] . " - " . $etkinlik["adres"] ?>
                                        </li>
                                    </ul>

                                </div>
                                <!-- <a href='event.php?event=<?php echo $id ?>' class="cart_btn btn btn-dark">Detay</a> -->
                            </div>
                        </div>
                    </div>

                    <?php } ?>
            </section>

        </div>

        <script type="text/javascript">
        function aramaYap() {
            var tip = $("#tip").val();
            var time = $("#time").val();
            var timeText = $("#time option:selected").html();
            var city = $("#city").val();
            var search = $("#searchtext").val();


            var url = location.pathname + "?";

            if (search) {
                url = url + "search=" + search + "&";
            }

            if (tip && tip != "0") {
                url = url + "tip=" + tip + "&";
            }

            if (time) {
                url = url + "time=" + (time + "-" + timeText) + "&";
            }

            if (city && city != "0") {
                url = url + "city=" + city + "&";
            }

            url = url.substring(0, url.length - 1);

            if (url != "/find.php")
                location.href = location.origin + url;
        }

        $(function() {
            $('#btnAra').on("click", aramaYap);
        });

        $('#searchtext').keypress(function(e) {
            if (e.which == 13) {
                aramaYap();
                return false;
            }
        });
        </script>
        <hr>
    
</body>