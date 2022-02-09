<?php
// veritabanı ayar dosyasını dahil et
include '../../config/vtabani.php';
try {
 // kaydın slider_id bilgisini al
 $slider_id=isset($_GET['slider_id']) ? $_GET['slider_id'] : die('HATA: slider_id bilgisi bulunamadı.');
 $slider_k_durum=isset($_GET['slider_k_durum']) ? $_GET['slider_k_durum'] : die('HATA: slider_k_durum bilgisi bulunamadı.');
 $a=0;
 
 if($slider_k_durum==1){
  //diğer sliderların kullanım durumunu güncelleme sorgusu
	$sorgu = "UPDATE slider SET slider_k_durum=0 WHERE slider_k_durum=1";
	$stmt = $con->prepare($sorgu);
	 // sorguyu çalıştır
	$stmt->execute();
	$a=1;
 }else if($slider_k_durum==2){
	$sorgu2 = "UPDATE slider SET slider_k_durum=0 WHERE slider_k_durum=2";
	$stmt2 = $con->prepare($sorgu2);
	 // sorguyu çalıştır
	$stmt2->execute();
	$a=2;
 }else if($slider_k_durum==3){
	$sorgu3 = "UPDATE slider SET slider_k_durum=0 WHERE slider_k_durum=3";
	$stmt3 = $con->prepare($sorgu3);
	 // sorguyu çalıştır
	$stmt3->execute();
	$a=3;
 }
 // sorgu çalıştysa...
 if($a != 0 || $slider_k_durum==0){
	 
//istenilen sliderın kullanım durumunu güncelleme sorgusu
 $sorgu = "UPDATE slider SET slider_k_durum=".$slider_k_durum." WHERE slider_id = ?";
 $stmt = $con->prepare($sorgu);
 $stmt->bindParam(1, $slider_id);
 $stmt->execute();
  
 // kayıt listeleme sayfasına yönlendir
 // ve kullanıcıya kaydın güncellendiğini bildir
 header('Location: slider_liste.php?islem=slider_degisiti');
 }// veya güncellenmediği bildir
 else{
 header('Location: slider_liste.php?islem=slider_degismedi');
 }
}
// hata varsa göster
catch(PDOException $exception){
 die('HATA: ' . $exception->getMessage());
}
?>