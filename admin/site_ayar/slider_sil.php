<?php
 session_start();
 if ($_SESSION["loginkey"] == "") {
 // oturum açılmamışsa login.php sayfasına git
 header("Location: /proje/admin/login.php");
 }
?>

<?php
// veritabanı ayar dosyasını dahil et
include '../../config/vtabani.php';
try {
 // kaydın slider_id bilgisini al
 $slider_id=isset($_GET['slider_id']) ? $_GET['slider_id'] : die('HATA: slider_id bilgisi bulunamadı.');
 
  // silinecek kayıt bilgilerini oku
// seçme sorgusunu hazırla
$sorgu = "SELECT slider_baglanti FROM slider WHERE slider_id = ? LIMIT 0,1";
$stmt = $con->prepare( $sorgu );
// slider_id parametresini bağla (? işaretini slider_id değeri ile değiştir)
$stmt->bindParam(1, $slider_id);
// sorguyu çalıştır
$stmt->execute();
$kayit = $stmt->fetch(PDO::FETCH_ASSOC);
// okunan resim bilgilerini bir değişkene kaydet
$slider_baglanti = $kayit['slider_baglanti'];
 
 
 
 // silme sorgusu
 $sorgu = "DELETE FROM slider WHERE slider_id = ?";
 $stmt = $con->prepare($sorgu);
 $stmt->bindParam(1, $slider_id);

 // sorguyu çalıştır
 if($stmt->execute()){
	 //resim klasöründen ilgili sliderı sil...
 if(!empty($slider_baglanti)){
 $silinecek_resim = "../../content/images/".$slider_baglanti;
 if (file_exists($silinecek_resim)) unlink($silinecek_resim);
}
 // kayıt listeleme sayfasına yönlendir
 // ve kullanıcıya kaydın silindiğini bildir
 header('Location: slider_liste.php?islem=silindi');
 } // veya silinemediğini bildir
 else{
 header('Location: slider_liste.php?islem=silinemedi');
 }
}
// hata varsa göster
catch(PDOException $exception){
 die('HATA: ' . $exception->getMessage());
}
?>