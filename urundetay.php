<?php include "header.php"; ?>
 <!-- İlan bilgilerini veritabanından getiren PHP kodları burada yer alacak -->
 <?php
 // gelen Id parametresini al
 $id=isset($_GET['id']) ? $_GET['id'] : die('HATA: Kayıt bulunamadı.');
 $islem = isset($_GET['islem']) ? $_GET['islem'] : "";
 
 if($islem=="bosluk"){
	 echo "<div class='alert alert-danger text-center'>Boş mesaj gönderemezsiniz!</div>";
 }

 // veritabanı bağlantı dosyasını çağır
 include 'config/vtabani.php';

 // kayıt bilgilerini oku
 try {
 // seçme sorgusunu hazırla
 $sorgu = "SELECT urunler.id, urunler.urunadi, urunler.aciklama, urunler.fiyat, urunler.giris_tarihi, urunler.dzltm_tarihi,
urunler.resim, urunler.resim_iki, urunler.resim_uc, urunler.resim_dort, urunler.evarsa_id, kategoriler.kategoriadi, evbilgi.ev_tipi, evbilgi.ev_metrekare, evbilgi.oda_sayisi,
	evbilgi.bina_yasi, evbilgi.kat_sayisi, evbilgi.isitma, evbilgi.banyo_sayisi, evbilgi.esyali, evbilgi.kullanim_durumu,
	evbilgi.site_icinde, evbilgi.aidat, evbilgi.ev_krediye_uygun, evbilgi.ev_kimden, evbilgi.ev_takas,
	arsabilgi.imar_durumu, arsabilgi.arsa_metrekare, arsabilgi.metrekare_fiyat, arsabilgi.ada_no, arsabilgi.parsel_no,
	arsabilgi.pafta_no, arsabilgi.emsal, arsabilgi.tapu_durumu, arsabilgi.kat_karsiligi, arsabilgi.arsa_krediye_uygun, arsabilgi.arsa_kimden, arsabilgi.arsa_takas
FROM urunler 
LEFT JOIN kategoriler ON urunler.kategori_id = kategoriler.id 
LEFT JOIN evbilgi ON urunler.id = evbilgi.ev_urun_id 
LEFT JOIN arsabilgi ON urunler.id = arsabilgi.arsa_urun_id
 WHERE urunler.id = ?";
 $stmt = $con->prepare( $sorgu ); // Id parametresini bağla
 $stmt->bindParam(1, $id); // sorguyu çalıştır
 $stmt->execute();
 $kayit = $stmt->fetch(PDO::FETCH_ASSOC); // gelen kaydı bir değişkende sakla
 $favori_icin_id = $kayit['id'];
 // tablo alanlarını değişkene dönüştürür: $kayit['urunadi'] => $urunadi
 extract($kayit);
 try{
	 // seçme sorgusunu hazırla
 $sorgu = "SELECT id, adsoyad, tel_no FROM kullanicilar WHERE id='".$arsa_kimden."' OR id='".$ev_kimden."'";
 $stmt = $con->prepare( $sorgu );
 $stmt->execute();
 $kayit2 = $stmt->fetch(PDO::FETCH_ASSOC); // gelen kaydı bir değişkende sakla

 // tablo alanlarını değişkene dönüştürür: $kayit2['urunadi'] => $urunadi
 extract($kayit2);
 }// hatayı göster
 catch(PDOException $exception){
 die('HATA: ' . $exception->getMessage());
 }
 }
 // hatayı göster
 catch(PDOException $exception){
 die('HATA: ' . $exception->getMessage());
 }
?>

 <div class="container mt-4 mb-4">
 <div class="row">
 <div class="col-md-6">
 <!-- İlan resmi burada yer alacak -->
 <?php echo $resim ? "<img src='content/images/{$resim}' alt='{$urunadi}' style='width:100%;height:405px;' class='img-fluid rounded' />":"<img src='content/images/gorsel-yok.jpg' style='width:100%;height:405px;' class='card-img-top' />"; ?>
 <br/><br/>
 <h5>İlana ait diğer resimler;</h5>
 <!-- İlan resimleri slider burada yer alacak -->
