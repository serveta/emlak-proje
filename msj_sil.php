<?php
 session_start();
 if ($_SESSION["loginkey"] == "") {
 // oturum açılmamışsa login.php sayfasına git
 header("Location: /proje/admin/login.php");
 }
?>

<?php
// veritabanı ayar dosyasını dahil et
include 'config/vtabani.php';
try {
 // kaydın id bilgisini al
 $id=isset($_GET['id']) ? $_GET['id'] : die('HATA: Id bilgisi bulunamadı.');
 
 
 // seçme sorgusunu hazırla
 $sorguSeç = "SELECT * FROM kullanicilar_mesaj WHERE k_msj_id=$id";
 $stmtSeç = $con->prepare( $sorguSeç );
 $stmtSeç->execute();
 // gelen kaydı bir değişkende sakla
 $kayit = $stmtSeç->fetch(PDO::FETCH_ASSOC);
 
 
 // silinecek kayıt bilgilerini oku
 $sorgu = "DELETE FROM kullanicilar_mesaj WHERE (k_msj_kime=".$kayit['k_msj_kime']." AND k_msj_kimden=".$kayit['k_msj_kimden']." AND k_msj_konu='".$kayit['k_msj_konu']."') OR (k_msj_kime=".$kayit['k_msj_kimden']." AND k_msj_kimden=".$kayit['k_msj_kime']." AND k_msj_konu='".$kayit['k_msj_konu']."')";
 $stmt = $con->prepare($sorgu);

 // sorguyu çalıştır
 if($stmt->execute()){
 // kayıt listeleme sayfasına yönlendir
 // ve kullanıcıya kaydın silindiğini
 header('Location: mesajlarim.php?islem=silindi');
 } // veya silinemediğini bildir
 else{
 header('Location: mesajlarim.php?islem=silinemedi');
 }
}
// hata varsa göster
catch(PDOException $exception){
 die('HATA: ' . $exception->getMessage());
}
?>
