<?php 

 include "header.php"; 

 $id=isset($_GET['id']) ? $_GET['id'] : die('HATA: Kayıt bulunamadı.');
 $islem = isset($_GET['islem']) ? $_GET['islem'] : "";
 
 if($islem=="bosluk"){
	 echo "<div class='alert alert-danger text-center'>Boş mesaj gönderemezsiniz!</div>";
 }

 // veritabanı bağlantı dosyasını çağır
 include 'config/vtabani.php';
 // aktif kayıt bilgilerini oku
 try {
 // seçme sorgusunu hazırla
 $sorgu = "SELECT * FROM kullanicilar_mesaj WHERE k_msj_id=$id";
 $stmt = $con->prepare( $sorgu );
 $stmt->execute();
 // gelen kaydı bir değişkende sakla
 $kayit = $stmt->fetch(PDO::FETCH_ASSOC);

 // tabloya yazılacak bilgileri değişkenlere doldur
 $k_msj_kimden=$kayit['k_msj_kimden'];
 $k_msj_kime=$kayit['k_msj_kime'];
 $k_msj_konu=$kayit['k_msj_konu'];
 $k_msj_icerik=$kayit['k_msj_icerik'];
 }
 // hatayı göster
 catch(PDOException $exception){
 die('HATA: ' . $exception->getMessage());
 }
 
 //Kişilerin id numarasına göre ismini bul
 $sorguKişiKime = "SELECT id, adsoyad FROM kullanicilar WHERE id=".$k_msj_kime;
 $stmtKişiKime = $con->prepare( $sorguKişiKime );
 $stmtKişiKime->execute();
 // gelen kaydı bir değişkende sakla
 $kayitKişiKime = $stmtKişiKime->fetch(PDO::FETCH_ASSOC);
 //diğer kullanıcı
 $sorguKişiKimden = "SELECT id, adsoyad FROM kullanicilar WHERE id=".$k_msj_kimden;
 $stmtKişiKimden = $con->prepare( $sorguKişiKimden );
 $stmtKişiKimden->execute();
 // gelen kaydı bir değişkende sakla
 $kayitKişiKimden = $stmtKişiKimden->fetch(PDO::FETCH_ASSOC);
 
 
 if($_POST){
 // veritabanı yapılandırma dosyasını dahil et
 include 'config/vtabani.php';
 if($_POST['icerik'] == ""){
	 header('Location: msj_detay.php?id='.$id.'&islem=bosluk');
 }else{
	 try{
	 // kayıt ekleme sorgusu
	$sorgu = "INSERT INTO kullanicilar_mesaj SET k_msj_kimden=:k_msj_kimden, k_msj_kime=:k_msj_kime, k_msj_konu=:k_msj_konu, k_msj_icerik=:k_msj_icerik";
	// sorguyu hazırla
	$stmt = $con->prepare($sorgu);

	// post edilen değerler
	$k_msj_kimden_tersi=$kayitKişiKime['id'];
	$k_msj_kime_tersi=$kayitKişiKimden['id'];
	$k_msj_konu_tersi=$kayit['k_msj_konu'];
	$k_msj_icerik_tersi=htmlspecialchars(strip_tags($_POST['icerik']));
	// parametreleri bağla
	$stmt->bindParam(':k_msj_kimden', $k_msj_kimden_tersi);
	$stmt->bindParam(':k_msj_kime', $k_msj_kime_tersi);
	$stmt->bindParam(':k_msj_konu', $k_msj_konu_tersi);
	$stmt->bindParam(':k_msj_icerik', $k_msj_icerik_tersi);
	 // sorguyu çalıştır
	 if($stmt->execute()){
		 echo "<div class='alert alert-success text-center'>Mesajınız başarıyla iletildi.</div>";
	 }else{
		 echo "<div class='alert alert-danger text-center'>Mesajınız iletilemedi!</div>";
	 }
	 }
	 // hatayı göster
	 catch(PDOException $exception){
	 die('ERROR: ' . $exception->getMessage());
	 }
 }
}
 
 ?>
<div class="container p-5">
 <!-- Başlık burada yer alacak -->
 <h1 class="text-center baslik">Mesaj İçeriği</h1>
