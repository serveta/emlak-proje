<?php include "../header.php"; 
// veritabanı bağlantı dosyasını çağır
 include '../../config/vtabani.php';
$onaySayKullanici = $con->query('SELECT count(*) FROM kullanicilar WHERE onay="0"')->fetchColumn(); 
$onaySayIlan = $con->query('SELECT count(*) FROM urunler WHERE onay="0"')->fetchColumn(); 
?>
<div class="container">
 <div class="page-header">
 <h1>Onay Bekleyen İşlemler</h1>
 </div>
	<?php
	// Onay bekleyen kullanıcıları gösteren Buton
	echo "<a href='../kullanici/onay.php' class='btn btn-warning btn-lg btn-block'> 
	<span class='glyphicon glyphicon-user'></span> Onay Bekleyen Kullanıcılar ({$onaySayKullanici})</a>";
	
	echo "<a href='../ilan/onay.php' class='btn btn-info btn-lg btn-block'> 
	<span class='glyphicon glyphicon-list'></span> Onay Bekleyen İlanlar ({$onaySayIlan})</a>";

	?>
 </div> <!-- /container -->
<?php include "../footer.php"; ?>