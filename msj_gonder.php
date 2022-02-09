<?php 
include "header.php";
 if ($_SESSION["kullanici_loginkey"] == "") {
 // oturum açılmamışsa uyarı yap
 header("Location: kayit.php?islem=mesaj_gonderemez");
 }
 
 $konu = isset($_GET['konu']) ? $_GET['konu'] : "";
 $kime = isset($_GET['kime']) ? $_GET['kime'] : "";
 
 $sorguKonu = "SELECT id, urunadi FROM urunler WHERE id='".$konu."'";
 $stmtKonu = $con->prepare($sorguKonu);
 $stmtKonu->execute();
 $kayitKonu = $stmtKonu->fetch(PDO::FETCH_ASSOC);
 
 $sorguKime = "SELECT id FROM kullanicilar WHERE eposta='".$_SESSION["kullanici_loginkey"]."' LIMIT 0,1";
 $stmtKime = $con->prepare($sorguKime);
 $stmtKime->execute();
 $kayitKime = $stmtKime->fetch(PDO::FETCH_ASSOC);
 //BURADA ŞÖYLE OLACAK: Eğer ki sesssin ile GET edilen kime= kısmı aynı kişi ise mesaj verecek>>> Kişi kendine mesaj gönderemez..
 if ($kime == $kayitKime['id']) {
 echo "<div class='alert alert-danger text-center'>Kendinize mesaj gönderemezsiniz!</div>";
 $yasakla = "readonly";
 }
 
 $sorguKime2 = "SELECT * FROM kullanicilar WHERE id='".$kime."' LIMIT 0,1";
 $stmtKime2 = $con->prepare($sorguKime2);
 $stmtKime2->execute();
 $kayitKime2 = $stmtKime2->fetch(PDO::FETCH_ASSOC);
 
 $sorguKonuVeKimeArsa = "SELECT arsa_urun_id, arsa_kimden FROM arsabilgi WHERE arsa_urun_id='".$konu."' AND arsa_kimden='".$kime."' LIMIT 0,1";
 $stmtKonuVeKimeArsa = $con->prepare($sorguKonuVeKimeArsa);
 $stmtKonuVeKimeArsa->execute();
 $sayKonuVeKimeArsa = $stmtKonuVeKimeArsa->rowCount();
 
 $sorguKonuVeKimeEv = "SELECT ev_urun_id, ev_kimden FROM evbilgi WHERE ev_urun_id='".$konu."' AND ev_kimden='".$kime."' LIMIT 0,1";
 $stmtKonuVeKimeEv = $con->prepare($sorguKonuVeKimeEv);
 $stmtKonuVeKimeEv->execute();
 $sayKonuVeKimeEv = $stmtKonuVeKimeEv->rowCount();
 
if($_POST){
 // veritabanı yapılandırma dosyasını dahil et
 include 'config/vtabani.php';
 if($_POST['icerik'] == ""){
	 header('Location: urundetay.php?id='.$konu.'&islem=bosluk');
 }else{
	 try{
	 // kayıt ekleme sorgusu
	$sorgu = "INSERT INTO kullanicilar_mesaj SET k_msj_kimden=:k_msj_kimden, k_msj_kime=:k_msj_kime, k_msj_konu=:k_msj_konu, k_msj_icerik=:k_msj_icerik";
	// sorguyu hazırla
	$stmt = $con->prepare($sorgu);

	// post edilen değerler
	$k_msj_kimden=$kayitKime['id'];
	$k_msj_kime=$kayitKime2['id'];
	$k_msj_konu=htmlspecialchars(strip_tags($_POST['konu']));
	$k_msj_icerik=htmlspecialchars(strip_tags($_POST['icerik']));
	// parametreleri bağla
	$stmt->bindParam(':k_msj_kimden', $k_msj_kimden);
	$stmt->bindParam(':k_msj_kime', $k_msj_kime);
	$stmt->bindParam(':k_msj_konu', $k_msj_konu);
	$stmt->bindParam(':k_msj_icerik', $k_msj_icerik);
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
}else{
	echo "";
}
 
?>
<?php if($sayKonuVeKimeArsa>0 || $sayKonuVeKimeEv>0){ ?>
<div class="container p-5">
 <!-- Başlık burada yer alacak -->
 <h1 class="text-center baslik">Mesaj Gönder</h1>
<p class="text-center p-4">Aşağıdaki formu kullanarak ilan sahibi <b><?php echo $kayitKime2['adsoyad']; ?></b> ile iletişim kurabilirsiniz.</p>
<hr>
<!-- İletişim formu burada yer alacak -->
 <div class="row mt-4">
 <div class="col-md-4">
 <h2 class="baslik">İletişim Formu</h2>
 </div>
 <div class="col-md-8">
 <form action="" method="post" name="msjGonder">
 <div class="form-group">
 <label for="exampleInputText1">Konu</label>
 <input type="text" class="form-control" value="<?php echo $kayitKonu['urunadi']; ?>" name="konu" readonly>
 </div>
 <div class="form-group">
 <label for="exampleFormControlTextarea1">Mesajınız</label>
 <textarea class="form-control" id="exampleFormControlTextarea1" rows="4"
placeholder="İlan sahibine iletmek istediğiniz mesajı yazın..." name="icerik" <?php if($kime == $kayitKime['id']){echo $yasakla;} ?>></textarea>
 </div>
 <button type="submit" class="btn btn-success" <?php if($kime == $kayitKime['id']){echo 'style="visibility:hidden;"';} ?>>Gönder</button>
 </form>
 </div>
 </div>
</div>
<?php }else{
	echo "<div class='alert alert-danger text-center'>Konu ve kişi eşleştirilemedi. Mesaj gönderemezsiniz.</div><br/><br/><br/><br/><br/><br/><br/><br/>";
} ?>
<?php include "footer.php"; ?>