<?php 
include "header.php";

if($_POST){
 // veritabanı yapılandırma dosyasını dahil et
 include 'config/vtabani.php';
 try{
 // doğrulama sorgusu
 $sorgu = "SELECT sifre,onay FROM kullanicilar WHERE kadi='".$_POST['kadi']."' AND tel_no='".$_POST['tel_no']."'";

 $stmt = $con->prepare( $sorgu );
 // sorguyu çalıştır
 $stmt->execute();
 // gelen kaydı bir değişkende sakla
 $kayit = $stmt->fetch(PDO::FETCH_ASSOC);
 
 if(isset($kayit['sifre'])){
	 echo "<div class='alert alert-success text-center'>İşlem doğrulandı. ŞİFRENİZ: ".$kayit['sifre'];
	 if($kayit['onay']==0){echo " - NOT: Kaydınız henüz onaylanmamış. Bu yüzden henüz sisteme giriş yapamazsınız.";}
	 echo "</div>";
 }else{
	 echo "<div class='alert alert-danger text-center'>Girdiğiniz bilgilere ait bir kayıt bulunamadı.</div>";
 }
 
 }
 // hatayı göster
 catch(PDOException $exception){
 die('ERROR: ' . $exception->getMessage());
 }
 }
 

?>

<div class="container p-5">
 <!-- Başlık burada yer alacak -->
 <h1 class="text-center baslik">Emlak Proje - Şifremi Unuttum</h1>
<p class="text-center p-4">Aşağıdaki formu kullanarak şifrenizi öğrenebilirsiniz.</p><hr>
 
 <!-- Form burada yer alacak -->
 <div class="row mt-4">
 <div class="col-md-4">
 <h2 class="baslik">Şifremi Unuttum Formu</h2>
 </div>
 <div class="col-md-8">
 <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" name="sifre_unuttum">
 <div class="form-group">
 <label>Kullanıcı adınız</label>
 <input type="text" class="form-control" placeholder="Kullanıcı adınızı girin" name="kadi">
 </div>
 <div class="form-group">
 <label for="exampleInputText2">Telefon numaranız</label>
 <input type="text" class="form-control" placeholder="Telefon numaranızı girin" name="tel_no">
 </div>
 <button type="submit" class="btn btn-success">Şifremi ver</button>
 </form>
 </div>
 </div>
 
</div>
<?php include "footer.php"; ?>