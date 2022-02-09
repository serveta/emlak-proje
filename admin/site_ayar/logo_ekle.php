<?php include "../header.php"; ?>
<div class="container">
 <div class="page-header">
 <h1>Logo Yükle</h1>
 </div>
 <!-- PHP kayıt ekleme kodları burada yer alacak -->
 <?php
 if($_POST){
 // veritabanı yapılandırma dosyasını dahil et
 include '../../config/vtabani.php';
 try{
 // kayıt ekleme sorgusu
 $sorgu = "INSERT INTO logo SET logo_aciklama=:logo_aciklama, logo_baglanti=:logo_baglanti, logo_k_durum='0'";
 // sorguyu hazırla
 $stmt = $con->prepare($sorgu);
 // post edilen değerler
 $logo_aciklama=htmlspecialchars(strip_tags($_POST['logo_aciklama']));
	// yeni 'resim' alanı
	$logo_baglanti=!empty($_FILES["logo_baglanti"]["name"]) ? uniqid() . "-" .
	basename($_FILES["logo_baglanti"]["name"]) : "";
	$logo_baglanti=htmlspecialchars(strip_tags($logo_baglanti));
 // parametreleri bağla
 $stmt->bindParam(':logo_aciklama', $logo_aciklama);
 $stmt->bindParam(':logo_baglanti', $logo_baglanti);
 
 // sorguyu çalıştır
 if($stmt->execute()){
 
  // logo_baglanti boş değilse yükle
if($logo_baglanti){
 $hedef_klasor = "../../content/images/";
 $hedef_dosya = $hedef_klasor . $logo_baglanti;
 $dosya_turu = pathinfo($hedef_dosya, PATHINFO_EXTENSION);
 // hata mesajı
 $dosya_yukleme_hata_msj="";
 // sadece belirli dosya türlerine izin ver
$izinverilen_dosya_turleri=array("jpg", "jpeg", "png", "gif");
if(!in_array($dosya_turu, $izinverilen_dosya_turleri)){
 $dosya_yukleme_hata_msj.="<div>Sadece JPG, JPEG, PNG, GIF türündeki dosyalar yüklenebilir.</div>";
$logo_baglanti = "";
}
// aynı isimde başka bir logo_baglanti var mı?
if(file_exists($hedef_dosya)){
 $dosya_yukleme_hata_msj.="<div>Aynı isimde başka bir resim dosyası var.</div>";
$logo_baglanti = "";
}
// yüklenen resim dosyasının boyutunun 1 mb sınırını aşmaması için
if($_FILES['logo_baglanti']['size'] > (1024000)){
 $dosya_yukleme_hata_msj.="<div>Resim dosyasının boyutu 1 MB sınırını aşamaz.</div>";
$logo_baglanti = "";
}
// eğer $dosya_yukleme_hata_msj boşsa
if(empty($dosya_yukleme_hata_msj)){
 // hata yok, o zaman dosya sunucuya yüklenir
 if(move_uploaded_file($_FILES["logo_baglanti"]["tmp_name"], $hedef_dosya)){
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
 
 echo "<div class='alert alert-success'>Logo kaydedildi.</div>";
 
 }else{
 echo "<div class='alert alert-danger'>Logo kaydedilemedi.</div>";
 }
 }
 // hatayı göster
 catch(PDOException $exception){
 die('ERROR: ' . $exception->getMessage());
 }
 }
?>
 
 <!-- Logo için kullanılacak html formu burada yer alacak -->
 <!-- Logo bilgilerini girmek için kullanılacak html formu -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
 <table class='table table-hover table-responsive table-bordered'>
 <tr>
 <td>Logo</td>
 <td><input type="file" name="logo_baglanti" /></td>
 </tr>
 <tr>
 <td>Açıklama</td>
 <td><input type='text' name='logo_aciklama' class='form-control' /></td>
 </tr>
 <tr>
 <td></td>
 <td>
 <input type='submit' value='Kaydet' class='btn btn-primary' />
 <a href='logo_liste.php' class='btn btn-danger'>Tüm Logolar Listesi</a>
 </td>
 </tr>
 </table>
</form>
</div> <!-- container -->
<?php include "../footer.php"; ?>