<hr>
<div class='row justify-content-center'>
    <div class='col-auto'>
 <table class='table table-hover table-responsive table-bordered'>
 <tr>
 <td><b>Mesaj kimden</b></td><td><?php echo $kayitKişiKimden['adsoyad']; ?></td>
 </tr>
 <tr>
 <td style="width:130px;"><b>Mesaj kime</b></td><td><?php echo $kayitKişiKime['adsoyad']." (siz)"; ?></td>
 </tr>
 <tr>
 <td><b>Konu</b></td><td><?php echo $k_msj_konu; ?></td>
 </tr>
</table>
 </div>
 </div>
 
 <div class='row justify-content-center'>
    <div class='col-auto'>
 <div class="scrollDiv" id="myDiv">
 <table class='table table-hover table-responsive' style="width:785px;">
 <?php
  // seçme sorgusunu hazırla
	 $sorgu = "SELECT k_msj_kimden, k_msj_icerik, k_msj_tarih FROM kullanicilar_mesaj WHERE (k_msj_kimden='$k_msj_kimden' AND k_msj_konu='$k_msj_konu') OR (k_msj_kimden='$k_msj_kime' AND k_msj_kime='$k_msj_kimden' AND k_msj_konu='$k_msj_konu') ORDER BY k_msj_id";
	 $stmt = $con->prepare( $sorgu );
	 $stmt->execute();
	 $veriGelenMesaj = $stmt->fetchAll(PDO::FETCH_ASSOC);
	 foreach ($veriGelenMesaj as $kayitGelenMesaj) {
 ?>
 <tr>
 <td style="width:300px;text-align:center;">
 <b><?php if($kayitGelenMesaj['k_msj_kimden'] == $k_msj_kimden){ echo "<font color='green'>".$kayitKişiKimden['adsoyad']."</font>"; }else{ echo "<font color='blue'>".$kayitKişiKime['adsoyad']."</font>"; } ?></b> 
 <br/>
 <font size="1">
 <?php 
	echo substr($kayitGelenMesaj['k_msj_tarih'],'8','2')."-"; 
	echo substr($kayitGelenMesaj['k_msj_tarih'],'5','2')."-";
	echo substr($kayitGelenMesaj['k_msj_tarih'],'0','4');
	echo " / ".substr($kayitGelenMesaj['k_msj_tarih'],'11','5');
	?>
 </font>
 </td>
 <td style="width:500px;"><?php echo $kayitGelenMesaj['k_msj_icerik']; ?></td>
 </tr>
 <?php
	 }
 ?>
 </table>
 </div>
 </div>
 </div>
 
 <div class='row justify-content-center'>
    <div class='col-auto'>
 <table class='table table-hover table-responsive'>
 <tr>
 <td> 
 <!--<a href='#' onclick='silme_onay(<?php echo $id ?>);' class='btn btn-danger'> <span class='glyphicon glyphicon glyphicon-remove-circle'></span> (Çalışmıyor)Bu mesajı sil</a>
 <a href='mesajlarim.php' class='btn btn-warning'> <span class='glyphicon glyphicon glyphicon-list'></span> Mesajlarıma Dön</a>-->

<form action="" method="post" name="msjGonder">
 <div class="form-group">
 <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" cols="80"
placeholder="Cevabınızı yazın..." name="icerik"></textarea>
 </div>
 <button type="submit" class="btn btn-success">Cevapla</button>
 </form> 
 </td>
 </tr>
 </table>
</div>
</div>
</div>

 <?php include "footer.php"; ?>
 
 <!-- Kayıt silme onay kodları bu alana eklenecek -->
<script type='text/javascript'>
 // kayıt silme işlemini onayla
 function silme_onay( msj_id ){

 var cevap = confirm('Kaydı silmek istiyor musunuz?');
 if (cevap){
 // kullanıcı evet derse,
 // id bilgisini sil.php sayfasına yönlendirir
 window.location = 'msj_sil.php?id=' + msj_id;
 }
 }
 
  //scroll to the bottom of "#myDiv"
var myDiv = document.getElementById("myDiv");
    myDiv.scrollTop = myDiv.scrollHeight;
</script>