<?php 
include "header.php";
 if ($_SESSION["kullanici_loginkey"] == "") {
 // oturum açılmamışsa login.php sayfasına git
 header("Location: index.php");
 }
?>

<div class="container p-5">
 <!-- Başlık burada yer alacak -->
 <h1 class="text-center baslik">Ücretsiz İlan Ver</h1>
<p class="text-center p-4">Lütfen ilan türünüzü seçin.</p>
<hr>
<div class="row mt-4">
 <div class="col-md-6">
	<a href="evilanver.php" class="btn btn-danger btn-lg active m-b-1em col-xs col-md m-r-1em pull-left" role="button" aria-pressed="true">
	<i class="fa fa-home fa-4x" aria-hidden="true"></i>
	<br/>
	Ev İlanı
	<br/>
	</a>
 </div>
 <div class="col-md-6">
	<a href="arsailanver.php" class="btn btn-info btn-lg active m-b-1em col-xs col-md m-r-1em pull-left" role="button" aria-pressed="true">
	<i class="fa fa-road fa-4x" aria-hidden="true"></i>
	<br/>
	Arsa İlanı
	<br/>
	</a>
 </div>
</div>
 
</div>
<?php include "footer.php"; ?>