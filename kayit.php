<?php 
include "header.php";
 // kayıt mesajı burada yer alacak
 $islem = isset($_GET['islem']) ? $_GET['islem'] : "";
 // eğer kayitekle (kayitekle.php) sayfasından yönlendirme yapıldıysa
 if($islem=='basarili'){
 echo "<div class='alert alert-success text-center'>Kaydınız onay işlemine gönderildi.</div>";
 }
 else if($islem=='basarisiz'){
 echo "<div class='alert alert-danger text-center'>Kayıt ekleme başarısız.</div>";
 }
 else if($islem=='girisYokilanver'){
 echo "<div class='alert alert-danger text-center'>*Ücretsiz İlan vermek için öncelikle kayıt olmanız gerekir.
	<br/>
	Eğer üye iseniz <a href='giris.php'>giriş</a> yapmanız gerekir.
 </div>";
 }
 else if($islem=='mesaj_gonderemez'){
 echo "<div class='alert alert-danger text-center'>*İlan sahibine mesaj gönderebilmek için öncelikle kayıt olmanız gerekir.
	<br/>
	Eğer üye iseniz <a href='giris.php'>giriş</a> yapmanız gerekir.
 </div>";
 }
 else if($islem=='bosluk'){
 echo "<div class='alert alert-danger text-center'>*Tüm alanları doldurmadınız.</div>";
 }
?>

<div class="container p-5">
 <!-- Başlık burada yer alacak -->
 <h1 class="text-center baslik">Emlak Proje - Kayıt Ol</h1>
<p class="text-center p-4">Aşağıdaki formu kullanarak sisteme kayıt olabilirsiniz.</p><hr>
 
 <!-- Form burada yer alacak -->
 <div class="row mt-4">
 <div class="col-md-4">
 <h2 class="baslik">Üye Kayıt Formu</h2>
 </div>
 <div class="col-md-8">
 <form action="kayitekle.php" method="post" name="kayit">
 <div class="form-group">
 <label for="exampleInputEmail1">Ad - Soyad</label>
 <input type="text" class="form-control" id="exampleInputText1" placeholder="Adınızı ve Soyadınızı girin" name="adsoyad">
 </div>
 <div class="form-group">
 <label for="exampleInputEmail1">Kullanıcı adı</label>
 <input type="text" class="form-control" placeholder="Kullanıcı adınızı girin" name="kadi">
 </div>
 <div class="form-group">
 <label for="exampleInputEmail1">E-Posta adresi</label>
 <input type="email" class="form-control" id="exampleInputEmail1" ariadescribedby="emailHelp" placeholder="E-posta adresinizi girin" name="eposta">
 </div>
 <div class="form-group">
 <label for="exampleInputEmail1">Telefon</label>
 <input type="tel" class="form-control" placeholder="Telefon numaranızı girin" name="tel_no">
 </div>
 <div class="form-group">
 <label for="exampleInputText2">Şifre</label>
 <input type="password" class="form-control" id="exampleInputText2"
placeholder="Şifrenizi girin" name="sifre">
 </div>
 <button type="submit" class="btn btn-success">Kayıt Ol</button>
 </form>
 </div>
 </div>
 
</div>
<?php include "footer.php"; ?>