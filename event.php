<?php
include 'includes/page-common.php';
include 'includes/head.php';
?>
<link rel="stylesheet" href="assets/css/event.css">

<link rel="stylesheet" href="assets/css/social-share-kit.css" type="text/css">
<script type="text/javascript" src="assets/js/vendor/social-share-kit.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>

<body>
    <?php
    include 'includes/nav-bar.php';

    if (!isset($_GET["event"]))
        header('Location: index.php');

    $event_id = UrlIdFrom("event");
    //event=istanbul-bilmem-ne-etkinligi-12

    $event_detail = EtkinlikBilgileriniGetir($event_id);

    if ($event_detail == NULL)
        header('Location: index.php');

    $event_creator = KullaniciBilgileriniGetirById($event_detail["duzenleyen_id"]);
    //var_dump($event_detail)
    ?>

    <?php echo "<title>" . $event_detail["isim"] . "</title>" ?>
    <div class="container">
        <div class="row" style="margin-top:25px;">
            <!-- left block - eent image, description and comment -->
            <div class="col-md-7 col-sm-12">
                <img class="etkinlik-resim" src="files/images/event/<?php echo $event_detail["kodu"] ?>.png"
                    onerror="this.onerror=null; this.src='files/images/<?php echo ToEnglish($event_detail["tip"]); ?>.png'">
                <div class="aciklama">
                    <p>
                        <?php 
                        $url = '@(http(s)?)(://)?(([a-zA-Z])([-\w]+\.)+([^\s\.]+[^\s]*)+[^,.\s])@';
                        $aciklama = preg_replace($url, '<a href="http$2://$4" target="_blank" title="$0">$0</a>', $event_detail["aciklama"]);
                        echo nl2br($aciklama); 
                        ?>
                    </p>
                </div>
                <div>
                    <?php include 'includes/comments.php' ?>
                </div>
            </div>

            <div class="col-md-5 col-sm-12">
                <h1 class='e-adi'><?php echo $event_detail["isim"]  ?></h1>
                <div class="creator"> Düzenleyen:
                    <a
                        href="profile.php?id=<?php echo $event_creator["id"] ?>"><?php echo $event_creator["adi"] . " " . $event_creator["soyadi"] ?></a>
                </div>
                <?php include 'includes/event_kayit.php' ?>
                <div class="detay">
                    <div class="detay-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <?php echo $event_detail["sehir"] . " - " . $event_detail["adres"]  ?>
                    </div>
                    <div class="detay-item">
                        <i class="fas fa-clock"></i>
                        <?php echo turkcetarih_formati('d M Y ', $event_detail["tarih"]); // 31.07.2012 ?>
                    </div>
                    <div class="detay-item">
                    <i class="fa fa-phone"></i>
                        <?php echo  $event_detail["tel"] ?>
                    </div>

                    <div class="detay-item">
                        <i class="fas fa-bolt"></i>
                        <?php echo  "Seviye : ". $event_detail["seviye"] ?>
                    </div>

                </div>

                <div class="detay">
                    <iframe width="%100" height="250" frameborder="0" style="top:0;left:0;width:98%;"
                        src="https://www.google.com/maps/embed/v1/place?key=AIzaSyAAgN-oMyB0kbUYncWb1JDjQCeta7Vfifg&q=<?php echo $event_detail["sehir"] . " " . $event_detail["adres"]  ?>"
                        allowfullscreen></iframe>
                </div>

                <div style="margin-top:10px;">
                    <div class="paylas">Arkadaşların ile paylaş</div>
                    <div class="ssk-group ssk-round">
                        <a href="" class="ssk ssk-whatsapp"></a>
                        <a href="" class="ssk ssk-facebook"></a>
                        <a href="" class="ssk ssk-twitter"></a>
                        <a href="" class="ssk ssk-pinterest"></a>
                        <a href="" class="ssk ssk-email"></a>
                    </div>
                </div>
                <hr>

                <div class="detay">
                    <h4>Katılımcılar</h4>
                    <hr>
                    <div>
                        <?php
                        $participant_list = EtkinlikKatilimcilariniGetir($event_detail["id"]);
                        if ($participant_list != NULL) {
                            echo "<div class='katilimciler'>";
                            $katilimci_sayisi = count($participant_list);
                            if ($katilimci_sayisi > 5) {
                                $katilimci_sayisi = 5;
                            }
                            for ($i = 0; $i < $katilimci_sayisi; $i++) {
                                $user_detail = $participant_list[$i];
                                ?>
                        <img class="avatar" src="files/profile/<?php echo $user_detail['id'] ?>.png"
                            title="<?php echo $user_detail['adi'] ?>" alt="<?php echo $user_detail['adi'] ?>"
                            onerror="this.onerror=null; this.src='files/profile/profile.png'">
                        <?php   } ?>

                        <div class=" n-kisi-daha">
                            <a data-toggle="modal" data-target="#myModal" href="#">Tümünü gör</a>
                        </div>

                        <?php    } else { ?>
                        <div class="alert alert-warning" role="alert">
                            Bu etkinlikte katılımcı yok.
                        </div>
                        <?php  } ?>
                    </div>

                    <!-- Katılımcı listesi modal -->
                    <div class=" modal fade" id="myModal" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4>Katılımcılar</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <!-- KİŞİ LİSTESİ-->
                                    <?php
                                    //$user_list = EtkinlikKatilimcilariniGetir($event_detail["id"]); 
                                    if ($participant_list != NULL) {
                                        for ($i = 0; $i < count($participant_list); $i++) {
                                            $user_detail = $participant_list[$i];
                                            $ad_soyad =  $user_detail['adi'] . " " . $user_detail['soyadi'];
                                            $user_url = $user_detail['adi']."-". $user_detail['soyadi']."-".$user_detail['id'];
                                            ?>

                                    <div class="modal-user">
                                        <img class="avatar" src="files/profile/<?php echo $user_detail['id'] ?>.png"
                                            title="<?php echo $user_detail['adi'] ?>"
                                            alt="<?php echo $user_detail['adi'] ?>"
                                            onerror="this.onerror=null; this.src='files/profile/profile.png'">
                                        <a href="profile.php?user=<?php echo $user_url; ?>"><?php echo $ad_soyad ?></a>
                                    </div>

                                    <?php  }
                                } else { ?>
                                    <div class="alert alert-warning" role="alert">
                                        Bu etkinlikte katılımcı yok.
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>    
    <script type="text/javascript">
        SocialShareKit.init({
            forceInit: true
        });
    </script>

    <div>
        <?php include 'includes/footer.php'; ?>
    </div>
</body>