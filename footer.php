<!-- Simge kütüphanesi -->
 <link rel="stylesheet" href="content/css/font-awesome-4.7.0/css/font-awesome.min.css">
 
<div class="container-fluid bg-dark">
 <div class="container pt-4">
 <div class="row">
 <div class="col-md-4">
 <h4 class="text-white">Telif Hakkı</h4>
 <p class="text-light">Emlak Proje, ben Servet Arslan'ın<br/>
 Mustafa Kemal Üniversitesi, Bilgisayar<br/> 
 Programcılığı bölümü, internet<br/>
 programcılığı dersi için hazırlamış<br/>
 olduğum bir proje ödevimdir.
 <p class="text-light">
 © 2021 Emlak Proje</p>
 </p>
 </div>
 <div class="col-md-4">
 <h4 class="text-white">Fırsat Vitrini</h4>
 <!-- Fırsat ilanlarını listeleyen PHP kodları burada yer alacak -->
 <?php
 // veritabanı yapılandırma dosyasını dahil et
 include 'config/vtabani.php';
 // kayıt listeleme sorgusu
 $sorgu='SELECT id, urunadi, fiyat, resim FROM urunler WHERE onay="1" ORDER BY fiyat LIMIT 0,3';
 $stmt = $con->prepare($sorgu); // sorguyu hazırla
 $stmt->execute(); // sorguyu çalıştır
 $veri = $stmt->fetchAll(PDO::FETCH_ASSOC); // tablo verilerini oku
 foreach ($veri as $kayit) { ?>
 <div class="row mb-3">
 <div class="col-md-3">
<?php echo $kayit['resim'] ? "<img src='content/images/".$kayit['resim']."' alt='".$kayit['urunadi']."' class='img-fluid
img-thumbnail' />":"<img src='content/images/gorsel-yok.jpg' class='img-fluid img-thumbnail' />"; ?>
 </div>
 <div class="col-md-9">
 <a href="urundetay.php?id=<?php echo $kayit['id']?>" class="link1">
 <p class="firsat"><?php echo $kayit['urunadi']?></p>
 </a>
 <span class="badge badge-success p-1">
 <?php echo number_format($kayit['fiyat'], 0, ',', '.'); ?> &#8378;</span>
 </div>
 </div>
 <?php }
?>
 
 </div>
 <div class="col-md-4">
 <h4 class="text-white">İletişim</h4>
 <p class="text-light">
	7/24 Müşteri Hizmetleri<br/>
	<span class="fa-stack fa-1x">
	<i class="fa fa-circle-thin fa-stack-2x"></i>
	<i class="fa fa-phone fa-stack-1x"></i>
	</span> 0850 850 00 00
	<br/><br/>
	Yardım Merkezimiz<br/>
	<span class="fa-stack fa-1x">
	<i class="fa fa-circle-thin fa-stack-2x"></i>
	<i class="fa fa-envelope fa-stack-1x"></i>
	</span> yardim@emlakproje.com 
 </p>
 </div>
 </div>
 </div>
</div>
<!-- Kullanıcı tanımlı JavaScript kodları burada yer alacak -->
<!-- SweetAlert eklentisi -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<!-- Sepet işlemleri için gerekli JavaScript fonksiyonları -->
<script>
 $(document).ready(function(){
 // favori-ekle butonu ile tetiklenen fonksiyon burada yer alacak
 // favori-ekle butonu ile tetiklenir
$('.favori-ekle').on('click', function(){
 var id = $(this).attr('id');
 var sayi = parseInt(document.getElementById('urun-sayisi').innerHTML);
 if (document.getElementById('urun_'+id) !== null) {
 // buton urundetay.php sayfasında tıklanmış
 var adet=document.getElementById('urun_'+id).value;
 }
 else {
 // buton urunler.php sayfasında tıklanmış
 var adet=1;
 }
 // id ve adet parametreleri favorile.php sayfasına yönlendirilir
 $.ajax ({
 cache: false,
 type: 'POST',
 url: 'favorile.php',
 data: {id:id, adet:adet},
success: function(sonuc){
 if(sonuc=="true"){
 swal("Ürün favorilendi!", {
 icon: "success",
 buttons: false,
 timer: 1000,
 });
 // favorideki ürün sayısını güncelle
 $("#urun-sayisi").text(sayi + 1);
 }
 else{
 swal("Ürün daha önce favorilenmiş!", {
 icon: "warning",
 buttons: false,
 timer: 1000,
 });
 }
 },
 error: function(jqXHR, textStatus, errorThrown){
 alert(textStatus + errorThrown);
 }
 });
 return false;
});

 // urun-guncelle butonu ile tetiklenen fonksiyon burada yer alacak
 // urun-guncelle butonu ile tetiklenir
$('.urun-guncelle').on('click', function(){
 var id = $(this).attr('id');
 var adet = document.getElementById('urun_'+id).value;
 // id ve adet parametreleri favori_guncelle.php sayfasına yönlendirilir
 $.ajax ({
 cache: false,
 type: 'POST',
 url: 'favori_guncelle.php',
 data: {id:id, adet:adet},
 success: function(){
 swal("Ürün adedi güncellendi!", {
 icon: "success",
 buttons: false,
 timer: 1000,
 }).then(function() {
 window.location.href="favorilerim.php";
 });
 },
 error: function(jqXHR, textStatus, errorThrown){
 alert(textStatus + errorThrown);
 }
 });
 return false;
});
 
 // urun-sil butonu ile tetiklenen fonksiyon burada yer alacak
 // urun-sil butonu ile tetiklenir
$('.urun-sil').on('click', function(){
 var id = $(this).attr('id');
 // id parametresi favori_guncelle.php sayfasına yönlendirilir
 $.ajax ({
 cache: false,
 type: 'POST',
 url: 'favori_guncelle.php',
 data: {id:id},
 success: function(){
 swal("Ürün favorilerden çıkarıldı!", {
 icon: "success",
 buttons: false,
 timer: 1000,
 }).then(function() {
 window.location.href="favorilerim.php";
 });
 },
 error: function(jqXHR, textStatus, errorThrown){
 alert(textStatus + errorThrown);
 }
 });
 return false;
});

 
 });
</script>

</body>
</html>