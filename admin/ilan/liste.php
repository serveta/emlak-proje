<?php include "../header.php"; ?>
<div class="container">
 <div class="page-header">
 <h1>İlan Listesi</h1>
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
 $sorgu = "SELECT urunler.id, urunler.urunadi, urunler.resim, urunler.fiyat, urunler.onay,
kategoriler.kategoriadi, il.sehir, ilce.ilce, evarsa.ilanTuru
FROM urunler 
LEFT JOIN kategoriler ON urunler.kategori_id = kategoriler.id
LEFT JOIN il ON urunler.il_id = il.id
LEFT JOIN ilce ON urunler.ilce_id = ilce.id
LEFT JOIN evarsa ON urunler.evarsa_id = evarsa.id
WHERE urunler.onay='1' AND (urunler.id LIKE :aranan OR evarsa.ilanTuru LIKE :aranan) ORDER BY urunler.id DESC LIMIT
:ilk_kayit_no, :sayfa_kayit_sayisi";
 $stmt = $con->prepare($sorgu);
 $stmt->bindParam(":ilk_kayit_no", $ilk_kayit_no, PDO::PARAM_INT);
 $stmt->bindParam(":sayfa_kayit_sayisi", $sayfa_kayit_sayisi, PDO::PARAM_INT);
 $stmt->bindParam(":aranan", $arama_sarti);
 $stmt->execute();

 
 // geriye dönen kayıt sayısı
 $sayi = $stmt->rowCount();
 
  //onay bekleyen ilanları sayan sorgu
 $onaySay = $con->query('SELECT count(*) FROM urunler WHERE onay="0"')->fetchColumn(); 

 // çoklu kayıt silme butonu
echo "<a href='#' id='btn_sil' class='btn btn-danger m-b-1em col-xs col-md m-r-1em pull-left'> 
<span class='glyphicon glyphicon glyphicon-remove'></span> Seçilenleri Sil</a>";
 
 // kayıt ekleme sayfasının linki
 echo "<a href='ekle_secim.php' class='btn btn-primary m-b-1em col-xs col-md m-r-1em pull-left'> 
 <span class='glyphicon glyphicon glyphicon-plus'></span> Yeni İlan</a>";

 //Onay Bekleyen ilanların listesi linki
  echo "<a href='onay.php' class='btn btn-warning m-b-1em col-xs col-md pull-left'> 
  <span class='glyphicon glyphicon glyphicon-ok'></span> Onay Bekleyen İlanlar ({$onaySay})</a>";

 ?>
 <!-- ilan arama formu -->
 <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"
method="get">
 <div class="row">
 <div class="col-xs-6 col-md-4 pull-right">
 <div class="input-group">
 <input type="text" class="form-control" placeholder="ID'ye göre ilan ara..."
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
 echo "<th></th>";
 echo "<th>ID</th>";
 echo "<th>Küçük Resim</th>";
 echo "<th>İlan adı</th>";
 echo "<th>Kategori</th>";
 echo "<th>Ev / Arsa</th>";
 echo "<th>İl / İlçe</th>";
 echo "<th>Fiyat</th>";
 echo "<th>İşlem</th>";
 echo "</tr>";

 // tablo içeriği burada yer alacak
 // tablo verilerinin okunması
 while ($kayit = $stmt->fetch(PDO::FETCH_ASSOC)){
 // tablo alanlarını değişkene dönüştürür
 // $kayit['urunadi'] => $urunadi
 extract($kayit);

 //İlan adını belli bir uzunlukta tutmak ve html gibi kodlardan korumak için filtreler
 $urunadi = trim(strip_tags($urunadi));
 if(strlen($urunadi) > 20){
	$urunadi = mb_substr($urunadi, 0, 20, 'UTF-8')."...";
 }
 
 // her kayıt için yeni bir tablo satırı oluştur
 echo "<tr>";
 echo "<td><input type='checkbox' name='sil_id[]' value='{$id}'/></td>";
 echo "<td>{$id}</td>";
 echo "<td>";if($resim){echo "<img src='../../content/images/".$resim."' alt='".$urunadi."' class='img-fluid img-thumbnail' width='80' />";}else{echo "<img src='../../content/images/gorsel-yok.jpg' class='img-fluid img-thumbnail' width='80' /></td>";}
 echo "<td>{$urunadi}</td>";
 echo "<td>{$kategoriadi}</td>";
 echo "<td>{$ilanTuru}</td>";
 echo "<td>{$sehir} / {$ilce}</td>";
 echo "<td>".number_format("{$fiyat}", 0, ',', '.')." &#8378;</td>"; // &#8378; ==> TL işareti
 echo "<td>";
 // kayıt detay sayfa bağlantısı
 echo "<a href='detay.php?id={$id}' class='btn btn-info m-r-1em'> <span
class='glyphicon glyphicon glyphicon-eye-open'></span> Detay</a>";
 // kayıt güncelleme sayfa bağlantısı
echo "<a href='duzelt.php?id={$id}' class='btn btn-primary m-r-1em'> <span
class='glyphicon glyphicon glyphicon-edit'></span> Düzelt</a>";
 // 
echo "<a href='#' onclick='silme_onay({$id});' class='btn btn-danger'> <span
class='glyphicon glyphicon glyphicon-remove-circle'></span> Sil</a>";
 echo "</td>";
 echo "</tr>";
 }

 echo "</table>"; // tablo sonu
// SAYFALANDIRMA
 // toplam kayıt sayısını hesapla
$sorgu = "SELECT  COUNT(*) as kayit_sayisi FROM urunler
LEFT JOIN evarsa ON urunler.evarsa_id = evarsa.id
WHERE onay='1' AND (urunler.id LIKE :aranan OR evarsa.ilanTuru LIKE :aranan)";
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

<!--- SweetAlert destekli çoklu silme --->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type='text/javascript'>
$(document).ready(function(){
 $('#btn_sil').click(function(){
 var id = [];
 $(':checkbox:checked').each(function(i){
 id[i] = $(this).val();
 });
 if(id.length === 0){ //dizi boşsa bilgi ver
 swal("Silmek için seçilmiş ilan yok!",{
 icon: "error",
 buttons: false,
 timer: 3000,
 });
 }
 else {
 swal({ // onay al
 title: "Emin misiniz?",
 text: "Silme işlemi geri alınamaz!",
 icon: "warning",
 buttons: ["Hayır", "Evet"],
 dangerMode: true,
 closeModal: false,
 })
 .then(function(yes){
 if (yes)
 $.ajax({
cache: false,
 type: 'POST',
 url: 'coklusil.php',
 data: {id:id},
 success: function(sonuc){
 swal("Seçili ilanlar silindi!", {
	 icon: "success",
 buttons: false,
 timer: 3000,
 });
// silinen kayıtları html tablosundan da sil
jQuery('input:checkbox:checked').parents("tr").remove();
 },
error: function(jqXHR, textStatus, errorThrown){
 alert(textStatus + errorThrown);
 }
 });
 })
 }
 });
});
</script>
