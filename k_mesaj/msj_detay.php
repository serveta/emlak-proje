<?php include "../header.php"; ?>

 <div class="container">
 <div class="page-header">
 <h1>Mesaj Bilgisi</h1>
 </div>
 <!-- mesaj bilgilerini getiren PHP kodu burada yer alacak -->
 <?php
 // gelen Id parametresini al
 // isset() bir değer olup olmadığını kontrol eden PHP fonksiyonudur
 $id=isset($_GET['id']) ? $_GET['id'] : die('HATA: Kayıt bulunamadı.');

 // veritabanı bağlantı dosyasını çağır
 include '../../config/vtabani.php';
 // aktif kayıt bilgilerini oku
 try {
 // seçme sorgusunu hazırla
 $sorgu = "SELECT * FROM admin_mesajlar WHERE msj_id = ? LIMIT 0,1";
$stmt = $con->prepare( $sorgu );


 // Id parametresini bağla
 $stmt->bindParam(1, $id);

 // sorguyu çalıştır
 $stmt->execute();

 // gelen kaydı bir değişkende sakla
 $kayit = $stmt->fetch(PDO::FETCH_ASSOC);

 // tabloya yazılacak bilgileri değişkenlere doldur
 $msj_isim=$kayit['msj_isim'];
$msj_eposta=$kayit['msj_eposta'];
$msj_konu=$kayit['msj_konu'];
$msj_mesaj=$kayit['msj_mesaj'];
 }
 // hatayı göster
 catch(PDOException $exception){
 die('HATA: ' . $exception->getMessage());
 }
 ?>

 <!-- mesaj bilgilerini görüntüleyen HTML tablosu burada yer alacak -->
 <!--kayıt bilgilerini görüntüleyen HTML tablosu -->
 <table class='table table-hover table-responsive table-bordered'>
 <tr>
 <td><b>Mesaj kimden</b></td><td><?php echo $msj_isim; ?></td>
 </tr>
 <tr>
 <td style="width:130px;"><b>E-Posta adresi</b></td><td><?php echo $msj_eposta; ?></td>
 </tr>
 <tr>
 <td><b>Konu</b></td><td><?php echo $msj_konu; ?></td>
 </tr>
 <tr>
 <td><b>Mesaj</b></td><td><?php echo $msj_mesaj; ?></td>
 </tr>
 <tr>
 <td></td>
 <td> 
 <a href='#' onclick='silme_onay(<?php echo $id ?>);' class='btn btn-danger'> <span class='glyphicon glyphicon glyphicon-remove-circle'></span> Bu mesajı sil</a>
 <a href='liste.php' class='btn btn-warning'> <span class='glyphicon glyphicon glyphicon-list'></span> Mesajlara Dön</a> 
 </td>
 </tr>
 </table>
 </div> <!-- container -->

 <?php include "../footer.php"; ?>
 
 <!-- Kayıt silme onay kodları bu alana eklenecek -->
<script type='text/javascript'>
 // kayıt silme işlemini onayla
 function silme_onay( msj_id ){

 var cevap = confirm('Kaydı silmek istiyor musunuz?');
 if (cevap){
 // kullanıcı evet derse,
 // id bilgisini sil.php sayfasına yönlendirir
 window.location = 'sil.php?id=' + msj_id;
 }
 }
</script>