<?php
    $page_title = "Üye Ol";
    include 'includes/head.php';
?>
 <body>
    <?php
        include 'includes/nav-bar.php';
        //giriş yapılmış ise index'e git
        if(isset($_SESSION["email"])){
            header('Location: index.php');
        }
    ?>
    <div class="container justify-content-sm-center" style="display: flex;">
        <div class="col-sm-6 col-md-4">
            <div class="card border-info text-center">
                <div class="card-header"> Üye Ol </div>
                <div class="card-body">
                    <img src="files/images/logo.png" style="margin-bottom:30px;     border-radius: 100px">
                    <form class="form-signin" action="action/signup_action.php" method="POST">
                        <input type="text" name="name" value="" class="form-control mb-2" placeholder="Ad"  required="true" />  
                        <input type="text" name="surname" value="" class="form-control mb-2" placeholder="Soyad"  required="true" /> 
                        <input type="text" name="email" value="" class="form-control mb-2" placeholder="E-posta adresi"  required="true"  />
                        <input type="password" name="password" value="" class="form-control mb-2" placeholder="Parola"  required="true" />
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" name="sozlesme" id="sozlesme" required="true">
                            <label class="form-check-label" for="sozlesme"><a href="agreement.php" target="_blank">Üyelik Sözleşmesi</a> şartlarını okudum ve kabul ediyorum.</label>
                        </div>
                        <button class="btn btn-lg btn-primary btn-block mb-1" type="submit" style="background-color: #1d1a1a" >Hesabımı Oluştur</button>
                    </form>
                </div>
                <h5 class="justify-content-sm-center">
                    <a href="login.php" class="float-right" style="margin-right: 10px; color: #1d1a1a" >Giriş Yap</a>
                </h5>
            </div>
        </div>
    </div>
 </body>

</html>
 