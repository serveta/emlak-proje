 <?php 
 include "header.php"; 
 if ($_SESSION["kullanici_loginkey"] == "") {
 // oturum açılmamışsa login.php sayfasına git
 header("Location: index.php");
 }
 
 // silme mesajı burada yer alacak
 $islem = isset($_GET['islem']) ? $_GET['islem'] : "";
 // eğer silme (ilansil.php) sayfasından yönlendirme yapıldıysa
 if($islem=='silindi'){
 echo "<div class='alert alert-success'>İlan silindi.</div>";
 }
 else if($islem=='silinemedi'){
 echo "<div class='alert alert-danger'>İlan silinemedi.</div>";
 }
 
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
 $kullanici_id = $kayit['id'];
 }
 // hatayı göster
 catch(PDOException $exception){
 die('HATA: ' . $exception->getMessage());
 }
 ?>

 <div class="container pt-4">
 <!-- İlan kaydı kodları burada yer alacak -->
 <h1 class="text-center baslik pt-4 pb-3">Yayında Olan İlanlarım</h1>
 <div class="row">
 <?php
 // veritabanı yapılandırma dosyasını dahil et
 include 'config/vtabani.php';
 // kayıt listeleme sorgusu
 $sorgu='SELECT urunler.*, il.sehir, ilce.ilce, evarsa.ilanTuru, kategoriler.kategoriadi, evbilgi.ev_kimden, arsabilgi.arsa_kimden
 FROM urunler
 LEFT JOIN il ON urunler.il_id=il.id
 LEFT JOIN ilce ON urunler.ilce_id=ilce.id
 LEFT JOIN evarsa ON urunler.evarsa_id=evarsa.id
 LEFT JOIN kategoriler ON urunler.kategori_id=kategoriler.id
 LEFT JOIN evbilgi ON urunler.id=ev_urun_id
 LEFT JOIN arsabilgi ON urunler.id=arsa_urun_id
 WHERE urunler.onay="1" AND (evbilgi.ev_kimden="'.$kullanici_id.'" OR arsabilgi.arsa_kimden="'.$kullanici_id.'")
 ORDER BY giris_tarihi DESC';
 $stmt = $con->prepare($sorgu); // sorguyu hazırla
 $stmt->execute(); // sorguyu çalıştır
 $veri = $stmt->fetchAll(PDO::FETCH_ASSOC); // tablo verilerini oku
 foreach ($veri as $kayit) { ?>
 <div class="col-md-4 mb-4">
 <div class="card">
 <a style="text-decoration:none; color:#212529;" href="urundetay.php?id=<?php echo $kayit['id']?>">
 <?php echo $kayit['resim'] ? "<img src='content/images/".$kayit['resim']."' alt='".$kayit['urunadi']."' style='width:100%;height:275px' class='card-img-top' />":"<img src='content/images/gorsel-yok.jpg' style='width:100%;height:275px' class='card-img-top' />"; ?>
 <div class="card-body">
 <h4 class="card-title"><?php echo mb_substr($kayit['urunadi'],'0','20','UTF-8')."...";?></h4>
 <p class="card-text"><?php echo $kayit['sehir']."/".$kayit['ilce']?></p>
 <p class="card-text"><?php echo "<b>İlan Türü:</b> ".$kayit['kategoriadi']." ".$kayit['ilanTuru']?></p>
 </div>
 </a>
 <div class="card-footer text-muted">
 <span class="badge badge-success p-2 float-right">
 <?php echo number_format($kayit['fiyat'], 0, ',', '.'); ?> &#8378;</span>
 <br/> <hr/>
 <a style="text-decoration:none; color:#212529;" class='btn btn-info text-white' href="urundetay.php?id=<?php echo $kayit['id']?>">
	İlanı Gör
 </a>
 <a style="text-decoration:none; color:#212529;" class='btn btn-primary text-white' href="ilanduzenle.php?id=<?php echo $kayit['id']?>">
	Düzenle
 </a>
 <a style="text-decoration:none; color:#212529;" class='btn btn-danger m-r-1em text-white' href="ilansil.php?id=<?php echo $kayit['id']?>">
	Sil
 </a>
 </div>
 </div>
 </div>
 <?php }
 if(count($veri)<=0){
	 echo "<div class='alert alert-danger'>Yayında olan herhangi bir ilanınız yok.</div>";
 }
 ?>
 </div>
 </div>
 
 <div class="container pt-4">
 <!-- İlan kodları burada yer alacak -->
 <h1 class="text-center baslik pt-4 pb-3">Onay Bekleyen İlanlarım</h1>
 <div class="row">
 <?php
 // veritabanı yapılandırma dosyasını dahil et
 include 'config/vtabani.php';
 // kayıt listeleme sorgusu
 $sorgu='SELECT urunler.*, il.sehir, ilce.ilce, evarsa.ilanTuru, kategoriler.kategoriadi, evbilgi.ev_kimden, arsabilgi.arsa_kimden
 FROM urunler
 LEFT JOIN il ON urunler.il_id=il.id
 LEFT JOIN ilce ON urunler.ilce_id=ilce.id
 LEFT JOIN evarsa ON urunler.evarsa_id=evarsa.id
 LEFT JOIN kategoriler ON urunler.kategori_id=kategoriler.id
 LEFT JOIN evbilgi ON urunler.id=ev_urun_id
 LEFT JOIN arsabilgi ON urunler.id=arsa_urun_id
 WHERE urunler.onay="0" AND (evbilgi.ev_kimden="'.$kullanici_id.'" OR arsabilgi.arsa_kimden="'.$kullanici_id.'")
 ORDER BY giris_tarihi DESC';
 $stmt = $con->prepare($sorgu); // sorguyu hazırla
 $stmt->execute(); // sorguyu çalıştır
 $veri = $stmt->fetchAll(PDO::FETCH_ASSOC); // tablo verilerini oku
 foreach ($veri as $kayit) { ?>
 <div class="col-md-4 mb-4">
 <div class="card">
 <a style="text-decoration:none; color:#212529;" href="urundetay.php?id=<?php echo $kayit['id']?>">
 <?php echo $kayit['resim'] ? "<img src='content/images/".$kayit['resim']."' alt='".$kayit['urunadi']."' style='width:100%;height:275px' class='card-img-top' />":"<img src='content/images/gorsel-yok.jpg' style='width:100%;height:275px' class='card-img-top' />"; ?>
 <div class="card-body">
 <h4 class="card-title"><?php echo mb_substr($kayit['urunadi'],'0','20','UTF-8')."...";?></h4>
 <p class="card-text"><?php echo $kayit['sehir']."/".$kayit['ilce']?></p>
 <p class="card-text"><?php echo "<b>İlan Türü:</b> ".$kayit['kategoriadi']." ".$kayit['ilanTuru']?></p>
 </div>
 </a>
 <div class="card-footer text-muted">
 <span class="badge badge-success p-2 float-right">
 <?php echo number_format($kayit['fiyat'], 0, ',', '.'); ?> &#8378;</span>
 <br/> <hr/>
 <a style="text-decoration:none; color:#212529;" class='btn btn-info text-white' href="urundetay.php?id=<?php echo $kayit['id']?>">
	İlanı Gör
 </a>
 <a style="text-decoration:none; color:#212529;" class='btn btn-primary text-white' href="ilanduzenle.php?id=<?php echo $kayit['id']?>">
	Düzenle
 </a>
 <a style="text-decoration:none; color:#212529;" class='btn btn-danger m-r-1em text-white' href="ilansil.php?id=<?php echo $kayit['id']?>">
	Sil
 </a>
 </div>
 </div>
 </div>
 <?php }
 if(count($veri)<=0){
	 echo "<div class='alert alert-danger'>Onay bekleyen herhangi bir ilanınız bulunmuyor.</div>";
 }
 ?>
 </div>
 </div>


 <?php include "footer.php"; ?>