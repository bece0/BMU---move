<?php
$REQUIRE_LOGIN = TRUE;
$page_title = "Etkinliklerim";

include 'includes/page-common.php';
include 'includes/head.php';
?>
<style>
    .event-date {
        float: right;
        font-size: medium;
        margin-right: 25px;
    }

    .c-header-action {
        margin-left: 5px;
        cursor: pointer;
    }
</style>

<body>
    <?php
    setlocale(LC_ALL, 'tr_TR.UTF-8', 'tr_TR', 'tr', 'trk', 'turkish');
    include 'includes/nav-bar.php';

    $kullanici_id  = $_SESSION["kullanici_id"];
    $kullanici_detail = KullaniciBilgileriniGetirById($kullanici_id);

    $duzenledigi_etkinlikler = DuzenledigiEtkinlikleriGetir($kullanici_id);
    $gecmis_etkinlikler = DuzenledigiGecmisEtkinlikleriGetir($kullanici_id);
    ?>

    <div class="container">
        <h4>Etkinkliklerim</h4>
        <hr>
        <div class="row">
            <div class="col-3">
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">
                        Düzenlediğim Etkinlikler
                    </a>
                    <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">
                        Geçmiş Etkinliklerim
                    </a>
                </div>
            </div>
            <div class="col-9">
                <div class="tab-content" id="v-pills-tabContent">

                    <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                        <?php
                        if ($duzenledigi_etkinlikler != NULL && count($duzenledigi_etkinlikler) > 0) {
                            for ($i = 0; $i < count($duzenledigi_etkinlikler); $i++) {
                                $etkinlik = $duzenledigi_etkinlikler[$i];
                                ?>
                                <div class="card row mx-2 mb-3">
                                    <div class="card-header">
                                        <a class="btn btn-warning c-header-action" href="edit_event.php?event=<?php echo $etkinlik["id"]; ?>">
                                            <i class="fa fa-edit"></i>&nbsp;Düzenle
                                        </a>
                                        <a class="btn btn-warning c-header-action duyuru-yap" event-id="<?php echo $etkinlik["id"]; ?>" event-name="<?php echo $etkinlik["isim"]; ?>">
                                            <i class="fa fa-bell"></i>&nbsp;Duyuru Yap
                                        </a>
                                    </div>
                                    <div class="card-body">
                                        <h5 class="">
                                            <?php
                                            $isim =  $etkinlik["isim"];
                                            $id =  $etkinlik["id"];
                                            echo "<a href='event.php?event=$id'> $isim </a>"
                                            ?>
                                            <p class="card-text event-date">
                                                <i class="fas fa-clock"></i>
                                                <?php echo turkcetarih_formati("d M Y", $etkinlik["tarih"]); ?>
                                            </p>
                                        </h5>
                                    </div>
                                </div>
                            <?php }
                    } else { ?>
                            <div class="alert alert-warning" role="alert">
                                Gelecekte düzenlenen herhangi bir etkinlik bulunmuyor.
                            </div>
                        <?php  }  ?>
                    </div>

                    <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                        <?php
                        if ($gecmis_etkinlikler != NULL && count($gecmis_etkinlikler) > 0) {
                            for ($i = 0; $i < count($gecmis_etkinlikler); $i++) {
                                $etkinlik = $gecmis_etkinlikler[$i];
                                ?>
                                <div class="card row mx-2 mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <?php
                                            $isim =  $etkinlik["isim"];
                                            $id =  $etkinlik["id"];
                                            echo "<a href='event.php?event=$id'> $isim </a>"
                                            ?>
                                            <p class="card-text event-date">
                                                <i class="fas fa-clock"></i>
                                                <?php echo turkcetarih_formati("d M Y", $etkinlik["tarih"]); ?>
                                            </p>
                                        </h5>
                                    </div>
                                </div>
                            <?php }
                    } else { ?>
                            <div class="alert alert-warning" role="alert">
                                Daha önce bir etkinlik düzenlemediniz.
                            </div>
                        <?php  }  ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(".duyuru-yap").on("click", function(e) {
            var event_id = $(e.target).attr("event-id");
            var event_name = $(e.target).attr("event-name");

            Swal.fire({
                title: 'Etkinlik Duyurusu',
                text: event_name,
                input: 'textarea',
                inputPlaceholder: 'Katılımcılara gönderilecek olan mesajı buraya yazın...',
                showCancelButton: true,
                confirmButtonText: '<i class="fa fa-paper-plane"></i> Gönder!',
                cancelButtonText: '<i class="fa fa-times"></i> İptal',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                inputValidator: (value) => {
                    if (!value) {
                        return 'Duyuru içeriği girmelisiniz!'
                    }
                    if (value.length < 15) {
                        return 'Duyuru içeriği çok kısa!'
                    }

                    // var regex = new RegExp("^[a-zA-Z0-9]+$");
                    // var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
                    // if (!regex.test(value.length)) {
                    //     return 'Sadece alfanumeric değerler kabul edilmektedir.'
                    // }
                }
            }).then((result) => {
                if (!result.value)
                    return;
                DuyuruGonder(event_id, result.value);
            });
        })

        function DuyuruGonder(event_id, duyuru) {
            var data = {
                event_id: event_id,
                announcement: duyuru
            }
            $.ajax({
                type: "POST",
                url: 'services/notification.php?method=event_announcement',
                data: {
                    data: JSON.stringify(data)
                },
                success: function(response) {
                    if (response && response.sonuc) {
                        Swal.fire({
                            type: 'success',
                            title: 'Katılımcılara duyuru gönderildi',
                            timer: 2000,
                            showConfirmButton: false,
                        });
                    } else {
                        console.log(response);
                        Swal.fire({
                            title: 'Hata',
                            text: 'Duyuru gönderilemedi, lütfen daha sonra tekrar deneyin.',
                            type: 'warning',
                            timer: 2000,
                            showConfirmButton: false,
                        })
                    }
                },
                error: function(jqXHR, error, errorThrown) {
                    console.log(error);
                    Swal.fire({
                        title: 'Hata',
                        text: 'Duyuru gönderilemedi, lütfen daha sonra tekrar deneyin.',
                        type: 'warning',
                        timer: 2000,
                        showConfirmButton: false,
                    })
                }
            });
        }
    </script>
</body>