<?php include "../header.php"; ?>
<div class="container">
 <div class="page-header">
 <h1>Sliderlar</h1>
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
 }else if($islem=='slider_degisiti'){
 echo "<div class='alert alert-success'>Slider kullanım durumu değiştirildi.</div>";
 }else if($islem=='slider_degismedi'){
 echo "<div class='alert alert-danger'>Slider kullanım durumu değişmedi.</div>";
 }

 // sayfada görüntülenecek kayıtları seç
 $aranan = isset($_GET['aranan']) ? $_GET['aranan'] : "";
 $arama_sarti = isset($_GET['aranan']) ? "%".$_GET['aranan']."%" : "%";
 $sorgu = "SELECT * FROM slider WHERE slider_baslik LIKE :aranan OR slider_aciklama LIKE :aranan OR slider_id LIKE :aranan OR slider_baglanti LIKE :aranan ORDER BY slider_id DESC LIMIT :ilk_kayit_no, :sayfa_kayit_sayisi";
 $stmt = $con->prepare($sorgu);
 $stmt->bindParam(":ilk_kayit_no", $ilk_kayit_no, PDO::PARAM_INT);
 $stmt->bindParam(":sayfa_kayit_sayisi", $sayfa_kayit_sayisi, PDO::PARAM_INT);
 $stmt->bindParam(":aranan", $arama_sarti);
 $stmt->execute();

 // geriye dönen kayıt sayısı
 $sayi = $stmt->rowCount();
 

 // kayıt ekleme sayfasının linki
 echo "<a href='slider_ekle.php' class='btn btn-primary m-b-1em col-xs col-md m-r-1em pull-left'> 
 <span class='glyphicon glyphicon-plus'></span> Yeni Slider</a>";

 ?>
 <!-- slider arama formu -->
 <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"
method="get">
 <div class="row">
 <div class="col-xs-6 col-md-4 pull-right">
 <div class="input-group">
 <input type="text" class="form-control" placeholder="Slider ara..."
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
 echo "<table class='table table-hover table-responsive table-bordered favori-tablo'>";
//tablo başlangıcı
 //tablo başlıkları
 echo "<tr>";
 echo "<th>ID</th>";
 echo "<th>Slider</th>";
 echo "<th>Başlık</th>";
 echo "<th>Açıklama</th>";
 echo "<th>Kullanım Durumu</th>";
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
 echo "<td>{$slider_id}</td>";
 echo "<td><img src='../../content/images/{$slider_baglanti}' alt='slider' style='width:150px;'></td>";
 echo "<td>{$slider_baslik}</td>";
 echo "<td>{$slider_aciklama}</td>";
  echo "<td>"; 
  if($slider_k_durum == 0){
  echo "<a href='slider_kullan.php?slider_id={$slider_id}&slider_k_durum=1' class='btn btn-success m-r-1em'> <span class='glyphicon glyphicon-ok'></span> Slider-1</a>";
  echo "<a href='slider_kullan.php?slider_id={$slider_id}&slider_k_durum=2' class='btn btn-success m-r-1em'> <span class='glyphicon glyphicon-ok'></span> Slider-2</a>";
  echo "<a href='slider_kullan.php?slider_id={$slider_id}&slider_k_durum=3' class='btn btn-success m-r-1em'> <span class='glyphicon glyphicon-ok'></span> Slider-3</a>";
  }else if($slider_k_durum == 1 || $slider_k_durum == 2 || $slider_k_durum == 3){
  echo "<a href='slider_kullan.php?slider_id={$slider_id}&slider_k_durum=0' class='btn btn-warning m-r-1em'> <span class='glyphicon glyphicon-remove'></span> Durdur (Slider-$slider_k_durum)</a>";
  }
  echo "</td>";
 echo "<td>";
 // kayıt güncelleme sayfa bağlantısı
 echo "<a href='slider_duzelt.php?slider_id={$slider_id}' class='btn btn-primary m-r-1em'> <span class='glyphicon glyphicon-edit'></span> Düzelt</a>";
 // kayıt silme butonu
 echo "<a href='#' onclick='silme_onay({$slider_id});' class='btn btn-danger'> <span class='glyphicon glyphicon-remove-circle'></span> Sil</a>"; 
 echo "</td>";
 echo "</tr>";
 }

 echo "</table>"; // tablo sonu
 // SAYFALANDIRMA
 // toplam kayıt sayısını hesapla
 $sorgu = "SELECT COUNT(*) as kayit_sayisi FROM slider WHERE slider_baslik LIKE :aranan OR slider_aciklama LIKE :aranan OR slider_id LIKE :aranan OR slider_baglanti LIKE :aranan";
 $stmt = $con->prepare($sorgu);
 $stmt->bindParam(":aranan", $arama_sarti);

 // sorguyu çalıştır
 $stmt->execute();

 // kayıt sayısını oku
 $kayit = $stmt->fetch(PDO::FETCH_ASSOC);
 $kayit_sayisi = $kayit['kayit_sayisi'];
 // kayıtları sayfalandır
 $sayfa_url="slider_liste.php";
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
 function silme_onay( slider_id ){

 var cevap = confirm('Kaydı silmek istiyor musunuz?');
 if (cevap){
 // kullanıcı evet derse,
 // id bilgisini slider_sil.php sayfasına yönlendirir
 window.location = 'slider_sil.php?slider_id=' + slider_id;
 }
 }
</script>