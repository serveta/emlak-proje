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
 // kaydın id bilgisini al
 $id=isset($_GET['id']) ? $_GET['id'] : die('HATA: Id bilgisi bulunamadı.');
 

 //güncelleme sorgusu
 $sorgu = "UPDATE kullanicilar SET onay='2' WHERE id = ?";
 $stmt = $con->prepare($sorgu);
 $stmt->bindParam(1, $id);

 // sorguyu çalıştır
 if($stmt->execute()){
 //kullanıcıya kaydın onaylandığını bildir
	header('Location: onay.php?islem=onaylandi');
}else{//onaylanmadığını bildir
	header('Location: onay.php?islem=onaylanmadi');
}
}
// hata varsa göster
catch(PDOException $exception){
 die('HATA: ' . $exception->getMessage());
}
?>
