<?php 
include "header.php";
 if ($_SESSION["kullanici_loginkey"] == "") {
 // oturum açılmamışsa login.php sayfasına git
 header("Location: index.php");
 }
 // veritabanı bağlantı dosyasını dahil et
 include 'config/vtabani.php';
 
 // gelen parametre değerini oku (ID)
 $id=isset($_GET['id']) ? $_GET['id'] : die('HATA: Id bilgisi bulunamadı.');	
	
 // aktif kayıt bilgilerini oku
 try {
 // seçme sorgusunu hazırla
 $sorgu = "SELECT urunler.*,
 evbilgi.ev_tipi, evbilgi.ev_metrekare, evbilgi.oda_sayisi,
	evbilgi.bina_yasi, evbilgi.kat_sayisi, evbilgi.isitma, evbilgi.banyo_sayisi, evbilgi.esyali, evbilgi.kullanim_durumu,
	evbilgi.site_icinde, evbilgi.aidat, evbilgi.ev_krediye_uygun, evbilgi.ev_takas,
	arsabilgi.imar_durumu, arsabilgi.arsa_metrekare, arsabilgi.metrekare_fiyat, arsabilgi.ada_no, arsabilgi.parsel_no,
	arsabilgi.pafta_no, arsabilgi.emsal, arsabilgi.tapu_durumu, arsabilgi.kat_karsiligi, arsabilgi.arsa_krediye_uygun, arsabilgi.arsa_takas
FROM urunler 
LEFT JOIN evbilgi ON urunler.id = evbilgi.ev_urun_id 
LEFT JOIN arsabilgi ON urunler.id = arsabilgi.arsa_urun_id 
WHERE urunler.id = ? LIMIT 0,1";
 $stmt = $con->prepare( $sorgu );

 // id parametresini bağla (? işaretini id değeri ile değiştir)
 $stmt->bindParam(1, $id);

 // sorguyu çalıştır
 $stmt->execute();

 // okunan kayıt bilgilerini bir değişkene kaydet
 $kayit = $stmt->fetch(PDO::FETCH_ASSOC);

 // formu dolduracak değişken bilgileri
 $urunadi = $kayit['urunadi'];
 $aciklama = $kayit['aciklama'];
 $fiyat = $kayit['fiyat'];
 $resim = htmlspecialchars($kayit['resim'], ENT_QUOTES);
 $resim_iki = htmlspecialchars($kayit['resim_iki'], ENT_QUOTES);
 $resim_uc = htmlspecialchars($kayit['resim_uc'], ENT_QUOTES);
 $resim_dort = htmlspecialchars($kayit['resim_dort'], ENT_QUOTES);
 $evarsa_id = $kayit['evarsa_id'];
 $kategori_id = $kayit['kategori_id'];
 $ev_tipi = $kayit['ev_tipi'];
 $ev_metrekare = $kayit['ev_metrekare'];
 $oda_sayisi = $kayit['oda_sayisi'];
 $bina_yasi = $kayit['bina_yasi'];
 $kat_sayisi = $kayit['kat_sayisi'];
 $isitma = $kayit['isitma'];
 $banyo_sayisi = $kayit['banyo_sayisi'];
 $esyali = $kayit['esyali'];
 $kullanim_durumu = $kayit['kullanim_durumu'];
 $site_icinde = $kayit['site_icinde'];
 $aidat = $kayit['aidat'];
 $ev_krediye_uygun = $kayit['ev_krediye_uygun'];
 $ev_takas = $kayit['ev_takas'];
 $imar_durumu = $kayit['imar_durumu'];
 $arsa_metrekare = $kayit['arsa_metrekare'];
 $metrekare_fiyat = $kayit['metrekare_fiyat'];
 $ada_no = $kayit['ada_no'];
 $parsel_no = $kayit['parsel_no'];
 $pafta_no = $kayit['pafta_no'];
 $emsal = $kayit['emsal'];
 $tapu_durumu = $kayit['tapu_durumu'];
 $kat_karsiligi = $kayit['kat_karsiligi'];
 $arsa_krediye_uygun = $kayit['arsa_krediye_uygun'];
 $arsa_takas = $kayit['arsa_takas'];
 }
 // hatayı göster
 catch(PDOException $exception){
 die('HATA: ' . $exception->getMessage());
 }
 ?>
 
 <!-- ilan bilgilerini düzeltme HTML formu burada yer alacak -->
 <!-- kaydı güncelleyecek PHP kodu burada yer alacak -->
 <?php
 // Kaydet butonu tıklanmışsa
 if($_POST){
 try{
 // güncelleme sorgusu
  if($evarsa_id==1){
 $sorgu = "UPDATE urunler
 LEFT JOIN evbilgi ON urunler.id = evbilgi.ev_urun_id
 SET urunler.urunadi=:urunadi, urunler.aciklama=:aciklama,
 urunler.fiyat=:fiyat, urunler.resim=:resim, urunler.resim_iki=:resim_iki, urunler.resim_uc=:resim_uc, urunler.resim_dort=:resim_dort,
 urunler.kategori_id=:kategori_id, evbilgi.ev_tipi=:ev_tipi,
 evbilgi.ev_metrekare=:ev_metrekare, evbilgi.oda_sayisi=:oda_sayisi,
 evbilgi.bina_yasi=:bina_yasi, evbilgi.kat_sayisi=:kat_sayisi, evbilgi.isitma=:isitma, evbilgi.banyo_sayisi=:banyo_sayisi,
 evbilgi.esyali=:esyali, evbilgi.kullanim_durumu=:kullanim_durumu, evbilgi.site_icinde=:site_icinde, evbilgi.aidat=:aidat, 
 evbilgi.ev_krediye_uygun=:ev_krediye_uygun, evbilgi.ev_takas=:ev_takas
 WHERE urunler.id = :id";
  }else if($evarsa_id==2){
  $sorgu = "UPDATE urunler
 LEFT JOIN arsabilgi ON urunler.id = arsabilgi.arsa_urun_id
 SET urunadi=:urunadi, aciklama=:aciklama,
 fiyat=:fiyat, resim=:resim, resim_iki=:resim_iki, resim_uc=:resim_uc, resim_dort=:resim_dort, kategori_id=:kategori_id,
 imar_durumu=:imar_durumu, arsa_metrekare=:arsa_metrekare,
 metrekare_fiyat=:metrekare_fiyat, ada_no=:ada_no, parsel_no=:parsel_no, pafta_no=:pafta_no, emsal=:emsal, tapu_durumu=:tapu_durumu,
 kat_karsiligi=:kat_karsiligi, arsa_krediye_uygun=:arsa_krediye_uygun, arsa_takas=:arsa_takas
 WHERE urunler.id = :id";
}else{echo "HATA!!";}

 // sorguyu hazırla
 $stmt = $con->prepare($sorgu);

 // gelen bilgileri değişkenlere kaydet
 $urunadi=htmlspecialchars(strip_tags($_POST['urunadi']));
 $aciklama=htmlspecialchars(strip_tags($_POST['aciklama']));
 $fiyat=htmlspecialchars(strip_tags($_POST['fiyat']));
 // yeni 'resim' alanı
 $resim=!empty($_FILES["resim"]["name"]) ? uniqid() . "-" . basename($_FILES["resim"]["name"]) : "";
    if(empty($resim)){
		$resim = $kayit['resim'];
		if(empty($kayit['resim'])){
			echo "";
		}
	}else{
		$resim=htmlspecialchars(strip_tags($resim));
	}
	
	$resim_iki=!empty($_FILES["resim_iki"]["name"]) ? uniqid() . "-" . basename($_FILES["resim_iki"]["name"]) : "";
    if(empty($resim_iki)){
		$resim_iki = $kayit['resim_iki'];
		if(empty($kayit['resim_iki'])){
			echo "";
		}
	}else{
		$resim_iki=htmlspecialchars(strip_tags($resim_iki));
	}
	
	$resim_uc=!empty($_FILES["resim_uc"]["name"]) ? uniqid() . "-" . basename($_FILES["resim_uc"]["name"]) : "";
    if(empty($resim_uc)){
		$resim_uc = $kayit['resim_uc'];
		if(empty($kayit['resim_uc'])){
			echo "";
		}
	}else{
		$resim_uc=htmlspecialchars(strip_tags($resim_uc));
	}
	
	$resim_dort=!empty($_FILES["resim_dort"]["name"]) ? uniqid() . "-" . basename($_FILES["resim_dort"]["name"]) : "";
    if(empty($resim_dort)){
		$resim_dort = $kayit['resim_dort'];
		if(empty($kayit['resim_dort'])){
			echo "";
		}
	}else{
		$resim_dort=htmlspecialchars(strip_tags($resim_dort));
	}
	
 $kategori_id=htmlspecialchars(strip_tags($_POST['kategori_id']));
 if($evarsa_id==1){
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
	$ev_takas=htmlspecialchars(strip_tags($_POST['ev_takas']));
 }else if($evarsa_id==2){
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
	$arsa_takas=htmlspecialchars(strip_tags($_POST['arsa_takas']));
 }else{echo "HATA!!";}
 // parametreleri bağla
 $stmt->bindParam(':urunadi', $urunadi);
 $stmt->bindParam(':aciklama', $aciklama);
 $stmt->bindParam(':fiyat', $fiyat);
 $stmt->bindParam(':resim', $resim);
 $stmt->bindParam(':resim_iki', $resim_iki);
 $stmt->bindParam(':resim_uc', $resim_uc);
 $stmt->bindParam(':resim_dort', $resim_dort);
 $stmt->bindParam(':kategori_id', $kategori_id);
 $stmt->bindParam(':id', $id);
  if($evarsa_id==1){
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
	$stmt->bindParam(':ev_takas', $ev_takas);
  }else if($evarsa_id==2){
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
	$stmt->bindParam(':arsa_takas', $arsa_takas);
	}else{echo "HATA!!";}
 // sorguyu çalıştır
 if($stmt->execute()){
 echo "<div class='alert alert-success'>Kayıt güncellendi.</div>";
 // resim boş değilse ve eski resime eşit değilse yükle
if($resim && $resim != $kayit['resim']){
 $hedef_klasor = "content/images/";
 $hedef_dosya = $hedef_klasor . $resim;
 $dosya_turu = pathinfo($hedef_dosya, PATHINFO_EXTENSION);
 // hata mesajı
 $dosya_yukleme_hata_msj="";
 // sadece belirli dosya türlerine izin ver
$izinverilen_dosya_turleri=array("jpg", "jpeg", "png", "gif");
if(!in_array($dosya_turu, $izinverilen_dosya_turleri)){
 $dosya_yukleme_hata_msj.="<div>Sadece JPG, JPEG, PNG, GIF türündeki dosyalar
yüklenebilir.</div>";
$resim = $kayit['resim'];
}
// yüklenen resim dosyasının boyutunun 1 mb sınırını aşmaması için
if($_FILES['resim']['size'] > (1024000)){
 $dosya_yukleme_hata_msj.="<div>Resim dosyasının boyutu 1 MB sınırını
aşamaz.</div>";
$resim = $kayit['resim'];
}
// eğer $dosya_yukleme_hata_msj boşsa
if(empty($dosya_yukleme_hata_msj)){
 // hata yok, o zaman dosya sunucuya yüklenir
 //sunucudaki eski resim dosyasını silebiliriz
 if(@unlink($hedef_klasor . $kayit['resim'])){echo "";}else{echo "";}
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
 // resim_iki boş değilse ve eski resime eşit değilse yükle
if($resim_iki && $resim_iki != $kayit['resim_iki']){
 $hedef_klasor = "content/images/";
 $hedef_dosya = $hedef_klasor . $resim_iki;
 $dosya_turu = pathinfo($hedef_dosya, PATHINFO_EXTENSION);
 // hata mesajı
 $dosya_yukleme_hata_msj="";
 // sadece belirli dosya türlerine izin ver
$izinverilen_dosya_turleri=array("jpg", "jpeg", "png", "gif");
if(!in_array($dosya_turu, $izinverilen_dosya_turleri)){
 $dosya_yukleme_hata_msj.="<div>Sadece JPG, JPEG, PNG, GIF türündeki dosyalar yüklenebilir.</div>";
$resim_iki = $kayit['resim_iki'];
}
// yüklenen resim dosyasının boyutunun 1 mb sınırını aşmaması için
if($_FILES['resim_iki']['size'] > (1024000)){
 $dosya_yukleme_hata_msj.="<div>Resim dosyasının boyutu 1 MB sınırını aşamaz.</div>";
$resim_iki = $kayit['resim_iki'];
}
// eğer $dosya_yukleme_hata_msj boşsa
if(empty($dosya_yukleme_hata_msj)){
 // hata yok, o zaman dosya sunucuya yüklenir
 //sunucudaki eski resim dosyasını silebiliriz
 if(@unlink($hedef_klasor . $kayit['resim_iki'])){echo "";}else{echo "";}
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
 // resim_uc boş değilse ve eski resime eşit değilse yükle
if($resim_uc && $resim_uc != $kayit['resim_uc']){
 $hedef_klasor = "content/images/";
 $hedef_dosya = $hedef_klasor . $resim_uc;
 $dosya_turu = pathinfo($hedef_dosya, PATHINFO_EXTENSION);
 // hata mesajı
 $dosya_yukleme_hata_msj="";
 // sadece belirli dosya türlerine izin ver
$izinverilen_dosya_turleri=array("jpg", "jpeg", "png", "gif");
if(!in_array($dosya_turu, $izinverilen_dosya_turleri)){
 $dosya_yukleme_hata_msj.="<div>Sadece JPG, JPEG, PNG, GIF türündeki dosyalar yüklenebilir.</div>";
$resim_uc = $kayit['resim_uc'];
}
// yüklenen resim dosyasının boyutunun 1 mb sınırını aşmaması için
if($_FILES['resim_uc']['size'] > (1024000)){
 $dosya_yukleme_hata_msj.="<div>Resim dosyasının boyutu 1 MB sınırını aşamaz.</div>";
$resim_uc = $kayit['resim_uc'];
}
// eğer $dosya_yukleme_hata_msj boşsa
if(empty($dosya_yukleme_hata_msj)){
 // hata yok, o zaman dosya sunucuya yüklenir
 //sunucudaki eski resim dosyasını silebiliriz
 if(@unlink($hedef_klasor . $kayit['resim_uc'])){echo "";}else{echo "";}
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
 // resim_dort boş değilse ve eski resime eşit değilse yükle
if($resim_dort && $resim_dort != $kayit['resim_dort']){
 $hedef_klasor = "content/images/";
 $hedef_dosya = $hedef_klasor . $resim_dort;
 $dosya_turu = pathinfo($hedef_dosya, PATHINFO_EXTENSION);
 // hata mesajı
 $dosya_yukleme_hata_msj="";
 // sadece belirli dosya türlerine izin ver
$izinverilen_dosya_turleri=array("jpg", "jpeg", "png", "gif");
if(!in_array($dosya_turu, $izinverilen_dosya_turleri)){
 $dosya_yukleme_hata_msj.="<div>Sadece JPG, JPEG, PNG, GIF türündeki dosyalar yüklenebilir.</div>";
$resim_dort = $kayit['resim_dort'];
}
// yüklenen resim dosyasının boyutunun 1 mb sınırını aşmaması için
if($_FILES['resim_dort']['size'] > (1024000)){
 $dosya_yukleme_hata_msj.="<div>Resim dosyasının boyutu 1 MB sınırını aşamaz.</div>";
$resim_dort = $kayit['resim_dort'];
}
// eğer $dosya_yukleme_hata_msj boşsa
if(empty($dosya_yukleme_hata_msj)){
 // hata yok, o zaman dosya sunucuya yüklenir
 //sunucudaki eski resim dosyasını silebiliriz
 if(@unlink($hedef_klasor . $kayit['resim_dort'])){echo "";}else{echo "";}
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
	 echo "<div class='alert alert-danger'>Kayıt
güncellenemedi.</div>";
 }

 }
 // hata varsa göster
 catch(PDOException $exception){
 die('HATA: ' . $exception->getMessage());
 }
 }
?>


<div class="container p-5">
 <!-- Başlık burada yer alacak -->
 <h1 class="text-center baslik">İlan ID: <?php echo $id; ?></h1>
<p class="text-center p-4">Aşağıdaki formu kullanarak ilanınızı güncelleyebilirsiniz.</p>
<hr>
 <div class="row mt-4">
 <div class="col-md-4">
 <h2 class="baslik">İlan Güncelleme Formu</h2>
 </div>
 <div class="col-md-8">
 <form action="ilanduzenle.php?id=<?php echo $id; ?>" method="post" name="ilan_guncelle" enctype="multipart/form-data">
 <div class="form-group">
 <label for="exampleInputText2">Resim-1</label><br/>
 <?php echo $resim ? "<img src='content/images/{$resim}' style='width:300px;' />" : "<img src='content/images/gorsel-yok.jpg' style='width:300px;'/>"; ?>
 <br/><br/>Yeni resim seçin: <input type="file" name="resim" />
 </div>
 <div class="form-group">
 <label for="exampleInputText2">Resim-2</label><br/>
 <?php echo $resim_iki ? "<img src='content/images/{$resim_iki}' style='width:300px;' />" : "<img src='content/images/gorsel-yok.jpg' style='width:300px;'/>"; ?>
 <br/><br/>Yeni resim seçin: <input type="file" name="resim_iki" />
 </div>
 <div class="form-group">
 <label for="exampleInputText2">Resim-3</label><br/>
 <?php echo $resim_uc ? "<img src='content/images/{$resim_uc}' style='width:300px;' />" : "<img src='content/images/gorsel-yok.jpg' style='width:300px;'/>"; ?>
 <br/><br/>Yeni resim seçin: <input type="file" name="resim_uc" />
 </div>
 <div class="form-group">
 <label for="exampleInputText2">Resim-4</label><br/>
 <?php echo $resim_dort ? "<img src='content/images/{$resim_dort}' style='width:300px;' />" : "<img src='content/images/gorsel-yok.jpg' style='width:300px;'/>"; ?>
 <br/><br/>Yeni resim seçin: <input type="file" name="resim_dort" />
 </div>
 <div class="form-group">
 <label>İlan Başlığı</label>
 <input type="text" class="form-control" value="<?php echo
htmlspecialchars($urunadi, ENT_QUOTES); ?>" name="urunadi">
 </div>
 <div class="form-group">
 <label for="exampleInputText2">Açıklama</label>
 <textarea name='aciklama' class='form-control'><?php echo
htmlspecialchars($aciklama, ENT_QUOTES); ?></textarea>
 </div>
 <div class="form-group">
 <label for="exampleInputText2">Fiyat</label>
 <input type='text' name='fiyat' value="<?php echo
htmlspecialchars($fiyat, ENT_QUOTES); ?>" class='form-control' />
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
 <option value="<?php echo $kayit["id"] ?>"
 <?php if($kayit["id"]==$kategori_id) echo " selected" ?>>
 <?php echo $kayit["kategoriadi"] ?>
 </option>
 <?php } ?>
 </select>
 </div>
 <?php if($evarsa_id == 1){  ?>
 <div class="form-group">
 <label for="exampleInputText2">Ev Tipi</label>
<select name='ev_tipi' class='form-control'>
 <option value='Villa' <?php if($ev_tipi=="Villa") echo " selected" ?>>Villa</option>
 <option value='Köşk' <?php if($ev_tipi=="Köşk") echo " selected" ?>>Köşk</option>
 <option value='DubleX' <?php if($ev_tipi=="DubleX") echo " selected" ?>>DubleX</option>
 <option value='Apartman Dairesi' <?php if($ev_tipi=="Apartman Dairesi") echo " selected" ?>>Apartman Dairesi</option>
 <option value='Müstakil Ev' <?php if($ev_tipi=="Müstakil Ev") echo " selected" ?>>Müstakil Ev</option>
</select>
 </div>
 <div class="form-group">
 <label for="exampleInputText2">Metrekare</label>
 <input type='text' name='ev_metrekare' value="<?php echo
htmlspecialchars($ev_metrekare, ENT_QUOTES); ?>" class='form-control' />
 </div>
 <div class="form-group">
 <label for="exampleInputText2">Oda sayısı</label>
 <input type='text' name='oda_sayisi' value="<?php echo
htmlspecialchars($oda_sayisi, ENT_QUOTES); ?>" class='form-control' />
 </div>
 <div class="form-group">
 <label for="exampleInputText2">Bina yaşı</label>
 <input type='text' name='bina_yasi' value="<?php echo
htmlspecialchars($bina_yasi, ENT_QUOTES); ?>" class='form-control' />
 </div>
 <div class="form-group">
 <label for="exampleInputText2">Kat sayısı</label>
 <input type='text' name='kat_sayisi' value="<?php echo
htmlspecialchars($kat_sayisi, ENT_QUOTES); ?>" class='form-control' />
 </div>
 <div class="form-group">
 <label for="exampleInputText2">Isıtma</label>
 <select name='isitma' class='form-control'>
 <option value='Soba' <?php if($isitma=="Soba") echo " selected" ?>>Soba</option>
 <option value='Doğal Gaz' <?php if($isitma=="Doğal Gaz") echo " selected" ?>>Doğal Gaz</option>
 <option value='Kömürlü Kalorifer' <?php if($isitma=="Kömürlü Kalorifer") echo " selected" ?>>Kömürlü Kalorifer</option>
 <option value='Klima' <?php if($isitma=="Klima") echo " selected" ?>>Klima</option>
</select>
 </div>
 <div class="form-group">
 <label for="exampleInputText2">Banyo sayısı</label>
 <input type='text' name='banyo_sayisi' value="<?php echo
htmlspecialchars($banyo_sayisi, ENT_QUOTES); ?>" class='form-control' />
 </div>
 <div class="form-group">
 <label for="exampleInputText2">Ev eşyalı mı?</label>
 <select name='esyali' class='form-control'>
 <option value='Evet' <?php if($esyali=="Evet") echo " selected" ?>>Evet</option>
 <option value='Hayır' <?php if($esyali=="Hayır") echo " selected" ?>>Hayır</option>
</select>
 </div>
 <div class="form-group">
 <label for="exampleInputText2">Şu an kullanılıyor mu?</label>
 <select name='kullanim_durumu' class='form-control'>
 <option value='Evet' <?php if($kullanim_durumu=="Evet") echo " selected" ?>>Evet</option>
 <option value='Hayır' <?php if($kullanim_durumu=="Hayır") echo " selected" ?>>Hayır</option>
</select>
 </div>
 <div class="form-group">
 <label for="exampleInputText2">Site içerisinde mi?</label>
 <select name='site_icinde' class='form-control'>
 <option value='Evet' <?php if($site_icinde=="Evet") echo " selected" ?>>Evet</option>
 <option value='Hayır' <?php if($site_icinde=="Hayır") echo " selected" ?>>Hayır</option>
</select>
 </div>
 <div class="form-group">
 <label for="exampleInputText2">Aidat varsa ne kadar?</label>
 <input type='text' name='aidat'  value="<?php echo
htmlspecialchars($aidat, ENT_QUOTES); ?>" class='form-control' />
 </div>
 <div class="form-group">
 <label for="exampleInputText2">Krediye uygun mu?</label>
 <select name='ev_krediye_uygun' class='form-control'>
 <option value='Evet' <?php if($ev_krediye_uygun=="Evet") echo " selected" ?>>Evet</option>
 <option value='Hayır' <?php if($ev_krediye_uygun=="Hayır") echo " selected" ?>>Hayır</option>
</select>
 </div>
 <div class="form-group">
 <label for="exampleInputText2">Takas</label>
 <select name='ev_takas' class='form-control'>
 <option value='Evet' <?php if($ev_takas=="Evet") echo " selected" ?>>Evet</option>
 <option value='Hayır' <?php if($ev_takas=="Hayır") echo " selected" ?>>Hayır</option>
</select>
 </div>
 <?php } else if($evarsa_id == 2){ ?>
 <div class="form-group">
 <label for="exampleInputText2">İmar Durumu</label>
 <input type='text' name='imar_durumu' value="<?php echo
htmlspecialchars($imar_durumu, ENT_QUOTES); ?>" class='form-control' />
 </div>
 <div class="form-group">
 <label for="exampleInputText2">Metrekare</label>
 <input type='text' name='arsa_metrekare' value="<?php echo
htmlspecialchars($arsa_metrekare, ENT_QUOTES); ?>" class='form-control' />
 </div>
 <div class="form-group">
 <label for="exampleInputText2">Metrekare Fiyatı</label>
 <input type='text' name='metrekare_fiyat' value="<?php echo
htmlspecialchars($metrekare_fiyat, ENT_QUOTES); ?>" class='form-control' />
 </div>
 <div class="form-group">
 <label for="exampleInputText2">Ada no</label>
 <input type='text' name='ada_no' value="<?php echo
htmlspecialchars($ada_no, ENT_QUOTES); ?>" class='form-control' />
 </div>
 <div class="form-group">
 <label for="exampleInputText2">Parsel no</label>
 <input type='text' name='parsel_no' value="<?php echo
htmlspecialchars($parsel_no, ENT_QUOTES); ?>" class='form-control' />
 </div>
 <div class="form-group">
 <label for="exampleInputText2">Pafta No</label>
 <input type='text' name='pafta_no' value="<?php echo
htmlspecialchars($pafta_no, ENT_QUOTES); ?>" class='form-control' />
 </div>
 <div class="form-group">
 <label for="exampleInputText2">Emsal</label>
 <input type='text' name='emsal' value="<?php echo
htmlspecialchars($emsal, ENT_QUOTES); ?>" class='form-control' />
 </div>
 <div class="form-group">
 <label for="exampleInputText2">Tapu Durumu</label>
 <input type='text' name='tapu_durumu' value="<?php echo
htmlspecialchars($tapu_durumu, ENT_QUOTES); ?>" class='form-control' />
 </div>
 <div class="form-group">
 <label for="exampleInputText2">Kat Karşılığı</label>
 <select name='kat_karsiligi' class='form-control'>
 <option value='Evet' <?php if($kat_karsiligi=="Evet") echo " selected" ?>>Evet</option>
 <option value='Hayır' <?php if($kat_karsiligi=="Hayır") echo " selected" ?>>Hayır</option>
</select>
 </div>
 <div class="form-group">
 <label for="exampleInputText2">Krediye Uygun mu?</label>
 <select name='arsa_krediye_uygun' class='form-control'>
 <option value='Evet' <?php if($arsa_krediye_uygun=="Evet") echo " selected" ?>>Evet</option>
 <option value='Hayır' <?php if($arsa_krediye_uygun=="Hayır") echo " selected" ?>>Hayır</option>
</select>
 </div>
 <div class="form-group">
 <label for="exampleInputText2">Takas</label>
<select name='arsa_takas' class='form-control'>
 <option value='Evet' <?php if($arsa_takas=="Evet") echo " selected" ?>>Evet</option>
 <option value='Hayır' <?php if($arsa_takas=="Hayır") echo " selected" ?>>Hayır</option>
</select>
 </div>
 <?php } ?>
 <button type="submit" class="btn btn-success">Güncelle</button>
 </form>
 </div>
 </div>
</div>
<?php include "footer.php"; ?>