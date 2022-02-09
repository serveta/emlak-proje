<?php

if($_POST){
 // veritabanı yapılandırma dosyasını dahil et
 include 'config/vtabani.php';
 try{
 // kayıt ekleme sorgusu
$sorgu = "INSERT INTO admin_mesajlar SET msj_isim=:msj_isim, msj_eposta=:msj_eposta, msj_konu=:msj_konu, msj_mesaj=:msj_mesaj";
// sorguyu hazırla
$stmt = $con->prepare($sorgu);

// post edilen değerler
$msj_isim=htmlspecialchars(strip_tags($_POST['isim']));
$msj_eposta=htmlspecialchars(strip_tags($_POST['eposta']));
$msj_konu=htmlspecialchars(strip_tags($_POST['konu']));
$msj_mesaj=htmlspecialchars(strip_tags($_POST['mesaj']));
// parametreleri bağla
$stmt->bindParam(':msj_isim', $msj_isim);
$stmt->bindParam(':msj_eposta', $msj_eposta);
$stmt->bindParam(':msj_konu', $msj_konu);
$stmt->bindParam(':msj_mesaj', $msj_mesaj);
 // sorguyu çalıştır
 if($stmt->execute()){
	 header('Location: hakkimizda.php?islem=tamam');
 }else{
	 header('Location: hakkimizda.php?islem=hata');
 }
 }
 // hatayı göster
 catch(PDOException $exception){
 die('ERROR: ' . $exception->getMessage());
 }
}
?>