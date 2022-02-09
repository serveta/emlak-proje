 <?php include "header.php"; 
 
  // aktif kayıt bilgilerini oku
 try {
 // slider-1 için seçme sorgusunu hazırla
 $sorgu = "SELECT * FROM slider WHERE slider_k_durum='1'";
 $stmt = $con->prepare( $sorgu );
 // slider-1 için sorguyu çalıştır
 $stmt->execute();
 //slider-2 için seçme sorgusunu hazırla
 $sorgu2 = "SELECT * FROM slider WHERE slider_k_durum='2'";
 $stmt2 = $con->prepare( $sorgu2 );
 //slider-2 için sorguyu çalıştır
 $stmt2->execute();
 //slider-3 için seçme sorgusunu hazırla
 $sorgu3 = "SELECT * FROM slider WHERE slider_k_durum='3'";
 $stmt3 = $con->prepare( $sorgu3 );
 //slider-3 için sorguyu çalıştır
 $stmt3->execute();
 
 // geriye dönen kayıt sayısı
 $sayi = $stmt->rowCount() + $stmt2->rowCount() + $stmt3->rowCount();
 $sayi1 = $stmt->rowCount();
 $sayi2 = $stmt2->rowCount();
 $sayi3 = $stmt3->rowCount();
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
	<img class="d-block w-100" height="370" src="content/images/<?php echo "{$slider_baglanti}"; ?>">
 <div class="carousel-caption d-none d-md-block">
	<h3><?php echo "{$slider_baslik}"; ?></h3>
	<p><?php echo "{$slider_aciklama}"; ?></p>
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
 <img class="d-block w-100" height="370" src="content/images/<?php echo "{$slider_baglanti}"; ?>">
 <div class="carousel-caption d-none d-md-block text-warning text-right">
 <h3><?php echo "{$slider_baslik}"; ?></h3>
 <p><?php echo "{$slider_aciklama}"; ?></p>
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
 <img class="d-block w-100" height="370" src="content/images/<?php echo "{$slider_baglanti}"; ?>">
 <div class="carousel-caption d-none d-md-block text-success text-left">
 <h3><?php echo "{$slider_baslik}"; ?></h3>
 <p><?php echo "{$slider_aciklama}"; ?></p>
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
 echo "<div class='alert alert-danger'>HATA: Sisteme kayıtlı herhangi bir slider görünmüyor yada geçici bir süreliğine gösterimi durdurulmuş...</div>";
 }
?>
 
 <div class="container pt-4">
 <!-- Karşılama satırı kodları burada yer alacak -->
 <h1 class="text-center baslik">EmlakProje'ye Hoş Geldiniz</h1>

 <!-- Kısa açıklama satırı kodları burada yer alacak -->
 <div class="row pt-4 bg-light">
 <div class="col-md-4">
 <div class="row">
 <div class="col-md-4">
 <span class="fa-stack fa-3x">
 <i class="fa fa-circle-thin fa-stack-2x"></i>
 <i class="fa fa-refresh fa-stack-1x"></i>
 </span>
 </div>
 <div class="col-md-8">
 <h5>Sorunsuz İşlemler</h5>
 <p>Tüm işlemleriniz en geç 7 iş gününde tamamlanır.</p>
 </div>
 </div>
 </div>
 <div class="col-md-4">
 <div class="row">
 <div class="col-md-4">
 <span class="fa-stack fa-3x">
 <i class="fa fa-circle-thin fa-stack-2x"></i>
 <i class="fa fa-credit-card fa-stack-1x"></i>
 </span>
 </div>
 <div class="col-md-8">
 <h5>Güvenli Ödeme</h5>
 <p>Ödemelerinizi EmlakProje güvencesiyle yapabilirsiniz.</p>
 </div>
 </div>
 </div>
 <div class="col-md-4">
 <div class="row">
 <div class="col-md-4">
 <span class="fa-stack fa-3x">
 <i class="fa fa-circle-thin fa-stack-2x"></i>
 <i class="fa fa-truck fa-stack-1x"></i>
 </span>
 </div>
 <div class="col-md-8">
 <h5>Ücretsiz Taşınma</h5>
 <p>İlk işleminize özel ücretsiz taşımacılık hizmetinden yararlanabilirsiniz.</p>
 </div>
 </div>
 </div>
</div>
 
 <!-- Yeni ilanların anasayfa vitrini kodları burada yer alacak -->
 <h1 class="text-center baslik pt-4 pb-3">Anasayfa Vitrini</h1>
 <div class="row">
 <?php
 // veritabanı yapılandırma dosyasını dahil et
 include 'config/vtabani.php';
 // kayıt listeleme sorgusu
 $sorgu='SELECT urunler.*, il.sehir, ilce.ilce, evarsa.ilanTuru, kategoriler.kategoriadi
 FROM urunler
 LEFT JOIN il ON urunler.il_id=il.id
 LEFT JOIN ilce ON urunler.ilce_id=ilce.id
 LEFT JOIN evarsa ON urunler.evarsa_id=evarsa.id
 LEFT JOIN kategoriler ON urunler.kategori_id=kategoriler.id
 WHERE onay="1" 
 ORDER BY giris_tarihi desc LIMIT 0,6';
 $stmt = $con->prepare($sorgu); // sorguyu hazırla
 $stmt->execute(); // sorguyu çalıştır
 $veri = $stmt->fetchAll(PDO::FETCH_ASSOC); // tablo verilerini oku
 foreach ($veri as $kayit) { ?>
 <div class="col-md-4 mb-4">
 <div class="card">
 <a style="text-decoration:none; color:#212529;" href="urundetay.php?id=<?php echo $kayit['id']?>">
 <?php echo $kayit['resim'] ? "<img src='content/images/".$kayit['resim']."' alt='".$kayit['urunadi']."' style='width:100%;height:275px' class='card-img-top' />":"<img src='content/images/gorsel-yok.jpg' style='width:100%;height:275px' class='card-img-top' />"; ?>
 <div class="card-body">
 <h4 class="card-title"><?php echo mb_substr($kayit['urunadi'],'0','25','UTF-8')."...";?></h4>
 <p class="card-text"><?php echo $kayit['sehir']."/".$kayit['ilce']?></p>
 <p class="card-text"><?php echo "<b>İlan Türü:</b> ".$kayit['kategoriadi']." ".$kayit['ilanTuru']?></p>
 </div>
 </a>
 <div class="card-footer text-muted">
 <a href="#" class="text-secondary float-left favori-ekle" style="text-decoration:none;" id="<?php echo $kayit['id']?>">
	<span class="fa-stack fa-1x">
	<i class="fa fa-circle-thin fa-stack-2x"></i>
	<i class="fa fa-heart fa-stack-1x"></i>
	</span> Favorile
 </a>
 <span class="badge badge-success p-2 float-right">
 <?php echo number_format($kayit['fiyat'], 0, ',', '.'); ?> &#8378;</span>
 </div>
 </div>
 </div>
 <?php }
 ?>
 </div>
 
 </div>


 <?php include "footer.php"; ?>