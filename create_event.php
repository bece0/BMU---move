<?php
    $REQUIRE_LOGIN = TRUE;
    $page_title = "Etkinlik Oluştur";

    include 'includes/head.php';
    include 'includes/page-common.php';
    include 'includes/nav-bar.php';

    //giriş yapılmamış ise girişe yönlendir
    // if(!isset($_SESSION["kullanici_id"])){
    //     header('Location: login.php');
    //     die();
    // }
?>

<style>
    #preview{
        border: solid 1px;
        height: 240px;
        border-radius: 15px;
    }
    .preview-container {
        position: relative;
        width: 100%;
        max-width: 400px;
        margin-top: 20px;
    }

    .preview-container img {
        width: 100%;
        height: auto;
    }

    .preview-container .btn {
        position: absolute;
        top: 10%;
        right: 0%;
        transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%);
        /* background-color: #555; */
        color: white;
        font-size: 27px;
        padding: 3px 3px;
        border: none;
        cursor: pointer;
        border-radius: 5px;
        text-align: center;
        outline: none;
    }

    .preview-container .btn:hover {
        color: black;
    }
</style>
<body>
    <!-- TODO http://techlaboratory.net/smartwizard/documentation KULLAN -->
    <div class="container">
        <form class="form" action="action/create_event_action.php" method="POST" 
            enctype="multipart/form-data" style="margin-top:15px;">
            <div class="form-group">
                <label class="col-form-label">Etkinlik Adı</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-pen-nib"></i></span>
                    </div>
                    <input id="etkinlik_adi" name="etkinlik_adi" placeholder="" class="form-control" required
                        type="text">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="tip">Tür</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-list-ol"></i></span>
                        </div>
                        <select class="selectpicker form-control" id="tip" name="tip">
                            <?php 
                                $etkinlik_turleri = EtkinlikTurleri();
                                foreach ($etkinlik_turleri as $key => $value) {
                                    echo "<option>".$value."</option>";
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label for="seviye">Seviye</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-list-ol"></i></span>
                        </div>
                        <select class="selectpicker form-control" name="seviye">
                            <?php 
                                $etkinlik_seviyeleri = EtkinlikZorlukSeviyeleri();
                                foreach ($etkinlik_seviyeleri as $key => $value) {
                                    echo "<option>".$value."</option>";
                                }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="etkinlik_tarihi">Tarih</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                        </div>
                        <input id="etkinlik_tarihi" name="etkinlik_tarihi" placeholder="" class="form-control" required
                            type="date">
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label for="sehir">Şehir</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-map-marker"></i></span>
                        </div>
                        <input id="sehir" name="sehir" placeholder="" class="form-control" required="true" value=""
                            type="text">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class=" control-label">Adres</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-thumbtack"></i></span>
                    </div>
                    <input id="adres" name="adres" placeholder="" class="form-control" required="true" value=""
                        type="text">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label">Kısa açıklama</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-pen"></i></span>
                    </div>
                    <input id="k_aciklama" name="k_aciklama" placeholder="" class="form-control" required="true"
                        value="" type="text">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label">Açıklama</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-pen"></i></span>
                    </div>
                    <textarea rows="5" id="aciklama" name="aciklama" placeholder="Etkinlik detayını açıklayın..."
                        class="form-control" required="true"></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label">İletişim Telefonu</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                    </div>
                    <input name="telefon" class="form-control" required="true" 
                        type="tel" placeholder="500 000 0000" pattern="[0-9]{3}\s?[0-9]{3}\s?[0-9]{4}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 control-label">Etlinlik Resmi</label>
                <div class="col-sm-10">
                    <div class="input-group">
                        <input type="file" name="etkinlik_resim" id="etkinlik_resim"  accept="image/x-png,image/jpeg">
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="">
                    <div class="preview-container">
                        <img id="preview" src="">
                        <button type="button" id="resim_kaldir" title="Resmi kaldır" class="btn">
                            <i class="fa fa-trash-alt"></i>
                        </button>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-success" style="float:right;">Oluştur</button>
        </form>
    </div>
    <script>

        var maxFilesize = 3;

        function readURL(input) {
            if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#preview').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
            }
        }

        $("#etkinlik_resim").change(function() {
            console.log("etkinlik_resim inputu değişti");

            var dosyaBoyutMB = this.files[0].size/1024/1024;
            dosyaBoyutMB = parseFloat(dosyaBoyutMB).toFixed(2);

            if(dosyaBoyutMB > maxFilesize){

                document.getElementById("etkinlik_resim").value = "";
                this.value = null;

                $('#preview').attr('src', '');

                var secilen_tip = $("#tip").val();
                secilen_tip = TurkceKarakterKaldir(secilen_tip);
                $('#preview').attr('src', "files/images/" + secilen_tip + ".png");

                Swal.fire({
                    title : "Uyarı",
                    type : "warning",
                    text : "Dosya boyutu 3 MB'tan fazla olamaz. Yüklediğiniz resim "+ parseFloat(dosyaBoyutMB).toFixed(2) + " MB boyutundadır",
                });
            }else{
                readURL(this);
            }
        });

        $("#resim_kaldir").on("click",function(){
            var secilen_tip = $("#tip").val();
            secilen_tip = TurkceKarakterKaldir(secilen_tip);
            
            //resim_kaldir id'li bir elemente tıklandığında çalışacak olan fonksiyon
            document.getElementById("etkinlik_resim").value = "";
            
            $('#preview').attr('src', "files/images/" + secilen_tip + ".png");
        });

        $(function() {
            //sayfa ilk yüklendiğinde "tip" değerine göre "preview" resmi değiştirilir.
            var secilen_tip = $("#tip").val();
            secilen_tip = TurkceKarakterKaldir(secilen_tip);
            if(secilen_tip){
                $('#preview').attr('src', "files/images/" + secilen_tip + ".png");
            }

            //"tip" değeri her değiştiğinde çağrılacak fonksiyon
            $("#tip").on("change", function(){

                //etkinlik resmi için file seçilmiş ise return
                if($("#etkinlik_resim").val())
                    return;
                
                var secilen_tip = $("#tip").val();
                secilen_tip = TurkceKarakterKaldir(secilen_tip);
                $('#preview').attr('src', "files/images/" + secilen_tip + ".png");
            })

            //şehir alanı için oto tamamlama
            //https://www.jqueryscript.net/form/Autocomplete-Dropdown-Bootstrap-jQuery.html
            var myData = ["Ankara","Konya","İstanbul"]
            // $('#sehir').autocomplete({
            //     nameProperty: 'name',
            //     valueField: '#hidden-field',
            //     dataSource: myData
            // });
        });
    </script>
</body>