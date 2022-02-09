<?php include "../header.php"; ?>
<div class="container">
 <div class="page-header">
 <h1>İlan Listesi</h1>
 </div>
 <!-- Kayıtları listeleyecek PHP kodları bu alana eklenecek -->
 <?php
 // veritabanı bağlantı dosyasını çağır
 include '../../config/vtabani.php';

 // gelen kategori parametresini oku
 $id = isset($_GET['id']) ? $_GET['id'] : "";

 // kategoriye ait kayıtları seç
 $sorgu = "SELECT id, urunadi, aciklama, fiyat FROM urunler WHERE onay='1' AND kategori_id = ?
ORDER BY id DESC";
 $stmt = $con->prepare($sorgu);
 // Id parametresini bağla
 $stmt->bindParam(1, $id);
 $stmt->execute();

 // geriye dönen kayıt sayısı
 $sayi = $stmt->rowCount();

 echo "<a href='liste.php' class='btn btn-danger m-b-1em'> <span
class='glyphicon glyphicon glyphicon glyphicon-list'></span> Kategori listesi</a>";
 //kayıt varsa listele
 if($sayi>0){

 // kayıtlar burada listelenecek
 echo "<table class='table table-hover table-responsive table-bordered'>";
//tablo başlangıcı
 //tablo başlıkları
 echo "<tr>";
 echo "<th>ID</th>";
 echo "<th>Başlık</th>";
 echo "<th>Açıklama</th>";
 echo "<th>Fiyat</th>";
 echo "</tr>";

 // tablo içeriği burada yer alacak
 // tablo verilerinin okunması
 while ($kayit = $stmt->fetch(PDO::FETCH_ASSOC)){
 // tablo alanlarını değişkene dönüştürür
 // $kayit['urunadi'] => $urunadi
 extract($kayit);

 // her kayıt için yeni bir tablo satırı oluştur
 echo "<tr>";
 echo "<td>{$id}</td>";
 echo "<td>{$urunadi}</td>";
 echo "<td>{$aciklama}</td>";
 echo "<td>".number_format($fiyat, 0, ',', '.')." &#8378;</td>"; // &#8378; ==> TL işareti
 echo "</tr>";
 }

 echo "</table>"; // tablo sonu

 }
 // kayıt yoksa mesajla bildir
 else{
 echo "<div class='alert alert-danger'>Listelenecek kayıt bulunamadı.</div>";
 }
?>

 
</div> <!-- /container -->
<?php include "../footer.php"; ?>