<?php
 
    session_start();
    if(!isset($_SESSION["email"])){
        header('Location: index.php'); 
    }

    $kullanici_id=$_SESSION["kullanici_id"];
    $etkinlik_id=$_POST["event_id"];
    

    if(!isset($kullanici_id) || !isset($etkinlik_id)){
        $_SESSION["_error"] = "Eksik bilgi.";
        header('Location: ../info.php'); 
    }

    include '../database/database.php';

    if(EtkinligeKayitOl($kullanici_id, $etkinlik_id) === TRUE){
        $_SESSION["_success"]="Kayıt olundu.";
        LogYaz_EtkinlikKayit($kullanici_id, $etkinlik_id);
        
        header('Location: ../event.php?event='.$etkinlik_id); 
    }else {
        $_SESSION["_error"]="Bir hata oluştu. Lütfen tekrar deneyin.";
    }