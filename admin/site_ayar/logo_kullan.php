<?php
// veritabanı ayar dosyasını dahil et
include '../../config/vtabani.php';
try {
 // kaydın logo_id bilgisini al
 $logo_id=isset($_GET['logo_id']) ? $_GET['logo_id'] : die('HATA: logo_id bilgisi bulunamadı.');
 
  //diğer logoların kullanım durumunu güncelleme sorgusu
 $sorgu = "UPDATE logo SET logo_k_durum=0";
 $stmt = $con->prepare($sorgu);

 // sorguyu çalıştır
 if($stmt->execute()){
	 
//istenilen logonun kullanım durumunu güncelleme sorgusu
 $sorgu = "UPDATE logo SET logo_k_durum=1 WHERE logo_id = ?";
 $stmt = $con->prepare($sorgu);
 $stmt->bindParam(1, $logo_id);
 $stmt->execute();
  
 // kayıt listeleme sayfasına yönlendir
 // ve kullanıcıya kaydın güncellendiğini bildir
 header('Location: logo_liste.php?islem=logo_degisiti');
 } // veya güncellenmediği bildir
 else{
 header('Location: logo_liste.php?islem=logo_degismedi');
 }
}
// hata varsa göster
catch(PDOException $exception){
 die('HATA: ' . $exception->getMessage());
}
?>