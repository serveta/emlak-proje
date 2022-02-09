<?php
 // oturum işlemlerini başlat
 session_start();
 // ilan id ve adet bilgilerini al
 $id = isset($_POST['id']) ? $_POST['id'] : "";
 $adet = isset($_POST['adet']) ? $_POST['adet'] : 1;
 // ilan sepette varsa ekleme
 if(array_key_exists($id, $_SESSION['favori'])) {
 echo "false";
 }
 // ilan sepette yoksa ekle
 else{
 $_SESSION['favori'][$id]=array('adet'=>$adet);
 echo "true";
 }
?>