<?php include "../header.php"; ?>

 <div class="container">
 <div class="page-header">
 <h1>Logo Güncelleme</h1>
 </div>
 <!-- Kullanıcı bilgilerini getiren PHP kodu burada yer alacak -->
 <?php
 // gelen parametre değerini oku, logo_id bilgisi...
 $logo_id=isset($_GET['logo_id']) ? $_GET['logo_id'] : die('HATA: logo_id bilgisi bulunamadı.');

 // veritabanı bağlantı dosyasını dahil et
 include '../../config/vtabani.php';

 // aktif kayıt bilgilerini oku
 try {
 // seçme sorgusunu hazırla
 $sorgu = "SELECT * FROM logo WHERE logo_id = ? LIMIT 0,1";
 $stmt = $con->prepare( $sorgu );

 // id parametresini bağla (? işaretini id değeri ile değiştir)
 $stmt->bindParam(1, $logo_id);

 // sorguyu çalıştır
 $stmt->execute();

 // okunan kayıt bilgilerini bir değişkene kaydet
 $kayit = $stmt->fetch(PDO::FETCH_ASSOC);

 // formu dolduracak değişken bilgileri
 $logo_baglanti = $kayit['logo_baglanti'];
 $logo_aciklama = $kayit['logo_aciklama'];
 }
 // hatayı göster
 catch(PDOException $exception){
 die('HATA: ' . $exception->getMessage());
 }
?>
 
 <!-- Kullanıcı bilgilerini düzeltme HTML formu burada yer alacak -->
  <!-- kaydı güncelleyecek PHP kodu burada yer alacak -->
  <?php
 // Kaydet butonu tıklanmışsa
 if($_POST){

 try{
 // güncelleme sorgusu
 // çok fazla parametre olduğundan karışmaması için
 // soru işaretleri yerine etiketler kullanacağız
 $sorgu = "UPDATE logo SET logo_baglanti=:logo_baglanti, logo_aciklama=:logo_aciklama, logo_k_durum=".$kayit['logo_k_durum']." WHERE logo_id=".$logo_id;

 // sorguyu hazırla
 $stmt = $con->prepare($sorgu);

 // gelen bilgileri değişkenlere kaydet
 $logo_aciklama=htmlspecialchars(strip_tags($_POST['logo_aciklama']));
 // yeni 'resim' alanı
 $logo_baglanti=!empty($_FILES["logo_baglanti"]["name"]) ? uniqid() . "-" . basename($_FILES["logo_baglanti"]["name"]) : "";
    if(empty($logo_baglanti)){
		$logo_baglanti = $kayit['logo_baglanti'];
		if(empty($kayit['logo_baglanti'])){
			echo "";
		}
	}else{
		$logo_baglanti=htmlspecialchars(strip_tags($logo_baglanti));
	}

 // parametreleri bağla
 $stmt->bindParam(':logo_baglanti', $logo_baglanti);
 $stmt->bindParam(':logo_aciklama', $logo_aciklama);

 // sorguyu çalıştır
 if($stmt->execute()){
	 
 // resim boş değilse ve eski resime eşit değilse yükle
if($logo_baglanti && $logo_baglanti != $kayit['logo_baglanti']){
 $hedef_klasor = "../../content/images/";
 $hedef_dosya = $hedef_klasor . $logo_baglanti;
 $dosya_turu = pathinfo($hedef_dosya, PATHINFO_EXTENSION);
 // hata mesajı
 $dosya_yukleme_hata_msj="";
 // sadece belirli dosya türlerine izin ver
$izinverilen_dosya_turleri=array("jpg", "jpeg", "png", "gif");
if(!in_array($dosya_turu, $izinverilen_dosya_turleri)){
 $dosya_yukleme_hata_msj.="<div>Sadece JPG, JPEG, PNG, GIF türündeki dosyalar
yüklenebilir.</div>";
$logo_baglanti = $kayit['logo_baglanti'];
}
// yüklenen resim dosyasının boyutunun 1 mb sınırını aşmaması için
if($_FILES['logo_baglanti']['size'] > (1024000)){
 $dosya_yukleme_hata_msj.="<div>Resim dosyasının boyutu 1 MB sınırını
aşamaz.</div>";
$logo_baglanti = $kayit['logo_baglanti'];
}
// eğer $dosya_yukleme_hata_msj boşsa
if(empty($dosya_yukleme_hata_msj)){
 // hata yok, o zaman dosya sunucuya yüklenir
 //sunucudaki eski resim dosyasını silebiliriz
 if(@unlink($hedef_klasor . $kayit['logo_baglanti'])){echo "";}else{echo "";}
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
	 
 echo "<div class='alert alert-success'>Kayıt güncellendi.</div>";
 
 }else{
 echo "<div class='alert alert-danger'>Kayıt güncellenemedi.</div>";
 }

 }
 // hata varsa göster
 catch(PDOException $exception){
 die('HATA: ' . $exception->getMessage());
 }
 }
?>
 <!-- kayıt bilgilerini güncelleyebileceğimiz HTML formu -->
 <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]."?logo_id={$logo_id}");?>" method="post" enctype="multipart/form-data">
 <table class='table table-hover table-responsive table-bordered'>
 <tr>
 <td>Logo</td>
 <td> <?php echo $logo_baglanti ? "<img src='../../content/images/{$logo_baglanti}' style='width:150px;' />" : "<img src='../../content/images/gorsel-yok.jpg' style='width:300px;'/>"; ?>
 <br/><br/>Yeni resim seçin: <input type="file" name="logo_baglanti" />
 </td>
 </tr>
 <tr>
 <td>Açıklama</td>
 <td><input type='text' name='logo_aciklama' value="<?php echo
htmlspecialchars($logo_aciklama, ENT_QUOTES); ?>" class='form-control' /></td>
 </tr>
 <tr>
 <td></td>
 <td>
 <button type="submit" class='btn btn-primary'><span class="glyphicon glyphicon-ok"></span> Kaydet</button>
 <a href='logo_liste.php' class='btn btn-danger'><span class='glyphicon glyphicon glyphicon glyphicon-list'></span> Tüm Logolar Listesi</a>
 </td>
 </tr>
 </table>
 </form>
 
 </div> <!-- container -->

 <?php include "../footer.php"; ?>