<?php 
  // resimlerin kayıt bilgilerini oku
 try {
 // slider-1 için seçme sorgusunu hazırla
 $sorgu = "SELECT resim_iki FROM urunler WHERE resim='{$resim}' LIMIT 0,1";
 $stmt = $con->prepare( $sorgu );
 // slider-1 için sorguyu çalıştır
 $stmt->execute();
 //slider-2 için seçme sorgusunu hazırla
 $sorgu2 = "SELECT resim_uc FROM urunler WHERE resim='{$resim}' LIMIT 0,1";
 $stmt2 = $con->prepare( $sorgu2 );
 //slider-2 için sorguyu çalıştır
 $stmt2->execute();
 //slider-3 için seçme sorgusunu hazırla
 $sorgu3 = "SELECT resim_dort FROM urunler WHERE resim='{$resim}' LIMIT 0,1";
 $stmt3 = $con->prepare( $sorgu3 );
 //slider-3 için sorguyu çalıştır
 $stmt3->execute();
 
 // geriye dönen kayıt sayısı
 $sayi = $stmt->rowCount() + $stmt2->rowCount() + $stmt3->rowCount();
 $sayi1 = $stmt->rowCount();
 $sayi2 = $stmt2->rowCount();
 $sayi3 = $stmt3->rowCount();
 //echo $sayi." ".$sayi1." ".$sayi2." ".$sayi3." ";
 }
 // hatayı göster
 catch(PDOException $exception){
 die('HATA: ' . $exception->getMessage());
 }

//kayıt varsa listele
 if($sayi>0){
 ?>
 <!-- Slider satırı kodları burada yer alacak  -->
 <div id="carouselExampleIndicators" class="carousel slide d-none d-sm-block" dataride="carousel">
 <ol class="carousel-indicators">
 <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
 <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
 <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
 </ol>
 <div class="carousel-inner">
 <?php
 //kayıt varsa listele
 if($sayi1>0){
 //slider 1 verilerin okunması
 while ($kayit = $stmt->fetch(PDO::FETCH_ASSOC)){
 // tablo alanlarını değişkene dönüştürür
 // $kayit['adsoyad'] => $adsoyad
 extract($kayit);
 ?>
 <div class="carousel-item active">
	<!--<img class="d-block w-100" height="370" src="content/images/<?php // echo "{$resim_iki}"; ?>"> -->
	<?php echo $resim_iki ? "<img src='content/images/{$resim_iki}' alt='{$urunadi}' style='width:100%;height:405px;' class='d-block w-100' />":"<img src='content/images/gorsel-yok.jpg' style='width:100%;height:405px;' class='card-img-top' />"; ?>
 <div class="carousel-caption d-none d-md-block">
	<h3><?php echo "Resim-2"; ?></h3>
	<p><?php echo "EmlakProje"; ?></p>
 </div>
 </div>
 <?php
 }
 }
 if($sayi2>0){
 //slider 2 verilerin okunması
 while ($kayit = $stmt2->fetch(PDO::FETCH_ASSOC)){
 // tablo alanlarını değişkene dönüştürür
 // $kayit['adsoyad'] => $adsoyad
 extract($kayit);
 ?>
 <div class="carousel-item <?php if($sayi1==0){echo "active";}else{echo "";} ?>">
 <!--<img class="d-block w-100" height="370" src="content/images/<?php //echo "{$resim_uc}"; ?>">-->
 <?php echo $resim_uc ? "<img src='content/images/{$resim_uc}' alt='{$urunadi}' style='width:100%;height:405px;' class='d-block w-100' />":"<img src='content/images/gorsel-yok.jpg' style='width:100%;height:405px;' class='card-img-top' />"; ?>
 <div class="carousel-caption d-none d-md-block">
 <h3><?php echo "Resim-3"; ?></h3>
 <p><?php echo "EmlakProje"; ?></p>
 </div>
 </div>
 <?php
 }
 }
 if($sayi3>0){
 //slider 3 verilerin okunması
 while ($kayit = $stmt3->fetch(PDO::FETCH_ASSOC)){
 // tablo alanlarını değişkene dönüştürür
 // $kayit['adsoyad'] => $adsoyad
 extract($kayit);
 ?>
 <div class="carousel-item <?php if($sayi1==0 && $sayi2==0){echo "active";}else{echo "";} ?>">
 <!--<img class="d-block w-100" height="370" src="content/images/<?php //echo "{$resim_dort}"; ?>">-->
 <?php echo $resim_dort ? "<img src='content/images/{$resim_dort}' alt='{$urunadi}' style='width:100%;height:405px;' class='d-block w-100' />":"<img src='content/images/gorsel-yok.jpg' style='width:100%;height:405px;' class='card-img-top' />"; ?>
 <div class="carousel-caption d-none d-md-block">
 <h3><?php echo "Resim-4"; ?></h3>
 <p><?php echo "EmlakProje"; ?></p>
 </div>
 </div>
 <?php
 }
 }
 ?>
 </div>
 <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button"
data-slide="prev">
 <span class="carousel-control-prev-icon" aria-hidden="true"></span>
 <span class="sr-only">Önceki</span>
 </a>
 <a class="carousel-control-next" href="#carouselExampleIndicators"
role="button" data-slide="next">
 <span class="carousel-control-next-icon" aria-hidden="true"></span>
 <span class="sr-only">Sonraki</span>
 </a>
</div>
<?php 
 }
 // slider yoksa mesajla bildir
 else{
 echo "<div class='alert alert-danger'>HATA: İlana ait diğer resimler eklenmemiş veya gösterilemiyor...</div>";
 }
