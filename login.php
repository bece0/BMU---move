<?php
    $page_title = "Giriş Yap";
    include 'includes/head.php';
?>
 <body>
    <?php
        include 'includes/nav-bar.php';
        
        if(isset($_SESSION["kullanici_id"])){    //giriş yapılmış ise index'e git
            header('Location: index.php');
        }
    ?>
     <div class="container justify-content-sm-center" style="display: flex;">
        <div class="col-sm-6 col-md-4">
            <div class="card border-info text-center">
                <div class="card-header">
                    Devam etmek için giriş yapın
                </div>
                <div class="card-body">
                    <img src="files/images/logo.png" style="margin-bottom:30px;border-radius:50px;width:25%">
                    <!-- <h4 class="text-center">Hunger & Debt Ltd</h4> -->
                    <form class="form-signin" action="action/login_action.php" method="post">
                        <input type="text" class="form-control mb-2" placeholder="Email" name="email" required autofocus>
                        <input type="password" class="form-control mb-2" placeholder="Parola"  name="pwd" required>
                         <?php
                            if(isset($_GET["event"])){
                         ?>       <input type="hidden" name="event" value="<?php echo $_GET["event"] ?>">
                          <?php   } 
                         ?>
                        <button class="btn btn-lg btn-primary btn-block mb-1" type="submit" style="background-color: #1d1a1a">Giriş Yap</button>
                        <!-- <label class="checkbox float-left">
                        <input type="checkbox" value="remember-me">
                        Remember me
                        </label> -->
                        <!-- <a href="#" class="float-right">Need help?</a> -->
                    </form>
                </div>
                <h5 class="justify-content-sm-center">
                    <a href="signup.php" class="float-right" style="margin-right: 13px; color: #312c2c; ">Hesap oluştur </a>
                </h5>
            </div>
        </div>
    </div>
</body>

</html>