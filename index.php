<?php
$REQUIRE_LOGIN = FALSE;
$page_title = " Anasayfa";
include 'includes/page-common.php';
include 'includes/head.php';
include 'includes/nav-bar.php';

$etkinlikler = GelecekEtkinlikleriGetir();
?>

<link rel="stylesheet" href="assets/css/index.css">

<!-- <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->

<!-- <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css"> -->
<style>
.mySlides {
    display: none;
    max-height: 380px;
}

img {
    vertical-align: middle;
}

/* Slideshow container */
.slideshow-container {
    max-width: 980px;
    max-height: 350px;
    position: relative;
    margin: auto;
    margin-bottom: 10px;
}

.slide-img {
    /* width:100%; */
    /* height:100%; */
    width: 137.5%;
    /* max-width : 800px; */
    margin-top: -8px;
}

.img-container {
    display: flex;
    justify-content: center;
    max-height: inherit;
    /* height: 100%; */
}

/* Next & previous buttons */
.prev,
.next {
    cursor: pointer;
    position: absolute;
    top: 50%;
    width: auto;
    padding: 16px;
    margin-top: -22px;
    color: white;
    font-weight: bold;
    font-size: 18px;
    transition: 0.6s ease;
    border-radius: 0 3px 3px 0;
    user-select: none;
}

/* Position the "next button" to the right */
.next {
    right: -150px;
    border-radius: 3px 0 0 3px;
}

.prev {
    left: -150px;
    border-radius: 3px 0 0 3px;
}

/* On hover, add a black background color with a little bit see-through */
.prev:hover,
.next:hover {
    background-color: rgba(0, 0, 0, 0.8);
}

/* Caption text */
.text {
    color: #f2f2f2;
    font-size: 33px;
    padding: 8px 12px;
    position: absolute;
    bottom: 8px;
    width: 100%;
    text-align: center;
    display: flex;
    justify-content: center;
}

.text-content {
    border: solid 4px white;
    padding: 8px;
}

/* Fading animation */
.fade1 {
    -webkit-animation-name: fade;
    -webkit-animation-duration: 1.5s;
    animation-name: fade;
    animation-duration: 1.5s;
}

@-webkit-keyframes fade {
    from {
        opacity: .4
    }

    to {
        opacity: 1
    }
}

@keyframes fade {
    from {
        opacity: .4
    }

    to {
        opacity: 1
    }
}

/* On smaller screens, decrease text size */
@media only screen and (max-width: 300px) {

    .prev,
    .next,
    .text {
        font-size: 11px
    }
}
</style>

<body>

    <div class="container">
        <div>
            <div class="slideshow-container">
                <div class="mySlides fade1">
                    <div class="img-container">
                        <img src="files/images/1.jpg" class="slide-img">
                    </div>
                    <div class="text">
                        <div class="text-content">
                            HAREKETE GEÇİN
                        </div>
                    </div>
                </div>

                <div class="mySlides fade1">
                    <div class="img-container">
                        <img src="files/images/2.jpg" class="slide-img">
                    </div>
                    <div class="text">
                        <div class="text-content">
                            YENİ İNSANLARLA TANIŞIN
                        </div>
                    </div>
                </div>

                <div class="mySlides fade1">
                    <div class="img-container">
                        <img src="files/images/3.jpg" class="slide-img">
                    </div>
                    <div class="text">
                        <div class="text-content">
                            ETKINLIKLERI KEŞFETMEK İÇİN KATILIN
                        </div>
                    </div>
                </div>

                <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                <a class="next" onclick="plusSlides(1)">&#10095;</a>
            </div>
            <!-- <div style="text-align:center">
                <span class="dot" onclick="currentSlide(1)"></span> 
                <span class="dot" onclick="currentSlide(2)"></span> 
                <span class="dot" onclick="currentSlide(3)"></span> 
            </div> -->
        </div>
        <hr>
        <hr>
        <h4>Gelecek Etkinlikler</h4>
        <div class="">
            <!-- Etkinlik Kartları -->
            <div class="row justify-content-center">
                <?php
                if ($etkinlikler != NULL && !is_null($etkinlikler)) {
                    $etkinlikler_count = count($etkinlikler);

                    for ($i = 0; $i < $etkinlikler_count; $i++) {
                        $etkinlik = $etkinlikler[$i];

                        $isim =  $etkinlik["isim"];
                        $id =  $etkinlik["id"];

                        $meaningFullUrl = ToMeaningfullUrl($etkinlik["sehir"] . "-" . $etkinlik["isim"], $id)
                        ?>

                <div class="col-sm-4">
                    <div class="card-section">
                        <div class="card-section-image">
                            <a class='cat-image-link' href='event.php?event=<?php echo $meaningFullUrl; ?>'>
                                <img class="etkinlik-resim" src="files/images/event/<?php echo $etkinlik["kodu"] ?>.png"
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
                                        <?php echo turkcetarih_formati("d M Y ", $etkinlik["tarih"]); ?></li>
                                    <li><i
                                            class="fas fa-map-marker-alt"></i><?php echo " " . $etkinlik["sehir"] . " - " . $etkinlik["adres"] ?>
                                    </li>
                                </ul>

                            </div>
                            <!-- <a href='event.php?event=<?php echo $id ?>' class="cart_btn btn btn-dark">Detay</a> -->
                        </div>
                    </div>
                </div>

                <?php }
                } else {  ?>
                <div class="alert alert-warning">Sistemde yeni etkinlik bulunamadı!</div>
                <?php }   ?>
            </div>

        </div>


        <script>
        var slideIndex = 1;
        showSlides(slideIndex);

        function plusSlides(n) {
            showSlides(slideIndex += n);
            resetInterval();
        }

        function currentSlide(n) {
            showSlides(slideIndex = n);
        }

        function showSlides(n) {
            var i;
            var slides = document.getElementsByClassName("mySlides");
            //var dots = document.getElementsByClassName("dot");

            if (n > slides.length) {
                slideIndex = 1
            }
            if (n < 1) {
                slideIndex = slides.length
            }

            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }

            //   for (i = 0; i < dots.length; i++) {
            //       dots[i].className = dots[i].className.replace(" active", "");
            //    }

            slides[slideIndex - 1].style.display = "block";
            //dots[slideIndex-1].className += " active";
        }

        var intervalKod = 0;

        function resetInterval() {
            clearInterval(intervalKod);
            intervalKod = setInterval(() => {
                var slides = document.getElementsByClassName("mySlides");
                slideIndex = (slideIndex + 1) % slides.length;
                showSlides(slideIndex);
            }, 5000);
        }

        resetInterval();
        </script>
        <hr>
        <div>
            <?php include 'includes/footer.php'; ?>
        </div>
</body>