?>
 
 
 </div>
 <div class="col-md-6">
   
 <h2 class="baslik"><?php echo $urunadi; ?></h2>

<div class="text-success pull-left">
<h4><?php echo number_format($fiyat, 0, ',', '.') ?>&#8378;</h4>
</div>

<div class="btn btn-success pull-right" >
<a href="#" class="text-light favori-ekle" id="<?php echo $favori_icin_id; ?>"><i class="fa fa-heart"> Favorile</i></a>
</div>
<table class="table table-hover table-responsive" style="font-size:14px;">
<a href="msj_gonder.php?konu=<?php echo $favori_icin_id; ?>&kime=<?php echo $kayit2['id']; ?>"><div class="btn btn-danger pull-right" style="
  position: absolute;
  border-radius:10px;
  top: 20%;
  left: 65%;">
  <?php if($evarsa_id == 1){ ?>
  <i class="fa fa-home fa-5x" aria-hidden="true"></i>
  <?php }else if($evarsa_id == 2){ ?>
  <i class="fa fa-road fa-5x" aria-hidden="true"></i>
  <?php } ?>
  <br/>
 <b>İlan Sahibi:</b> <?php echo $adsoyad; ?>
 <br/>
 <b>Telefon:</b> <?php
				$bir = substr($tel_no,'0','3');
				$iki = substr($tel_no,'3','3');
				$uc = substr($tel_no,'6','2');
				$dort = substr($tel_no,'8','2');
				echo "0 (".$bir.") ".$iki."-".$uc."-".$dort; ?>
 <br/>
 [Mesaj gönder]
 </div></a>
<tr>
	<td>
		<b>İlan ID numarası</b>
	</td>
	<td>
		<?php echo $favori_icin_id;?>
	</td>
