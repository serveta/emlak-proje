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
 // kaydın logo_id bilgisini al
 $logo_id=isset($_GET['logo_id']) ? $_GET['logo_id'] : die('HATA: logo_id bilgisi bulunamadı.');
 
  // silinecek kayıt bilgilerini oku
// seçme sorgusunu hazırla
$sorgu = "SELECT logo_baglanti FROM logo WHERE logo_id = ? LIMIT 0,1";
$stmt = $con->prepare( $sorgu );
// logo_id parametresini bağla (? işaretini logo_id değeri ile değiştir)
$stmt->bindParam(1, $logo_id);
// sorguyu çalıştır
$stmt->execute();
$kayit = $stmt->fetch(PDO::FETCH_ASSOC);
// okunan resim bilgilerini bir değişkene kaydet
$logo_baglanti = $kayit['logo_baglanti'];
 
 
 
 // silme sorgusu
 $sorgu = "DELETE FROM logo WHERE logo_id = ?";
 $stmt = $con->prepare($sorgu);
 $stmt->bindParam(1, $logo_id);

 // sorguyu çalıştır
 if($stmt->execute()){
	 //resim klasöründen ilgili logoyu sil...
 if(!empty($logo_baglanti)){
 $silinecek_resim = "../../content/images/".$logo_baglanti;
 if (file_exists($silinecek_resim)) unlink($silinecek_resim);
}
 // kayıt listeleme sayfasına yönlendir
 // ve kullanıcıya kaydın silindiğini bildir
 header('Location: logo_liste.php?islem=silindi');
 } // veya silinemediğini bildir
 else{
 header('Location: logo_liste.php?islem=silinemedi');
 }
}
// hata varsa göster
catch(PDOException $exception){
 die('HATA: ' . $exception->getMessage());
}
?>