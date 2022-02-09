<script src="../../content/js/jquery-3.3.1.min.js" type="text/javascript"></script>

<?php include "../header.php"; ?>
<div class="container">
 <div class="page-header">
 <h1>Yeni Ev İlanı Ekle</h1>
 </div>
 <!-- PHP kayıt ekleme kodları burada yer alacak -->
 <?php
if($_POST){
 // veritabanı yapılandırma dosyasını dahil et
 include '../../config/vtabani.php';
 try{
 // kayıt ekleme sorgusu
$sorgu = "INSERT INTO urunler SET urunadi=:urunadi, il_id=:il_id,
ilce_id=:ilce_id, evarsa_id=:evarsa_id, aciklama=:aciklama,
fiyat=:fiyat, giris_tarihi=:giris_tarihi, resim=:resim, resim_iki=:resim_iki,
resim_uc=:resim_uc, resim_dort=:resim_dort, kategori_id=:kategori_id";
// sorguyu hazırla
$stmt = $con->prepare($sorgu);

// post edilen değerler
$urunadi=htmlspecialchars(strip_tags($_POST['urunadi']));
$il_id=htmlspecialchars(strip_tags($_POST['il_id']));
$ilce_id=htmlspecialchars(strip_tags($_POST['ilce_id']));
//Ev eklediğimizi ilkten seçtiğimiz için $evarsa_id zaten 1 olmak zorunda
$evarsa_id=1;
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
// ürünün veritabanına kaydedildiği tarihi belirt
$giris_tarihi=date('Y-m-d H:i:s');
$stmt->bindParam(':giris_tarihi', $giris_tarihi);

 // sorguyu çalıştır
 if($stmt->execute()){
 //execute edildikten sonra bana ürünler tablosuna eklenen kaydın ID sini vermeli ki bende ev bilgilerini 
 //bana verilen ID üzerine farklı bir tabloya kayıt edebileyim
 $son_kayit_id = $con->lastInsertId();
	
	//BURAYA sorgu 2 ile php pdo id alma kodu ile birlikte evbilgi tablosuna veri girişi yapacağız....
	// veritabanı yapılandırma dosyasını dahil et
	include '../../config/vtabani.php';
	try{
	// kayıt ekleme sorgusu
	$sorgu = "INSERT INTO evbilgi SET ev_urun_id=:ev_urun_id, ev_tipi=:ev_tipi, ev_metrekare=:ev_metrekare, oda_sayisi=:oda_sayisi,
	bina_yasi=:bina_yasi, kat_sayisi=:kat_sayisi, isitma=:isitma, banyo_sayisi=:banyo_sayisi, esyali=:esyali, kullanim_durumu=:kullanim_durumu,
	site_icinde=:site_icinde, aidat=:aidat, ev_krediye_uygun=:ev_krediye_uygun, ev_kimden=:ev_kimden, ev_takas=:ev_takas";
	// sorguyu hazırla
	$stmt = $con->prepare($sorgu);
	// post edilen değerler
	$ev_urun_id = $son_kayit_id;
	$ev_tipi=htmlspecialchars(strip_tags($_POST['ev_tipi']));
	$ev_metrekare=htmlspecialchars(strip_tags($_POST['ev_metrekare']));
	$oda_sayisi=htmlspecialchars(strip_tags($_POST['oda_sayisi']));
	$bina_yasi=htmlspecialchars(strip_tags($_POST['bina_yasi']));
	$kat_sayisi=htmlspecialchars(strip_tags($_POST['kat_sayisi']));
	$isitma=htmlspecialchars(strip_tags($_POST['isitma']));
	$banyo_sayisi=htmlspecialchars(strip_tags($_POST['banyo_sayisi']));
	$esyali=htmlspecialchars(strip_tags($_POST['esyali']));
	$kullanim_durumu=htmlspecialchars(strip_tags($_POST['kullanim_durumu']));
	$site_icinde=htmlspecialchars(strip_tags($_POST['site_icinde']));
	$aidat=htmlspecialchars(strip_tags($_POST['aidat']));
	$ev_krediye_uygun=htmlspecialchars(strip_tags($_POST['ev_krediye_uygun']));
	$ev_kimden=htmlspecialchars(strip_tags($_POST['ev_kimden']));
	$ev_takas=htmlspecialchars(strip_tags($_POST['ev_takas']));
	// parametreleri bağla
	$stmt->bindParam(':ev_urun_id', $ev_urun_id);
	$stmt->bindParam(':ev_tipi', $ev_tipi);
	$stmt->bindParam(':ev_metrekare', $ev_metrekare);
	$stmt->bindParam(':oda_sayisi', $oda_sayisi);
	$stmt->bindParam(':bina_yasi', $bina_yasi);
	$stmt->bindParam(':kat_sayisi', $kat_sayisi);
	$stmt->bindParam(':isitma', $isitma);
	$stmt->bindParam(':banyo_sayisi', $banyo_sayisi);
	$stmt->bindParam(':esyali', $esyali);
	$stmt->bindParam(':kullanim_durumu', $kullanim_durumu);
	$stmt->bindParam(':site_icinde', $site_icinde);
	$stmt->bindParam(':aidat', $aidat);
	$stmt->bindParam(':ev_krediye_uygun', $ev_krediye_uygun);
	$stmt->bindParam(':ev_kimden', $ev_kimden);
	$stmt->bindParam(':ev_takas', $ev_takas);
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
 $hedef_klasor = "../../content/images/";
 $hedef_dosya = $hedef_klasor . $resim;
 $dosya_turu = pathinfo($hedef_dosya, PATHINFO_EXTENSION);
 // hata mesajı
 $dosya_yukleme_hata_msj="";
 // sadece belirli dosya türlerine izin ver
$izinverilen_dosya_turleri=array("jpg", "jpeg", "png", "gif");
if(!in_array($dosya_turu, $izinverilen_dosya_turleri)){
 $dosya_yukleme_hata_msj.="<div>Sadece JPG, JPEG, PNG, GIF türündeki dosyalar
yüklenebilir.</div>";
$resim = "";
}
// aynı isimde başka bir resim var mı?
if(file_exists($hedef_dosya)){
 $dosya_yukleme_hata_msj.="<div>Aynı isimde başka bir resim dosyası
var.</div>";
$resim = "";
}
// yüklenen resim dosyasının boyutunun 1 mb sınırını aşmaması için
if($_FILES['resim']['size'] > (1024000)){
 $dosya_yukleme_hata_msj.="<div>Resim dosyasının boyutu 1 MB sınırını
aşamaz.</div>";
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
 $hedef_klasor = "../../content/images/";
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
 $hedef_klasor = "../../content/images/";
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
 $hedef_klasor = "../../content/images/";
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
 
 <!-- İlan bilgilerini girmek için kullanılacak html formu -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
 <table class='table table-hover table-responsive table-bordered'>
 <tr>
 <td>İlan Başlığı</td>
 <td><input type='text' name='urunadi' class='form-control' /></td>
 </tr>
 <tr>
 <td>Açıklama</td>
 <td><textarea name='aciklama' class='form-control'></textarea></td>
 </tr>
 <tr>
 <td>Fiyat</td>
 <td><input type='text' name='fiyat' class='form-control' /></td>
 </tr>
 <tr>
 <td>Kategori</td>
 <td>
 <?php
 // veritabanı yapılandırma dosyasını dahil et
 include '../../config/vtabani.php';
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
 </td>
</tr>
<tr>
 <td>İl</td>
 <td>
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
 </td>
</tr>
<tr>
 <td>İlçe</td>
 <td>
 <select name='ilce_id' id='ilce' class='form-control'>
 <option>İlçe seçmek için önce il seçiniz...</option>
 </select>
 </td>
</tr>
 <tr>
 <td>Resim-1</td>
 <td><input type="file" name="resim" /></td>
</tr>
 <tr>
 <td>Resim-2</td>
 <td><input type="file" name="resim_iki" /></td>
</tr>
 <tr>
 <td>Resim-3</td>
 <td><input type="file" name="resim_uc" /></td>
</tr>
 <tr>
 <td>Resim-4</td>
 <td><input type="file" name="resim_dort" /></td>
</tr>
<tr>
<td>Ev Tipi</td>
<td>
<select name='ev_tipi' class='form-control'>
 <option value='Villa'>Villa</option>
 <option value='Köşk'>Köşk</option>
 <option value='DubleX'>DubleX</option>
 <option value='Apartman Dairesi'>Apartman Dairesi</option>
 <option value='Müstakil Ev'>Müstakil Ev</option>
</select>
</td>
</tr>
<tr>
<td>Metrekare</td>
<td><input type='text' name='ev_metrekare' class='form-control' /></td>
</tr>
<tr>
<td>Oda Sayısı</td>
<td><input type='text' name='oda_sayisi' class='form-control' /></td>
</tr>
<tr>
<td>Bina Yaşı</td>
<td><input type='text' name='bina_yasi' class='form-control' /></td>
</tr>
<tr>
<td>Kat Sayısı</td>
<td><input type='text' name='kat_sayisi' class='form-control' /></td>
</tr>
<tr>
<td>Isıtma</td>
<td>
<select name='isitma' class='form-control'>
 <option value='Soba'>Soba</option>
 <option value='Doğal Gaz'>Doğal Gaz</option>
 <option value='Kömürlü Kalorifer'>Kömürlü Kalorifer</option>
 <option value='Klima'>Klima</option>
</select>
</td>
</tr>
<tr>
<td>Banyo sayısı</td>
<td><input type='text' name='banyo_sayisi' class='form-control' /></td>
</tr>
<tr>
<td>Ev eşyalı mı?</td>
<td>
<select name='esyali' class='form-control'>
 <option value='Evet'>Evet</option>
 <option value='Hayır'>Hayır</option>
</select>
</td>
</tr>
<tr>
<td>Kullanım Durumu</td>
<td>
<select name='kullanim_durumu' class='form-control'>
 <option value='Evet'>Evet</option>
 <option value='Hayır'>Hayır</option>
</select>
</td>
</tr>
<tr>
<td>Site içerisinde mi?</td>
<td>
<select name='site_icinde' class='form-control'>
 <option value='Evet'>Evet</option>
 <option value='Hayır'>Hayır</option>
</select>
</td>
</tr>
<tr>
<td>Aidat varsa ne kadar?</td>
<td><input type='text' name='aidat' class='form-control' /></td>
</tr>
<tr>
<td>Krediye uygun mu?</td>
<td>
<select name='ev_krediye_uygun' class='form-control'>
 <option value='Evet'>Evet</option>
 <option value='Hayır'>Hayır</option>
</select>
</td>
</tr>
<tr>
<td>Kimden</td>
<td>
<?php
 // kayıt listeleme sorgusu
 $sorgu='SELECT * FROM kullanicilar WHERE onay<>"0"';
 $stmt = $con->prepare($sorgu); // sorguyu hazırla
 $stmt->execute(); // sorguyu çalıştır
 $veri = $stmt->fetchAll(PDO::FETCH_ASSOC); // tablo verilerini oku
 ?>
 <select name='ev_kimden' class='form-control'>
 <option>Ev Kimden?</option>
 <?php foreach ($veri as $kayit) { ?>
 <option value="<?php echo $kayit["id"] ?>">
 <?php echo $kayit["adsoyad"]." (Tel= ".$kayit["tel_no"].")"; ?>
 </option>
 <?php } ?>
 </select>
</td>
</tr>
<tr>
<td>Takas</td>
<td>
<select name='ev_takas' class='form-control'>
 <option value='Evet'>Evet</option>
 <option value='Hayır'>Hayır</option>
</select>
</td>
</tr>
 <tr>
 <td></td>
 <td>
 <button type="submit" class='btn btn-primary'> <span class="glyphicon glyphicon-ok"></span> Kaydet</button>
 <a href='liste.php' class='btn btn-danger'> <span class='glyphicon glyphicon
glyphicon-list'></span> Ürün listesi</a>
 </td>
 </tr>
 </table>
</form>
 
</div> <!-- container -->
<?php include "../footer.php"; ?>

<script type="text/javascript">
// ilçe seçimini kısıtlamak için script kodumuz
	$(document).ready(function(){
		$("#il").change(function(){
			var ilid=$(this).val();
			$.ajax({
				type:"POST",
				url:"../../content/ajax.php",
				data:{"il":ilid},
				success:function(e){
					$("#ilce").html(e);
				}
			});
		})
	});
</script>