</tr>
<tr>
<td>
<b>İlan Tarihi</b>
</td>
<td>
<?php 
echo substr($giris_tarihi,'8','2')."-"; 
echo substr($giris_tarihi,'5','2')."-";
echo substr($giris_tarihi,'0','4');
?>
</td>
</tr>
<tr>
<td><b>Güncelleme Tarihi</b></td>
<td>
<?php
echo substr($dzltm_tarihi,'8','2')."-"; 
echo substr($dzltm_tarihi,'5','2')."-";
echo substr($dzltm_tarihi,'0','4');
?>
</td>
</tr>
<tr>
<td>
<b>Kategori</b>
</td>
<td>
<?php
echo $kategoriadi." "; if($evarsa_id=="1"){ echo "Ev"; }else if($evarsa_id=="2"){ echo "Arsa"; } ;
?>
</td>
</tr>
<?php if($evarsa_id=="1"){ ?>
<tr>
<td>
<b>Ev Metrekare</b>
</td>
<td>
<?php
echo $ev_metrekare." m<sup>2</sup>";
?>
</td>
</tr>
<tr>
<td>
<b>Ev Tipi</b>
</td>
<td <?php if($ev_tipi=="Apartman Dairesi"){echo "colspan='2'";} ?>>
<?php
echo $ev_tipi;
?>
</td>
</tr>
<tr>
<td>
<b>Oda Sayısı</b>
</td>
<td>
<?php
echo $oda_sayisi;
?>
</td>
</tr>
<tr>
<td>
<b>Bina Yaşı</b>
</td>
<td>
<?php
echo $bina_yasi;
?>
</td>
</tr>
<tr>
<td>
<b>Kat Sayısı</b>
</td>
<td>
<?php
echo $kat_sayisi;
?>
</td>
</tr>
<tr>
<td>
<b>Isıtma</b>
</td>
<td>
<?php
echo $isitma;
?>
</td>
</tr>
<tr>
<td>
<b>Banyo Sayısı</b>
</td>
<td>
<?php
echo $banyo_sayisi;
?>
</td>
</tr>
<tr>
<td>
<b>Eşyalı mı?</b>
</td>
<td>
<?php
echo $esyali;
?>
</td>
</tr>
<tr>
<td>
<b>Kullanım Durumu</b>
</td>
<td>
<?php
echo $kullanim_durumu;
?>
</td>
</tr>
<tr>
<td>
<b>Site içinde mi?</b>
</td>
<td>
<?php
echo $site_icinde;
?>
</td>
</tr>
<tr>
<td>
<b>Aidat</b>
</td>
<td>
<?php
echo $aidat;
?>
</td>
</tr>
<tr>
<td>
<b>Krediye Uygun mu?</b>
</td>
<td>
<?php
echo $ev_krediye_uygun;
?>
</td>
</tr>
<tr>
<td>
<b>Takas</b>
</td>
<td>
<?php
echo $ev_takas;
?>
</td>
</tr>

<?php }else if($evarsa_id=="2"){ ?>

<tr>
<td>
<b>İmar Durumu</b>
</td>
<td>
<?php
echo $imar_durumu;
?>
</td>
</tr>
<tr>
<td>
<b>Metrekare</b>
</td>
<td>
<?php
echo $arsa_metrekare." m<sup>2</sup>";
?>
</td>
</tr>
<tr>
<td>
<b>Metrekare Fiyatı</b>
</td>
<td>
<?php
echo $metrekare_fiyat." &#8378;";
?>
</td>
</tr>
<tr>
<td>
<b>Ada No</b>
</td>
<td>
<?php
echo $ada_no;
?>
</td>
</tr>
<tr>
<td>
<b>Parsel No</b>
</td>
<td>
<?php
echo $parsel_no;
?>
</td>
</tr>
<tr>
<td>
<b>Pafta No</b>
</td>
<td>
<?php
echo $pafta_no;
?>
</td>
</tr>
<tr>
<td>
<b>Emsal</b>
</td>
<td>
<?php
echo $emsal;
?>
</td>
</tr>
<tr>
<td>
<b>Tapu Durumu</b>
</td>
<td>
<?php
echo $tapu_durumu;
?>
</td>
</tr>
<tr>
<td>
<b>Kat Karşılığı</b>
</td>
<td>
<?php
echo $kat_karsiligi;
?>
</td>
</tr>
<tr>
<td>
<b>Krediye Uygun mu?</b>
</td>
<td>
<?php
echo $arsa_krediye_uygun;
?>
</td>
</tr>
<tr>
<td>
<b>Takas</b>
</td>
<td>
<?php
echo $arsa_takas;
?>
</td>
</tr>

<?php } ?>
</table>

 </div>
 </div>
 
 <br/><br/>
 <?php echo "<h4>İlan açıklaması;</h4><textarea class='form-control' id='exampleFormControlTextarea1' rows='17' cols='74' style='resize:none;border:none;' readonly='yes'>".$aciklama."</textarea>"; ?>
 
 
 
 <!-- Diğer ilanları listeleyen kodlar burada yer alacak -->
 <?php if($evarsa_id == "1"){$evOarsa="Ev";$evOarsa_id="1";}else if($evarsa_id == "2"){$evOarsa="Arsa";$evOarsa_id="2";} ?>
 <h4 class="baslik mt-5"><b><?php echo $kategoriadi." ".$evOarsa; ?></b> kategorisindeki diğer ilanlar</h2>
