<?php
 // Oturum işlemlerini başlat
 ob_start();
 session_start();
 
 // Favori session oluşturulmamışsa oluştur
 $_SESSION['favori']=isset($_SESSION['favori']) ? $_SESSION['favori'] : array();
 
 // veritabanı bağlantı dosyasını dahil et
 include 'config/vtabani.php';

 // aktif kayıt bilgilerini oku
 try {
 // seçme sorgusunu hazırla
 $sorgu = "SELECT logo_baglanti FROM logo WHERE logo_k_durum=1";
 $stmt = $con->prepare( $sorgu );

 // sorguyu çalıştır
 $stmt->execute();

 // okunan kayıt bilgilerini bir değişkene kaydet
 $kayit = $stmt->fetch(PDO::FETCH_ASSOC);

 // formu dolduracak değişken bilgileri
 $logo_baglanti = $kayit['logo_baglanti'];
 }
 // hatayı göster
 catch(PDOException $exception){
 die('HATA: ' . $exception->getMessage());
 }
 
?>


<!doctype html>
<html lang="tr">
 <head>
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
 <title>Emlak Proje</title>

 <!-- Bootstrap CSS -->
 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
 <!-- Simge kütüphanesi -->
 <link rel="stylesheet" href="content/css/font-awesome-4.7.0/css/font-awesome.min.css">
 <!-- Benim stil dosyam -->
 <link rel="stylesheet" type="text/css" href="content/css/style.css">
 <!-- İlk önce jQuery, sonra Popper.js, sonra da Bootstrap JS -->
 <script type="text/javascript" src="content/js/jquery-3.3.1.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
 <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
 </head>
 <body>
 <!-- Duyuru satırı kodları burada yer alacak -->
 <div class="container-fluid bg-success">
 <div class="container">
 <div class="row p-2">
 <div class="col-md-8">
 <div class="text-white">
 <?php if(!isset($_SESSION["kullanici_loginkey"]) || empty($_SESSION["kullanici_loginkey"])){ ?>
	<a class="link1" style="font-size:12px;" href="kayit.php">Kayıt Ol</a> - <a class="link1" style="font-size:12px;" href="giris.php">Giriş Yap</a> 
	&nbsp;
	<a class="btn btn-warning btn-sm" href="kayit.php?islem=girisYokilanver" role="button">Ücretsiz ilan ver!</a>
	<?php }else{ ?>
	<a class="link1" style="font-size:12px;" href="profil.php">Profil</a> 
	-
	<a class="link1" style="font-size:12px;" href="ilanlarim.php">İlanlarım</a>	
	-
	<a class="link1" style="font-size:12px;" href="mesajlarim.php">Mesajlarım</a>	
	&nbsp;
	<a class="btn btn-warning btn-sm" href="ilanver.php" role="button">Ücretsiz ilan ver!</a>
	&nbsp;
	<a class="link1" style="font-size:12px;" href="giris.php?cikis=1">Çıkış</a>
 <?php } ?>
	
 </div>
 </div>
 <div class="col-md-4 text-right text-white">
 <a class="link1" href="favorilerim.php"> <!-- Favori içeriği sayfası linki -->
 <span class="fa-stack fa-1x">
 <i class="fa fa-circle-thin fa-stack-2x"></i>
 <i class="fa fa-heart fa-stack-1x"></i>
 </span> Favoriler
 <span class="badge badge-light" id="urun-sayisi">
 <!-- Favorideki ürün sayısı -->
 <?php
 if(isset($_SESSION['favori']) || !empty($_SESSION['favori'])){
	$urun_sayisi=count($_SESSION['favori']);
	echo $urun_sayisi;
 }else{echo 0;}
 ?>
</span>
 </a>
 </div>
 </div>
 </div>
</div>
 
 
 <!-- Logo, arama ve menü satırı kodları burada yer alacak -->
 <div class="container">
 <nav class="navbar navbar-expand-lg navbar-light bg-white">
 <a class="navbar-brand" href="index.php">
 <!-- Site logosu -->
 
 <img src="content/images/<?php echo $logo_baglanti; ?>" alt="Logo" style="width:150px;position:relative;">
 
 </a>
 <button class="navbar-toggler" type="button" data-toggle="collapse" datatarget="#navbarSupportedContent" aria-controls="navbarSupportedContent" ariaexpanded="false" aria-label="Toggle navigation">
 <span class="navbar-toggler-icon"></span>
 </button>
 <div class="collapse navbar-collapse" id="navbarSupportedContent">
 <!-- Arama formu -->
 <form class="form-inline my-2 my-lg-0" action="urunler.php" method="get"
name="form_ara">
 <input class="form-control mr-sm-2" type="search" placeholder="Arama yapın..." aria-label="Ara" name="aranan">
 <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Ara</button>
 </form>
 <ul class="navbar-nav ml-auto">
 <li class="nav-item">
 <a class="nav-link" href="index.php">Anasayfa <!--<span class="sronly">(current)</span>--></a>
 </li>
 <li class="nav-item">
 <a class="nav-link" href="urunler.php">İlanlar</a>
 </li>
 <li class="nav-item dropdown">
 <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
 Kategoriler
 </a>
 <div class="dropdown-menu" aria-labelledby="navbarDropdown">
 <!-- Burada katogorileri listeleyen PHP kodları yer alacak -->
 <?php
 // veritabanı yapılandırma dosyasını dahil et
 include 'config/vtabani.php';
 // kayıt listeleme sorgusu
 $sorgu='SELECT id, kategoriadi FROM kategoriler ORDER BY kategoriadi';
 $stmt = $con->prepare($sorgu); // sorguyu hazırla
 $stmt->execute(); // sorguyu çalıştır
 $veri = $stmt->fetchAll(PDO::FETCH_ASSOC); // tablo verilerini oku
 foreach ($veri as $kayit) { // her kategori için bir menü seçeneği oluştur
 echo "<a class='dropdown-item' href='urunler.php?id={$kayit["id"]}'>{$kayit["kategoriadi"]}</a>";
 }
?>
 </div>
 </li>
 <li class="nav-item">
 <a class="nav-link" href="hakkimizda.php">Hakkımızda</a>
 </li>
 </ul>
 </div>
 </nav>
</div>