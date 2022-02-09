<?php include "../header.php"; ?>
<div class="container">
 <div class="page-header">
 <h1>Kullanıcı Listesi</h1>
 </div>
 <!-- Kayıtları listeleyecek PHP kodları bu alana eklenecek -->
 <?php
 // SAYFALANDIRMA DEĞİŞKENLERİ
 // sayfa parametresi aktif sayfa numarasını gösterir, parametre boşsa değeri 1'dir
 $sayfa = isset($_GET['sayfa']) ? $_GET['sayfa'] : 1;

 // bir sayfada görüntülenecek kayıt sayısı
 $sayfa_kayit_sayisi = 5;

 // sorgudaki LIMIT başlangıç değerini hesapla
 $ilk_kayit_no = ($sayfa_kayit_sayisi * $sayfa) - $sayfa_kayit_sayisi;
 
 // veritabanı bağlantı dosyasını çağır
 include '../../config/vtabani.php';

 // silme mesajı burada yer alacak
 $islem = isset($_GET['islem']) ? $_GET['islem'] : "";
 // eğer silme (sil.php) sayfasından yönlendirme yapıldıysa
 if($islem=='silindi'){
 echo "<div class='alert alert-success'>Kayıt silindi.</div>";
 }
 else if($islem=='silinemedi'){
 echo "<div class='alert alert-danger'>Kayıt silinemedi.</div>";
 }

 // sayfada görüntülenecek kayıtları seç
 $aranan = isset($_GET['aranan']) ? $_GET['aranan'] : "";
 $arama_sarti = isset($_GET['aranan']) ? "%".$_GET['aranan']."%" : "%";
 $sorgu = "SELECT * FROM kullanicilar WHERE onay<>'0' AND (adsoyad LIKE :aranan OR kadi LIKE :aranan OR eposta LIKE :aranan) ORDER BY id DESC LIMIT :ilk_kayit_no, :sayfa_kayit_sayisi";
 $stmt = $con->prepare($sorgu);
 $stmt->bindParam(":ilk_kayit_no", $ilk_kayit_no, PDO::PARAM_INT);
 $stmt->bindParam(":sayfa_kayit_sayisi", $sayfa_kayit_sayisi, PDO::PARAM_INT);
 $stmt->bindParam(":aranan", $arama_sarti);
 $stmt->execute();

 // geriye dönen kayıt sayısı
 $sayi = $stmt->rowCount();
 
 //onay bekleyen kullanıcıları sayan sorgu
 $onaySay = $con->query('SELECT count(*) FROM kullanicilar WHERE onay="0"')->fetchColumn(); 

 // kayıt ekleme sayfasının linki
 echo "<a href='ekle.php' class='btn btn-primary m-b-1em col-xs col-md m-r-1em pull-left'> 
 <span class='glyphicon glyphicon-plus'></span> Yeni Kullanıcı</a>";
 
 // Onay bekleyen kullanıcıları gösteren Buton
 echo "<a href='onay.php' class='btn btn-warning m-b-1em col-xs col-md pull-left'> 
 <span class='glyphicon glyphicon-ok'></span> Onay Bekleyen Kullanıcılar ({$onaySay})</a>";

 ?>
 <!-- kişi arama formu -->
 <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="get">
 <div class="row">
 <div class="col-xs-6 col-md-4 pull-right">
 <div class="input-group">
 <input type="text" class="form-control" placeholder="Kişi ara... (İsim, kullanıcı adı veya e-posta)"
name="aranan" value="<?php echo isset($_GET['aranan']) ? $_GET['aranan'] : ""; ?>"
/>
 <div class="input-group-btn">
 <button class="btn btn-primary" type="submit">
 <span class="glyphicon glyphicon-search"></span>
 </button>
 </div>
 </div>
 </div>
 </div>
 </form>
 <?php
 //kayıt varsa listele
 if($sayi>0){

 // kayıtlar burada listelenecek
 echo "<table class='table table-hover table-responsive table-bordered'>";
//tablo başlangıcı
 //tablo başlıkları
 echo "<tr>";
 echo "<th>ID</th>";
 echo "<th>Ad ve Soyad</th>";
 echo "<th>Kullanıcı adı</th>";
 echo "<th>E-Posta</th>";
 echo "<th>İşlem</th>";
 echo "</tr>";

 // tablo içeriği burada yer alacak
 // tablo verilerinin okunması
 while ($kayit = $stmt->fetch(PDO::FETCH_ASSOC)){
 // tablo alanlarını değişkene dönüştürür
 // $kayit['adsoyad'] => $adsoyad
 extract($kayit);

 // her kayıt için yeni bir tablo satırı oluştur
 echo "<tr>";
 echo "<td>{$id}</td>";
 echo "<td>{$adsoyad}</td>";
 echo "<td>{$kadi}</td>";
  echo "<td>{$eposta}</td>";
 echo "<td>";
 // kayıt güncelleme sayfa bağlantısı
 echo "<a href='duzelt.php?id={$id}' class='btn btn-primary m-r-1em'> <span class='glyphicon glyphicon-edit'></span> Düzelt</a>";
 // kayıt silme butonu
 echo "<a href='#' onclick='silme_onay({$id});' class='btn btn-danger'> <span class='glyphicon glyphicon-remove-circle'></span> Sil</a>"; 
 echo "</td>";
 echo "</tr>";
 }

 echo "</table>"; // tablo sonu
 // SAYFALANDIRMA
 // toplam kayıt sayısını hesapla
 $sorgu = "SELECT COUNT(*) as kayit_sayisi FROM kullanicilar WHERE onay<>'0' AND (adsoyad LIKE :aranan OR kadi LIKE :aranan OR eposta LIKE :aranan)";
 $stmt = $con->prepare($sorgu);
 $stmt->bindParam(":aranan", $arama_sarti);

 // sorguyu çalıştır
 $stmt->execute();

 // kayıt sayısını oku
 $kayit = $stmt->fetch(PDO::FETCH_ASSOC);
 $kayit_sayisi = $kayit['kayit_sayisi'];
 // kayıtları sayfalandır
 $sayfa_url="liste.php";
 include_once "../sayfalama.php";
 }
 // kayıt yoksa mesajla bildir
 else{
 echo "<div class='alert alert-danger'>Listelenecek kayıt bulunamadı.</div>";
 }
?>
 
 </div> <!-- /container -->
<?php include "../footer.php"; ?>
<!-- Kayıt silme onay kodları bu alana eklenecek -->
<script type='text/javascript'>
 // kayıt silme işlemini onayla
 function silme_onay( id ){

 var cevap = confirm('Kaydı silmek istiyor musunuz?');
 if (cevap){
 // kullanıcı evet derse,
 // id bilgisini sil.php sayfasına yönlendirir
 window.location = 'sil.php?id=' + id;
 }
 }
</script>