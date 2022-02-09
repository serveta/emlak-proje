<?php include "../header.php"; ?>
<div class="container">
 <div class="page-header">
 <h1>Slider Yükle</h1>
 </div>
 <!-- PHP kayıt ekleme kodları burada yer alacak -->
 <?php
 if($_POST){
 // veritabanı yapılandırma dosyasını dahil et
 include '../../config/vtabani.php';
 try{
 // kayıt ekleme sorgusu
 $sorgu = "INSERT INTO slider SET slider_baslik=:slider_baslik, slider_aciklama=:slider_aciklama, slider_baglanti=:slider_baglanti, slider_k_durum='0'";
 // sorguyu hazırla
 $stmt = $con->prepare($sorgu);
 // post edilen değerler
 $slider_baslik = htmlspecialchars(strip_tags($_POST['slider_baslik']));
 $slider_aciklama=htmlspecialchars(strip_tags($_POST['slider_aciklama']));
	// yeni 'resim' alanı
	$slider_baglanti=!empty($_FILES["slider_baglanti"]["name"]) ? uniqid() . "-" .
	basename($_FILES["slider_baglanti"]["name"]) : "";
	$slider_baglanti=htmlspecialchars(strip_tags($slider_baglanti));
 // parametreleri bağla
 $stmt->bindParam(':slider_baslik', $slider_baslik);
 $stmt->bindParam(':slider_aciklama', $slider_aciklama);
 $stmt->bindParam(':slider_baglanti', $slider_baglanti);
 
 // sorguyu çalıştır
 if($stmt->execute()){
 
  // slider_baglanti boş değilse yükle
if($slider_baglanti){
 $hedef_klasor = "../../content/images/";
 $hedef_dosya = $hedef_klasor . $slider_baglanti;
 $dosya_turu = pathinfo($hedef_dosya, PATHINFO_EXTENSION);
 // hata mesajı
 $dosya_yukleme_hata_msj="";
 // sadece belirli dosya türlerine izin ver
$izinverilen_dosya_turleri=array("jpg", "jpeg", "png", "gif");
if(!in_array($dosya_turu, $izinverilen_dosya_turleri)){
 $dosya_yukleme_hata_msj.="<div>Sadece JPG, JPEG, PNG, GIF türündeki dosyalar
yüklenebilir.</div>";
$slider_baglanti = "";
}
// aynı isimde başka bir slider_baglanti var mı?
if(file_exists($hedef_dosya)){
 $dosya_yukleme_hata_msj.="<div>Aynı isimde başka bir resim dosyası
var.</div>";
$slider_baglanti = "";
}
// yüklenen resim dosyasının boyutunun 1 mb sınırını aşmaması için
if($_FILES['slider_baglanti']['size'] > (1024000)){
 $dosya_yukleme_hata_msj.="<div>Resim dosyasının boyutu 1 MB sınırını
aşamaz.</div>";
$slider_baglanti = "";
}
// eğer $dosya_yukleme_hata_msj boşsa
if(empty($dosya_yukleme_hata_msj)){
 // hata yok, o zaman dosya sunucuya yüklenir
 if(move_uploaded_file($_FILES["slider_baglanti"]["tmp_name"], $hedef_dosya)){
 // dosya başarıyla yüklendi
 }
 else{
 echo "<div class='alert alert-danger'>";
 echo "<div>Dosya yüklenemedi.</div>";
 echo "<div>Dosyayı yüklemek için kaydı güncelleyin.</div>";
 echo "</div>";
 }
}
// eğer $dosya_yukleme_hata_msj boş değilse
else{
 // hata var, o halde kullanıcıyı bilgilendir
 echo "<div class='alert alert-danger'>";
 echo "<div>{$dosya_yukleme_hata_msj}</div>";
 echo "<div>Dosyayı yüklemek için kaydı güncelleyin.</div>";
 echo "</div>";
}
}
 
 echo "<div class='alert alert-success'>Slider kaydedildi.</div>";
 
 }else{
 echo "<div class='alert alert-danger'>Slider kaydedilemedi.</div>";
 }
 }
 // hatayı göster
 catch(PDOException $exception){
 die('ERROR: ' . $exception->getMessage());
 }
 }
?>
 
 <!-- slider için kullanılacak html formu burada yer alacak -->
 <!-- slider bilgilerini girmek için kullanılacak html formu -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
 <table class='table table-hover table-responsive table-bordered'>
 <tr>
 <td>Yeni Slider</td>
 <td><input type="file" name="slider_baglanti" /></td>
 </tr>
 <tr>
 <td>Başlık</td>
 <td><input type='text' name='slider_baslik' class='form-control' /></td>
 </tr>
 <tr>
 <td>Açıklama</td>
 <td><input type='text' name='slider_aciklama' class='form-control' /></td>
 </tr>
 <tr>
 <td></td>
 <td>
 <input type='submit' value='Kaydet' class='btn btn-primary' />
 <a href='slider_liste.php' class='btn btn-danger'>Tüm Slider Listesi</a>
 </td>
 </tr>
 </table>
</form>
</div> <!-- container -->
<?php include "../footer.php"; ?>