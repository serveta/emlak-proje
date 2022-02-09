<?php 
include "header.php";
 if ($_SESSION["kullanici_loginkey"] == "") {
 // oturum açılmamışsa login.php sayfasına git
 header("Location: index.php");
 }
 
 // silme mesajı burada yer alacak
 $islem = isset($_GET['islem']) ? $_GET['islem'] : "";
 // eğer silme (sil.php) sayfasından yönlendirme yapıldıysa
 if($islem=='silindi'){
 echo "<div class='alert alert-success'>Kayıt silindi.</div>";
 }
 else if($islem=='silinemedi'){
 echo "<div class='alert alert-danger'>Kayıt silinemedi.</div>";
 }
 
 $sorguKime = "SELECT id FROM kullanicilar WHERE eposta='".$_SESSION["kullanici_loginkey"]."' LIMIT 0,1";
 $stmtKime = $con->prepare($sorguKime);
 $stmtKime->execute();
 $kayitKime = $stmtKime->fetch(PDO::FETCH_ASSOC);
 
 $sorguGelenMesaj = "SELECT * FROM kullanicilar_mesaj WHERE k_msj_kimden='".$kayitKime['id']."' GROUP BY k_msj_kime ORDER BY k_msj_id DESC";
 $stmtGelenMesaj = $con->prepare($sorguGelenMesaj);
 $stmtGelenMesaj->execute();
 $sayGelenMesaj = $stmtGelenMesaj->rowCount();
 $veriGelenMesaj = $stmtGelenMesaj->fetchAll(PDO::FETCH_ASSOC);


?>

<div class="container p-5">
 <!-- Başlık burada yer alacak -->
 <h1 class="text-center baslik">Mesajlar</h1>
<p class="text-center p-4">Gelen kutunuzu ve gönderilen mesajlarınızı aşağıdan görebilirsiniz.</p>

<a href='mesajlarim.php' class='btn btn-success pull-left'>Gelen Mesajlara Bak</a>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="get">
 <div class="row">
 <div class="col-xs-6 col-md-8">
 <div class="input-group">
 <input type="text" class="form-control" placeholder="Mesaj ara...(İsim ya da mesaj aratabilirsiniz)"
name="aranan" value="<?php //echo isset($_GET['aranan']) ? $_GET['aranan'] : ""; ?>"/>
 <div class="input-group-btn">
 <button class="btn btn-primary" type="submit">
 Ara
 </button>
 </div>
 </div>
 </div>
 </div>
 </form>

<hr>
<div class="row mt-4">
 <div class="col-md-12">
 <div class='row justify-content-center'>
    <div class='col-auto'>
	<?php if($sayGelenMesaj>0){ ?>
	<table class="table table-hover table-responsive table-bordered favori-tablo">
	<tr>
	<th> <a href='#' id='btn_sil' class='btn btn-danger pull-left'>Seçilenleri Sil</a> </th>
	<th>Kime</th>
	<th>Konu</th>
	<th>İşlem</th>
	</tr>
	<?php
	 foreach ($veriGelenMesaj as $kayitGelenMesaj) {
	?>
		<tr>
		<td><?php echo "<input type='checkbox' name='sil_id[]' value='".$kayitGelenMesaj['k_msj_id']."'/>"; ?></td>
		<td><?php
			$sorguMsjKimdenAdSoyad = "SELECT adsoyad FROM kullanicilar WHERE id='".$kayitGelenMesaj['k_msj_kime']."' LIMIT 0,1";
			$stmtMsjKimdenAdSoyad = $con->prepare($sorguMsjKimdenAdSoyad);
			$stmtMsjKimdenAdSoyad->execute();
			$kayitMsjKimdenAdSoyad = $stmtMsjKimdenAdSoyad->fetch(PDO::FETCH_ASSOC);

			echo $kayitMsjKimdenAdSoyad['adsoyad']; 
			?></td>
		<td><?php echo mb_substr($kayitGelenMesaj['k_msj_konu'],'0','60','UTF-8')."..."; ?></td>
		<td>
		<?php
		
		$sorguMsjIcerik = "SELECT * FROM kullanicilar_mesaj WHERE k_msj_id<".$kayitGelenMesaj['k_msj_id']." AND k_msj_kimden=".$kayitGelenMesaj['k_msj_kime']." AND k_msj_kime=".$kayitGelenMesaj['k_msj_kimden']." AND k_msj_konu='".$kayitGelenMesaj['k_msj_konu']."'";
		$stmtMsjIcerik = $con->prepare($sorguMsjIcerik);
		$stmtMsjIcerik->execute();
		$sayMsjIcerik = $stmtMsjIcerik->rowCount();
		$kayitMsjIcerik = $stmtMsjIcerik->fetch(PDO::FETCH_ASSOC);
		
		if($sayMsjIcerik>0){
			// kayıt detay sayfa bağlantısı
			echo "<a href='msj_detay.php?id=".$kayitMsjIcerik['k_msj_id']."' class='btn btn-info m-r-1em'> <span
			class='glyphicon glyphicon glyphicon-eye-open'></span> Detay</a>";
		}else{
			// kayıt detay sayfa bağlantısı
		 echo "<a href='msj_detay_gonderilen.php?id=".$kayitGelenMesaj['k_msj_id']."' class='btn btn-info m-r-1em'> <span
		 class='glyphicon glyphicon glyphicon-eye-open'></span> Detay</a>";
		}
		
		
		 // kayıt sil
		 echo "<a href='#' onclick='silme_onay(".$kayitGelenMesaj['k_msj_id'].");' class='btn btn-danger'> <span
		 class='glyphicon glyphicon glyphicon-remove-circle'></span> Mesaj Grubunu Sil</a>";
		?>
		</td>
		</tr>
	 
	<?php
	 }
	?>
	</table>
	<?php }else{
		echo "<div class='alert alert-success text-center'>Gönderilen mesaj kutunuz boş görünüyor...</div>";
	} ?>
	</div>
	</div>
 </div>
 </div>
 
</div>
<?php include "footer.php"; ?>

<!-- Kayıt silme onay kodları bu alana eklenecek -->
<script type='text/javascript'>
 // kayıt silme işlemini onayla
 function silme_onay( k_msj_id ){

 var cevap = confirm('Bu mesaj grubuna ait tüm mesajlarınızı silmek istiyor musunuz?');
 if (cevap){
 // kullanıcı evet derse,
 // id bilgisini sil.php sayfasına yönlendirir
 window.location = 'msj_sil.php?id=' + k_msj_id;
 }
 }
</script>

<!--- SweetAlert destekli çoklu silme --->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type='text/javascript'>
$(document).ready(function(){
 $('#btn_sil').click(function(){
 var k_msj_id = [];
 $(':checkbox:checked').each(function(i){
 k_msj_id[i] = $(this).val();
 });
 if(k_msj_id.length === 0){ //dizi boşsa bilgi ver
 swal("Silmek için seçtiğiniz bir kayıt yok!",{
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
 url: 'msj_coklusil.php',
 data: {k_msj_id:k_msj_id},
 success: function(sonuc){
 swal("Seçili kayıtlar silindi!", {
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
