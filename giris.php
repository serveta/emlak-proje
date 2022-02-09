<?php 
include "header.php";
// oturum sonlandırma kontrolü
 if ($_GET) {
 $cikis = $_GET["cikis"];
 if ($cikis == 1) {
 //session_destroy(); // TÜM SESSIONları - oturumu sonlandır
 unset($_SESSION["kullanici_loginkey"]); // oturum değişkenini sıfırla
 header("Location: index.php");
 }
 }
 
 // kullanıcı kontrolü
 if ($_POST){
 $eposta = $_POST["eposta"];
 $ksifre = $_POST["ksifre"];
 if (isset($eposta) && isset($ksifre)) {
 include"config/vtabani.php";
 try {
 $sorgu = "SELECT adsoyad,eposta,sifre,onay FROM kullanicilar WHERE eposta=:eposta AND sifre=:ksifre";
 $stmt = $con->prepare($sorgu);

 // parametreleri bağla
 $stmt->bindParam(":eposta", $eposta);
 $stmt->bindParam(":ksifre", $ksifre);
 // sorguyu çalıştır
 $stmt->execute();
 // gelen kaydı bir değişkende sakla
 $kayit = $stmt->fetch(PDO::FETCH_ASSOC);

 $sayi = $stmt->rowCount();

 if(@$kayit['onay']==0 && $sayi>0 ){
	 echo "<div class='alert alert-danger text-center'>Özür dileriz <b>".$kayit['adsoyad']."</b> henüz üyeliğiniz onaylanmamış.</div>";
 }else if (@$kayit['onay']!=0 && $sayi>0) {
	 $_SESSION["kullanici_loginkey"] = $eposta; // oturum değişkenini oluştur
	 header("Location: index.php");
 }else if($eposta == ""){
	 echo "<div class='alert alert-danger text-center'>*E-posta adresinizi yazmadınız.</div>";
 }else if($ksifre == ""){
	 echo "<div class='alert alert-danger text-center'>*Şifrenizi yazmadınız.</div>";
 }else{
	echo "<div class='alert alert-danger text-center'>E-posta adresiniz veya şifreniz yanlış. <a href='sifremi_unuttum.php'>Şifrenizi unuttuysanız buraya tıklayın.</a></div>";
 }
 
 }
 // hatayı göster
 catch(PDOException $exception){
 die('HATA: ' . $exception->getMessage());
 }
 }
 }
 $_SESSION["kullanici_loginkey"] = isset($_SESSION["kullanici_loginkey"]) ? $_SESSION["kullanici_loginkey"] : "";
 
 // favori oluşturulmamışsa oluştur
 $_SESSION['favori']=isset($_SESSION['favori']) ? $_SESSION['favori'] : array();
?>

<div class="container p-5">
 <!-- Başlık burada yer alacak -->
 <h1 class="text-center baslik">Emlak Proje - Giriş</h1>
<p class="text-center p-4">Aşağıdaki formu kullanarak sisteme giriş yapabilirsiniz.</p><hr>
 
 <!-- Form burada yer alacak -->
 <div class="row mt-4">
 <div class="col-md-4">
 <h2 class="baslik">Üye Giriş Formu</h2>
 </div>
 <div class="col-md-8">
 <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" name="giris">
 <div class="form-group">
 <label for="exampleInputEmail1">E-Posta adresi</label>
 <input type="email" class="form-control" id="exampleInputEmail1" ariadescribedby="emailHelp" placeholder="E-posta adresinizi girin" name="eposta">
 </div>
 <div class="form-group">
 <label for="exampleInputText2">Şifre</label>
 <input type="password" class="form-control" id="exampleInputText2"
placeholder="Şifrenizi girin" name="ksifre">
<small>&nbsp;&nbsp;<a href="sifremi_unuttum.php">Şifremi Unuttum</a></small>
 </div>
 <button type="submit" class="btn btn-success">Giriş</button>
 </form>
 </div>
 </div>
 
</div>
<?php include "footer.php"; ?>