<div class="row">
 <?php
 // veritabanı yapılandırma dosyasını dahil et
 include 'config/vtabani.php';
 // kayıt listeleme sorgusu
 $sorgu='SELECT urunler.id, urunler.urunadi, urunler.aciklama, urunler.fiyat, urunler.resim, kategoriler.kategoriadi, il.sehir, ilce.ilce 
 FROM urunler 
 LEFT JOIN kategoriler ON urunler.kategori_id = kategoriler.id 
 LEFT JOIN il ON urunler.il_id=il.id
 LEFT JOIN ilce ON urunler.ilce_id=ilce.id
 WHERE urunler.onay="1" AND kategoriler.kategoriadi="'.$kategoriadi.'" AND urunler.evarsa_id="'.$evOarsa_id.'" AND urunler.id<>"'.$favori_icin_id.'" limit 0,4';
 $stmt = $con->prepare($sorgu); // sorguyu hazırla
 $stmt->execute(); // sorguyu çalıştır
 $veri = $stmt->fetchAll(PDO::FETCH_ASSOC); // tablo verilerini oku
 foreach ($veri as $kayit) { ?>
 <div class="col-md-3 mb-3">
 <div class="card">
 <a href="urundetay.php?id=<?php echo $kayit['id']?>">
 <?php echo $kayit['resim'] ? "<img src='content/images/".$kayit['resim']."' alt='".$kayit['urunadi']."' style='width:100%;height:205px;' class='card-img-top' />":"<img src='content/images/gorsel-yok.jpg' style='width:100%;height:205px' class='card-img-top' />"; ?>
</a>
 <div class="card-body">
 <h4 class="card-title"><?php echo mb_substr($kayit['urunadi'],'0','12','UTF-8')."..."?></h4>
 <p class="card-text"><?php echo $kayit['sehir']."/".$kayit['ilce']?></p>
 <p class="card-text"><?php echo "<b>İlan Türü:</b> ".$kategoriadi." ".$evOarsa;?></p>
 </div>
 <div class="card-footer text-muted">
 <a href="#" class="text-secondary float-left favori-ekle" id="<?php echo $kayit['id']?>"><i class="fa fa-heart fa-2x"></i>Favorile</a>
 <span class="badge badge-success p-2 float-right"><?php echo number_format($kayit['fiyat'], 0, ',', '.')?>&#8378;</span>
 </div>
 </div>
 </div>
 <?php }
	if(empty($veri)){
		?>
		<div class='alert alert-danger'>Benzer ilanlar bulunamadı...</div>
	<?php
	}
 ?>
</div>

 
 </div>
<?php include "footer.php"; ?>