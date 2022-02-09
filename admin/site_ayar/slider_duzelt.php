<?php include "../header.php"; ?>

 <div class="container">
 <div class="page-header">
 <h1>Slider Güncelleme</h1>
 </div>
 <!-- Kullanıcı bilgilerini getiren PHP kodu burada yer alacak -->
 <?php
 // gelen parametre değerini oku, slider_id bilgisi...
 $slider_id=isset($_GET['slider_id']) ? $_GET['slider_id'] : die('HATA: slider_id bilgisi bulunamadı.');

 // veritabanı bağlantı dosyasını dahil et
 include '../../config/vtabani.php';

 // aktif kayıt bilgilerini oku
 try {
 // seçme sorgusunu hazırla
 $sorgu = "SELECT * FROM slider WHERE slider_id = ? LIMIT 0,1";
 $stmt = $con->prepare( $sorgu );

 // id parametresini bağla (? işaretini id değeri ile değiştir)
 $stmt->bindParam(1, $slider_id);

 // sorguyu çalıştır
 $stmt->execute();

 // okunan kayıt bilgilerini bir değişkene kaydet
 $kayit = $stmt->fetch(PDO::FETCH_ASSOC);

 // formu dolduracak değişken bilgileri
 $slider_baglanti = $kayit['slider_baglanti'];
 $slider_baslik = $kayit['slider_baslik'];
 $slider_aciklama = $kayit['slider_aciklama'];
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
 $sorgu = "UPDATE slider SET slider_baglanti=:slider_baglanti, slider_baslik=:slider_baslik, slider_aciklama=:slider_aciklama, slider_k_durum=".$kayit['slider_k_durum']." WHERE slider_id=".$slider_id;

 // sorguyu hazırla
 $stmt = $con->prepare($sorgu);

 // gelen bilgileri değişkenlere kaydet
 $slider_baslik=htmlspecialchars(strip_tags($_POST['slider_baslik']));
 $slider_aciklama=htmlspecialchars(strip_tags($_POST['slider_aciklama']));
 // yeni 'resim' alanı
 $slider_baglanti=!empty($_FILES["slider_baglanti"]["name"]) ? uniqid() . "-" . basename($_FILES["slider_baglanti"]["name"]) : "";
    if(empty($slider_baglanti)){
		$slider_baglanti = $kayit['slider_baglanti'];
		if(empty($kayit['slider_baglanti'])){
			echo "";
		}
	}else{
		$slider_baglanti=htmlspecialchars(strip_tags($slider_baglanti));
	}

 // parametreleri bağla
 $stmt->bindParam(':slider_baslik', $slider_baslik);
 $stmt->bindParam(':slider_baglanti', $slider_baglanti);
 $stmt->bindParam(':slider_aciklama', $slider_aciklama);

 // sorguyu çalıştır
 if($stmt->execute()){
	 
 // resim boş değilse ve eski resime eşit değilse yükle
if($slider_baglanti && $slider_baglanti != $kayit['slider_baglanti']){
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
$slider_baglanti = $kayit['slider_baglanti'];
}
// yüklenen resim dosyasının boyutunun 1 mb sınırını aşmaması için
if($_FILES['slider_baglanti']['size'] > (1024000)){
 $dosya_yukleme_hata_msj.="<div>Resim dosyasının boyutu 1 MB sınırını
aşamaz.</div>";
$slider_baglanti = $kayit['slider_baglanti'];
}
// eğer $dosya_yukleme_hata_msj boşsa
if(empty($dosya_yukleme_hata_msj)){
 // hata yok, o zaman dosya sunucuya yüklenir
 //sunucudaki eski resim dosyasını silebiliriz
 if(@unlink($hedef_klasor . $kayit['slider_baglanti'])){echo "";}else{echo "";}
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
 <!-- kayıt bilgilerini güncelleyebileceğim HTML formu -->
 <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]."?slider_id={$slider_id}");?>" method="post" enctype="multipart/form-data">
 <table class='table table-hover table-responsive table-bordered'>
 <tr>
 <td>Slider</td>
 <td> <?php echo $slider_baglanti ? "<img src='../../content/images/{$slider_baglanti}' style='width:150px;' />" : "<img src='../../content/images/gorsel-yok.jpg' style='width:300px;'/>"; ?>
 <br/><br/>Yeni resim seçin: <input type="file" name="slider_baglanti" />
 </td>
 </tr>
 <tr>
 <td>Başlık</td>
 <td><input type='text' name='slider_baslik' value="<?php echo htmlspecialchars($slider_baslik, ENT_QUOTES); ?>" class='form-control' /></td>
 </tr>
 <tr>
 <td>Açıklama</td>
 <td><input type='text' name='slider_aciklama' value="<?php echo htmlspecialchars($slider_aciklama, ENT_QUOTES); ?>" class='form-control' /></td>
 </tr>
 <tr>
 <td></td>
 <td>
 <button type="submit" class='btn btn-primary'><span class="glyphicon glyphicon-ok"></span> Kaydet</button>
 <a href='slider_liste.php' class='btn btn-danger'><span class='glyphicon glyphicon glyphicon glyphicon-list'></span> Tüm Slider Listesi</a>
 </td>
 </tr>
 </table>
 </form>
 
 </div> <!-- container -->

 <?php include "../footer.php"; ?>