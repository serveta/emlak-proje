<?php 
include "header.php";
 if ($_SESSION["kullanici_loginkey"] == "") {
 // oturum açılmamışsa login.php sayfasına git
 header("Location: index.php");
 }
 
 // veritabanı yapılandırma dosyasını dahil et
 include 'config/vtabani.php';
 
 try {
 // seçme sorgusunu hazırla
 $sorgu = "SELECT id FROM kullanicilar WHERE eposta = ? LIMIT 0,1";
 $stmt = $con->prepare( $sorgu );

 // eposta parametresini bağla (? işaretini $_SESSION["kullanici_loginkey"] değeri ile değiştir)
 $stmt->bindParam(1, $_SESSION["kullanici_loginkey"]);

 // sorguyu çalıştır
 $stmt->execute();

 // okunan kayıt bilgilerini bir değişkene kaydet
 $kayit = $stmt->fetch(PDO::FETCH_ASSOC);

 // formu dolduracak değişken bilgileri
 $kullanici_id= $kayit['id'];
 }
 // hatayı göster
 catch(PDOException $exception){
 die('HATA: ' . $exception->getMessage());
 }
 
if($_POST){
 try{
 // kayıt ekleme sorgusu
$sorgu = "INSERT INTO urunler SET urunadi=:urunadi, il_id=:il_id,
ilce_id=:ilce_id, evarsa_id=:evarsa_id, aciklama=:aciklama,
fiyat=:fiyat, giris_tarihi=:giris_tarihi, resim=:resim, resim_iki=:resim_iki, resim_uc=:resim_uc, resim_dort=:resim_dort, kategori_id=:kategori_id";
// sorguyu hazırla
$stmt = $con->prepare($sorgu);

// post edilen değerler
$urunadi=htmlspecialchars(strip_tags($_POST['urunadi']));
$il_id=htmlspecialchars(strip_tags($_POST['il_id']));
$ilce_id=htmlspecialchars(strip_tags($_POST['ilce_id']));
//Arsa eklediğimizi ilkten seçtiğimiz için $evarsa_id zaten 2 olmak zorunda
$evarsa_id=2;
$aciklama=htmlspecialchars(strip_tags($_POST['aciklama']));
$fiyat=htmlspecialchars(strip_tags($_POST['fiyat']));
// yeni 'resim' alanı
$resim=!empty($_FILES["resim"]["name"]) ? uniqid() . "-" .
basename($_FILES["resim"]["name"]) : "";
$resim=htmlspecialchars(strip_tags($resim));

$resim_iki=!empty($_FILES["resim_iki"]["name"]) ? uniqid() . "-" .
basename($_FILES["resim_iki"]["name"]) : "";
$resim_iki=htmlspecialchars(strip_tags($resim_iki));

$resim_uc=!empty($_FILES["resim_uc"]["name"]) ? uniqid() . "-" .
basename($_FILES["resim_uc"]["name"]) : "";
$resim_uc=htmlspecialchars(strip_tags($resim_uc));

$resim_dort=!empty($_FILES["resim_dort"]["name"]) ? uniqid() . "-" .
basename($_FILES["resim_dort"]["name"]) : "";
$resim_dort=htmlspecialchars(strip_tags($resim_dort));

$kategori_id=htmlspecialchars(strip_tags($_POST['kategori_id']));
// parametreleri bağla
$stmt->bindParam(':urunadi', $urunadi);
$stmt->bindParam(':il_id', $il_id);
$stmt->bindParam(':ilce_id', $ilce_id);
$stmt->bindParam(':evarsa_id', $evarsa_id);
$stmt->bindParam(':aciklama', $aciklama);
$stmt->bindParam(':fiyat', $fiyat);
$stmt->bindParam(':resim', $resim);
$stmt->bindParam(':resim_iki', $resim_iki);
$stmt->bindParam(':resim_uc', $resim_uc);
$stmt->bindParam(':resim_dort', $resim_dort);
$stmt->bindParam(':kategori_id', $kategori_id);
// ilanın veritabanına kaydedildiği tarihi belirt
$giris_tarihi=date('Y-m-d H:i:s');
$stmt->bindParam(':giris_tarihi', $giris_tarihi);

 // sorguyu çalıştır
 if($stmt->execute()){
//execute edildikten sonra bana ilanlar tablosuna eklenen kaydın ID sini vermeli ki bende arsa bilgilerini 
//bana verilen ID üzerine farklı bir tabloya kayıt edebileyim
 $son_kayit_id = $con->lastInsertId();
	
	//BURAYA sorgu 2 ile php pdo id alma kodu ile birlikte arsabilgi tablosuna veri girişi yapacağız....
	// veritabanı yapılandırma dosyasını dahil et
	include 'config/vtabani.php';
	try{
	// kayıt ekleme sorgusu
	$sorgu = "INSERT INTO arsabilgi SET arsa_urun_id=:arsa_urun_id, imar_durumu=:imar_durumu, arsa_metrekare=:arsa_metrekare,
	metrekare_fiyat=:metrekare_fiyat, ada_no=:ada_no, parsel_no=:parsel_no, pafta_no=:pafta_no, emsal=:emsal, tapu_durumu=:tapu_durumu,
	kat_karsiligi=:kat_karsiligi, arsa_krediye_uygun=:arsa_krediye_uygun, arsa_kimden=:arsa_kimden, arsa_takas=:arsa_takas";
	// sorguyu hazırla
	$stmt = $con->prepare($sorgu);
	// post edilen değerler
	$arsa_urun_id = $son_kayit_id;
	$imar_durumu=htmlspecialchars(strip_tags($_POST['imar_durumu']));
	$arsa_metrekare=htmlspecialchars(strip_tags($_POST['arsa_metrekare']));
	$metrekare_fiyat=htmlspecialchars(strip_tags($_POST['metrekare_fiyat']));
	$ada_no=htmlspecialchars(strip_tags($_POST['ada_no']));
	$parsel_no=htmlspecialchars(strip_tags($_POST['parsel_no']));
	$pafta_no=htmlspecialchars(strip_tags($_POST['pafta_no']));
	$emsal=htmlspecialchars(strip_tags($_POST['emsal']));
	$tapu_durumu=htmlspecialchars(strip_tags($_POST['tapu_durumu']));
	$kat_karsiligi=htmlspecialchars(strip_tags($_POST['kat_karsiligi']));
	$arsa_krediye_uygun=htmlspecialchars(strip_tags($_POST['arsa_krediye_uygun']));
	$arsa_kimden=$kullanici_id;
	$arsa_takas=htmlspecialchars(strip_tags($_POST['arsa_takas']));
	// parametreleri bağla
	$stmt->bindParam(':arsa_urun_id', $arsa_urun_id);
	$stmt->bindParam(':imar_durumu', $imar_durumu);
	$stmt->bindParam(':arsa_metrekare', $arsa_metrekare);
	$stmt->bindParam(':metrekare_fiyat', $metrekare_fiyat);
	$stmt->bindParam(':ada_no', $ada_no);
	$stmt->bindParam(':parsel_no', $parsel_no);
	$stmt->bindParam(':pafta_no', $pafta_no);
	$stmt->bindParam(':emsal', $emsal);
	$stmt->bindParam(':tapu_durumu', $tapu_durumu);
	$stmt->bindParam(':kat_karsiligi', $kat_karsiligi);
	$stmt->bindParam(':arsa_krediye_uygun', $arsa_krediye_uygun);
	$stmt->bindParam(':arsa_kimden', $arsa_kimden);
	$stmt->bindParam(':arsa_takas', $arsa_takas);
	//sorguyu çalıştır
	$stmt->execute();
	//İlan kaydedildi mesajı
	echo "<div class='alert alert-success'>İlan kaydedildi.</div>";
	}// hatayı göster
	catch(PDOException $exception){
	die('ERROR: ' . $exception->getMessage());
	}
 // resim boş değilse yükle
if($resim){
 $hedef_klasor = "content/images/";
 $hedef_dosya = $hedef_klasor . $resim;
 $dosya_turu = pathinfo($hedef_dosya, PATHINFO_EXTENSION);
 // hata mesajı
 $dosya_yukleme_hata_msj="";
 // sadece belirli dosya türlerine izin ver
$izinverilen_dosya_turleri=array("jpg", "jpeg", "png", "gif");
if(!in_array($dosya_turu, $izinverilen_dosya_turleri)){
 $dosya_yukleme_hata_msj.="<div>Sadece JPG, JPEG, PNG, GIF türündeki dosyalar yüklenebilir.</div>";
$resim = "";
}
// aynı isimde başka bir resim var mı?
if(file_exists($hedef_dosya)){
 $dosya_yukleme_hata_msj.="<div>Aynı isimde başka bir resim dosyası var.</div>";
$resim = "";
}
// yüklenen resim dosyasının boyutunun 1 mb sınırını aşmaması için
if($_FILES['resim']['size'] > (1024000)){
 $dosya_yukleme_hata_msj.="<div>Resim dosyasının boyutu 1 MB sınırını aşamaz.</div>";
$resim = "";
}
// eğer $dosya_yukleme_hata_msj boşsa
if(empty($dosya_yukleme_hata_msj)){
 // hata yok, o zaman dosya sunucuya yüklenir
 if(move_uploaded_file($_FILES["resim"]["tmp_name"], $hedef_dosya)){
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
 // resim_iki boş değilse yükle
if($resim_iki){
 $hedef_klasor = "content/images/";
 $hedef_dosya = $hedef_klasor . $resim_iki;
 $dosya_turu = pathinfo($hedef_dosya, PATHINFO_EXTENSION);
 // hata mesajı
 $dosya_yukleme_hata_msj="";
 // sadece belirli dosya türlerine izin ver
$izinverilen_dosya_turleri=array("jpg", "jpeg", "png", "gif");
if(!in_array($dosya_turu, $izinverilen_dosya_turleri)){
 $dosya_yukleme_hata_msj.="<div>Sadece JPG, JPEG, PNG, GIF türündeki dosyalar
yüklenebilir.</div>";
$resim_iki = "";
}
// aynı isimde başka bir resim var mı?
if(file_exists($hedef_dosya)){
 $dosya_yukleme_hata_msj.="<div>Aynı isimde başka bir resim dosyası
var.</div>";
$resim_iki = "";
}
// yüklenen resim dosyasının boyutunun 1 mb sınırını aşmaması için
if($_FILES['resim_iki']['size'] > (1024000)){
 $dosya_yukleme_hata_msj.="<div>Resim dosyasının boyutu 1 MB sınırını
aşamaz.</div>";
$resim_iki = "";
}
// eğer $dosya_yukleme_hata_msj boşsa
if(empty($dosya_yukleme_hata_msj)){
 // hata yok, o zaman dosya sunucuya yüklenir
 if(move_uploaded_file($_FILES["resim_iki"]["tmp_name"], $hedef_dosya)){
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
 // resim_uc boş değilse yükle
if($resim_uc){
 $hedef_klasor = "content/images/";
 $hedef_dosya = $hedef_klasor . $resim_uc;
 $dosya_turu = pathinfo($hedef_dosya, PATHINFO_EXTENSION);
 // hata mesajı
 $dosya_yukleme_hata_msj="";
 // sadece belirli dosya türlerine izin ver
$izinverilen_dosya_turleri=array("jpg", "jpeg", "png", "gif");
if(!in_array($dosya_turu, $izinverilen_dosya_turleri)){
 $dosya_yukleme_hata_msj.="<div>Sadece JPG, JPEG, PNG, GIF türündeki dosyalar
yüklenebilir.</div>";
$resim_uc = "";
}
// aynı isimde başka bir resim var mı?
if(file_exists($hedef_dosya)){
 $dosya_yukleme_hata_msj.="<div>Aynı isimde başka bir resim dosyası
var.</div>";
$resim_uc = "";
}
// yüklenen resim dosyasının boyutunun 1 mb sınırını aşmaması için
if($_FILES['resim_uc']['size'] > (1024000)){
 $dosya_yukleme_hata_msj.="<div>Resim dosyasının boyutu 1 MB sınırını
aşamaz.</div>";
$resim_uc = "";
}
// eğer $dosya_yukleme_hata_msj boşsa
if(empty($dosya_yukleme_hata_msj)){
 // hata yok, o zaman dosya sunucuya yüklenir
 if(move_uploaded_file($_FILES["resim_uc"]["tmp_name"], $hedef_dosya)){
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
 // resim_dort boş değilse yükle
if($resim_dort){
 $hedef_klasor = "content/images/";
 $hedef_dosya = $hedef_klasor . $resim_dort;
 $dosya_turu = pathinfo($hedef_dosya, PATHINFO_EXTENSION);
 // hata mesajı
 $dosya_yukleme_hata_msj="";
 // sadece belirli dosya türlerine izin ver
$izinverilen_dosya_turleri=array("jpg", "jpeg", "png", "gif");
if(!in_array($dosya_turu, $izinverilen_dosya_turleri)){
 $dosya_yukleme_hata_msj.="<div>Sadece JPG, JPEG, PNG, GIF türündeki dosyalar
yüklenebilir.</div>";
$resim_dort = "";
}
// aynı isimde başka bir resim var mı?
if(file_exists($hedef_dosya)){
 $dosya_yukleme_hata_msj.="<div>Aynı isimde başka bir resim dosyası
var.</div>";
$resim_dort = "";
}
// yüklenen resim dosyasının boyutunun 1 mb sınırını aşmaması için
if($_FILES['resim_dort']['size'] > (1024000)){
 $dosya_yukleme_hata_msj.="<div>Resim dosyasının boyutu 1 MB sınırını
aşamaz.</div>";
$resim_dort = "";
}
// eğer $dosya_yukleme_hata_msj boşsa
if(empty($dosya_yukleme_hata_msj)){
 // hata yok, o zaman dosya sunucuya yüklenir
 if(move_uploaded_file($_FILES["resim_dort"]["tmp_name"], $hedef_dosya)){
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
 }else{
 echo "<div class='alert alert-danger'>İlan kaydedilemedi.</div>";
 }
 }
 // hatayı göster
 catch(PDOException $exception){
 die('ERROR: ' . $exception->getMessage());
 }
}
?>

<div class="container p-5">
 <!-- Başlık burada yer alacak -->
 <h1 class="text-center baslik">Ücretsiz İlan Ver</h1>
<p class="text-center p-4">EmlakProje - Arsa İlanı</p>
<hr> 
 <div class="row mt-4">
 <div class="col-md-4">
 <h2 class="baslik">Arsa İlan Formu</h2>
 </div>
 <div class="col-md-8">
 <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" name="arsailanver" enctype="multipart/form-data">
 <div class="form-group">
 <label>İlan Başlığı</label>
 <input type='text' name='urunadi' class='form-control' />
 </div>
 <div class="form-group">
 <label for="exampleInputText2">Açıklama</label>
 <textarea name='aciklama' class='form-control'></textarea>
 </div>
 <div class="form-group">
 <label for="exampleInputText2">Fiyat</label>
 <input type='text' name='fiyat' class='form-control' />
 </div>
 <div class="form-group">
 <label for="exampleInputText2">Kategori</label>
 <?php
 // veritabanı yapılandırma dosyasını dahil et
 include 'config/vtabani.php';
 // kayıt listeleme sorgusu
 $sorgu='SELECT id, kategoriadi FROM kategoriler';
 $stmt = $con->prepare($sorgu); // sorguyu hazırla
 $stmt->execute(); // sorguyu çalıştır
 $veri = $stmt->fetchAll(PDO::FETCH_ASSOC); // tablo verilerini oku
 ?>
 <select name='kategori_id' class='form-control'>
 <?php foreach ($veri as $kayit) { ?>
 <option value="<?php echo $kayit["id"] ?>">
 <?php echo $kayit["kategoriadi"] ?>
 </option>
 <?php } ?>
 </select>
 </div>
 <div class="form-group">
 <label for="exampleInputText2">İl</label>
 <?php
 // kayıt listeleme sorgusu
 $sorgu='SELECT id, sehir FROM il';
 $stmt = $con->prepare($sorgu); // sorguyu hazırla
 $stmt->execute(); // sorguyu çalıştır
 $veri = $stmt->fetchAll(PDO::FETCH_ASSOC); // tablo verilerini oku
 ?>
 <select name='il_id' id='il' class='form-control'>
 <option>İl Seçiniz</option>
 <?php foreach ($veri as $kayit) { ?>
 <option value="<?php echo $kayit["id"] ?>">
 <?php echo $kayit["sehir"] ?>
 </option>
 <?php } ?>
 </select>
 </div>
 <div class="form-group">
 <label for="exampleInputText2">İlçe</label>
 <select name='ilce_id' id='ilce' class='form-control'>
 <option>İlçe seçmek için önce il seçiniz...</option>
 </select>
 </div>
 <div class="form-group">
 <label for="exampleInputText2">Resim-1</label><br/>
 <input type="file" name="resim" />
 </div>
 <div class="form-group">
 <label for="exampleInputText2">Resim-2</label><br/>
 <input type="file" name="resim_iki" />
 </div>
 <div class="form-group">
 <label for="exampleInputText2">Resim-3</label><br/>
 <input type="file" name="resim_uc" />
 </div>
 <div class="form-group">
 <label for="exampleInputText2">Resim-4</label><br/>
 <input type="file" name="resim_dort" />
 </div>
 <div class="form-group">
 <label for="exampleInputText2">İmar Durumu</label>
 <input type='text' name='imar_durumu' class='form-control' />
 </div>
 <div class="form-group">
 <label for="exampleInputText2">Metrekare</label>
 <input type='text' name='arsa_metrekare' class='form-control' />
 </div>
 <div class="form-group">
 <label for="exampleInputText2">Metrekare Fiyatı</label>
 <input type='text' name='metrekare_fiyat' class='form-control' />
 </div>
 <div class="form-group">
 <label for="exampleInputText2">Ada no</label>
 <input type='text' name='ada_no' class='form-control' />
 </div>
 <div class="form-group">
 <label for="exampleInputText2">Parsel no</label>
 <input type='text' name='parsel_no' class='form-control' />
 </div>
 <div class="form-group">
 <label for="exampleInputText2">Pafta No</label>
 <input type='text' name='pafta_no' class='form-control' />
 </div>
 <div class="form-group">
 <label for="exampleInputText2">Emsal</label>
 <input type='text' name='emsal' class='form-control' />
 </div>
 <div class="form-group">
 <label for="exampleInputText2">Tapu Durumu</label>
 <input type='text' name='tapu_durumu' class='form-control' />
 </div>
 <div class="form-group">
 <label for="exampleInputText2">Kat Karşılığı</label>
 <select name='kat_karsiligi' class='form-control'>
 <option value='Evet'>Evet</option>
 <option value='Hayır'>Hayır</option>
</select>
 </div>
 <div class="form-group">
 <label for="exampleInputText2">Krediye Uygun mu?</label>
 <select name='arsa_krediye_uygun' class='form-control'>
 <option value='Evet'>Evet</option>
 <option value='Hayır'>Hayır</option>
</select>
 </div>
 <div class="form-group">
 <label for="exampleInputText2">Takas</label>
 <select name='arsa_takas' class='form-control'>
 <option value='Evet'>Evet</option>
 <option value='Hayır'>Hayır</option>
</select>
 </div>
 <button type="submit" class="btn btn-success">İlan Ver</button>
 </form>
 </div>
 </div>
</div>
<?php include "footer.php"; ?>

<script type="text/javascript">
// ilçe seçimini kısıtlamak için script kodumuz
	$(document).ready(function(){
		$("#il").change(function(){
			var ilid=$(this).val();
			$.ajax({
				type:"POST",
				url:"content/ajax.php",
				data:{"il":ilid},
				success:function(e){
					$("#ilce").html(e);
				}
			});
		})
	});
</script>