<?php 
include "header.php";
 if ($_SESSION["kullanici_loginkey"] == "") {
 // oturum açılmamışsa login.php sayfasına git
 header("Location: index.php");
 }
 // veritabanı bağlantı dosyasını dahil et
 include 'config/vtabani.php';
 
try {
 // kaydın id bilgisini al
 $id=isset($_GET['id']) ? $_GET['id'] : die('HATA: Id bilgisi bulunamadı.');
 
 // silinecek kayıt bilgilerini oku
// seçme sorgusunu hazırla
$sorgu = "SELECT id, resim, resim_iki, resim_uc, resim_dort FROM urunler WHERE id = ? LIMIT 0,1";
$stmt = $con->prepare( $sorgu );
// id parametresini bağla (? işaretini id değeri ile değiştir)
$stmt->bindParam(1, $id);
// sorguyu çalıştır
$stmt->execute();
$kayit = $stmt->fetch(PDO::FETCH_ASSOC);
// okunan resim bilgilerini bir değişkene kaydet
$resim = $kayit['resim'];
$resim_iki = $kayit['resim_iki'];
$resim_uc = $kayit['resim_uc'];
$resim_dort = $kayit['resim_dort'];
 
 // silme sorguları...
 $sorgu = "DELETE FROM urunler WHERE id = ?";
 $stmt = $con->prepare($sorgu);
 $stmt->bindParam(1, $id);
 
 $sorgu2 = "DELETE FROM evbilgi WHERE ev_urun_id = ?";
 $stmt2 = $con->prepare($sorgu2);
 $stmt2->bindParam(1, $id);
 
 $sorgu3 = "DELETE FROM arsabilgi WHERE arsa_urun_id = ?";
 $stmt3 = $con->prepare($sorgu3);
 $stmt3->bindParam(1, $id);

 // sorguyu çalıştır
 if($stmt->execute() && ($stmt2->execute() || $stmt3->execute())){
 // kayıt listeleme sayfasına yönlendir
 // ve kullanıcıya kaydın silindiğini
 // kayda ait resim varsa sunucudan sil
if(!empty($resim)){
 $silinecek_resim = "content/images/".$resim;
 if (file_exists($silinecek_resim)) unlink($silinecek_resim);
}
if(!empty($resim_iki)){
 $silinecek_resim = "content/images/".$resim_iki;
 if (file_exists($silinecek_resim)) unlink($silinecek_resim);
}
if(!empty($resim_uc)){
 $silinecek_resim = "content/images/".$resim_uc;
 if (file_exists($silinecek_resim)) unlink($silinecek_resim);
}
if(!empty($resim_dort)){
 $silinecek_resim = "content/images/".$resim_dort;
 if (file_exists($silinecek_resim)) unlink($silinecek_resim);
}
 header('Location: ilanlarim.php?islem=silindi');
 } // veya silinemediğini bildir
 else{
 header('Location: ilanlarim.php?islem=silinemedi');
 }
}
// hata varsa göster
catch(PDOException $exception){
 die('HATA: ' . $exception->getMessage());
}
?>
