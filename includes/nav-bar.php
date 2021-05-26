<?php 
  //session_start();
  include dirname(__FILE__) .'/../database/database.php';
  $GirisYapildiMi = isset($_SESSION["kullanici_id"]);
?>

<style>
@media (min-width: 768px) {
    .right-nav {
        margin-right: 2vw;
    }
 
    .navbar-right {
        float: right!important;
        margin-right: -15px;
    }
}
</style>

<nav class="navbar navbar-expand-md fixed-top navbar-dark bg-dark">
    
    <a class="navbar-brand" href="index.php"> <img src="files/images/event.png" style="margin-bottom: -5px;
    margin-right: 5px;
    width: 100px;
    padding: 1px;
    border-radius: 50px;
    margin-top: -6px;"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="find.php">Etkinlik Ara</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="create_event.php">Etkinlik Oluştur</a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto right-nav">
            <!-- Giriş yapılmadıysa NavBarda User var-->
            <?php if($GirisYapildiMi){ 
                $KULLANICI = KullaniciBilgileriniGetirById($_SESSION["kullanici_id"]);
            ?>
            <?php include 'notifications.php';?>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="menuDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php echo $KULLANICI["adi"]?>
                </a>
                <div class="dropdown-menu" aria-labelledby="menuDropdown">
                    <?php if($KULLANICI['admin'] != "" && $KULLANICI['admin'] == 1) {?>
                        <!-- admin menusu -->
                        <a class="dropdown-item" href="admin/management.php">Yönetim</a>
                        <a class="dropdown-item" href="my_events.php">Etkinliklerim</a>
                    <?php } else {?>
                        <!-- normal kullanıcı menusu-->
                        <a class="dropdown-item" href="profile.php?id=<?php echo $KULLANICI["id"]?>">Profil</a>
                        <a class="dropdown-item" href="my_events.php">Etkinliklerim</a>
                        <a class="dropdown-item" href="settings.php">Ayarlar</a>
                    <?php } ?>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="action/logout_action.php">Çıkış</a>
            </li>
            <?php }else{ ?>
            <li class="nav-item">
                <a class="nav-link" href="login.php">Giriş</a>
            </li>
            <?php } ?>
        </ul>
    </div>
</nav>

<?php  
  $type = "info";
  $mesaj = "";
  $title = "";

  if(isset($_SESSION["_success"])){
    $mesaj =  $_SESSION["_success"];
    $type =  "success";
    $title = "İşlem tamamlandı";
    unset($_SESSION["_success"]);
  }else if(isset($_SESSION["_info"])){
    $mesaj =  $_SESSION["_info"];
    $type =  "info";
    $title = "Bilgi";
    unset($_SESSION["_info"]);
  }else if(isset($_SESSION["_error"])){
    $mesaj =  $_SESSION["_error"];
    $type =  "error";
    $title = "Hata";
    unset($_SESSION["_error"]);
  }else if(isset($_SESSION["_warning"])){
    $mesaj =  $_SESSION["_warning"];
    $type =  "warning";
    $title = "Uyarı";
    unset($_SESSION["_warning"]);
  } 
  
  $log = "";
  if(isset($_SESSION["_log"])){
    $log = $_SESSION["_log"];
  }
  
  ?>


  <?php   if($mesaj != ""){ ?>
  <script>
    Swal.fire({
        title: '<?php echo $title?>',
        text: '<?php echo $mesaj?>',
        type: '<?php echo $type?>',
        confirmButtonText: 'Tamam'
    })
  </script>
  <?php } ?>

  <?php   if($log != ""){ ?>
  <script>
     console.log('<?php echo $log?>');
  </script>
  <?php } ?>