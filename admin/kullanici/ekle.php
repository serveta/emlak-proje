<?php include "../header.php"; ?>
<div class="container">
 <div class="page-header">
 <h1>Kullanıcı Ekle</h1>
 </div>
 <!-- PHP kayıt ekleme kodları burada yer alacak -->
 <?php
 if($_POST){
 // veritabanı yapılandırma dosyasını dahil et
 include '../../config/vtabani.php';
 try{
 // kayıt ekleme sorgusu
 $sorgu = "INSERT INTO kullanicilar SET adsoyad=:adsoyad, kadi=:kadi,
sifre=:sifre, eposta=:eposta, tel_no=:tel_no";
 // sorguyu hazırla
 $stmt = $con->prepare($sorgu);
 // post edilen değerler
 $adsoyad=htmlspecialchars(strip_tags($_POST['adsoyad']));
 $kadi=htmlspecialchars(strip_tags($_POST['kadi']));
 $sifre=htmlspecialchars(strip_tags($_POST['sifre']));
 $eposta=htmlspecialchars(strip_tags($_POST['eposta']));
 $tel_no=htmlspecialchars(strip_tags($_POST['tel_no']));
 // parametreleri bağla
 $stmt->bindParam(':adsoyad', $adsoyad);
 $stmt->bindParam(':kadi', $kadi);
 $stmt->bindParam(':sifre', $sifre);
 $stmt->bindParam(':eposta', $eposta);
 $stmt->bindParam(':tel_no', $tel_no);
 // sorguyu çalıştır
 if($stmt->execute()){
 echo "<div class='alert alert-success'>Kullanıcı kaydedildi.</div>";
 }else{
 echo "<div class='alert alert-danger'>Kullanıcı kaydedilemedi.</div>";
 }
 }
 // hatayı göster
 catch(PDOException $exception){
 die('ERROR: ' . $exception->getMessage());
 }
 }
?>
 
 <!-- Kullanıcı eklemek için kullanılacak html formu burada yer alacak -->
 <!-- Kullanıcı bilgilerini girmek için kullanılacak html formu -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
 <table class='table table-hover table-responsive table-bordered'>
 <tr>
 <td>Ad ve Soyad</td>
 <td><input type='text' name='adsoyad' class='form-control' /></td>
 </tr>
 <tr>
 <td>Kullanıcı adı</td>
 <td><input type='text' name='kadi' class='form-control' /></td>
 </tr>
 <tr>
 <td>E-Posta</td>
 <td><input type='text' name='eposta' class='form-control' /></td>
 </tr>
 <tr>
 <td>Telefon</td>
 <td><input type='text' name='tel_no' class='form-control' /></td>
 </tr>
 <tr>
 <td>Şifre</td>
 <td><input type='password' name='sifre' class='form-control' /></td>
 </tr>
 <tr>
 <td></td>
 <td>
 <input type='submit' value='Kaydet' class='btn btn-primary' />
 <a href='liste.php' class='btn btn-danger'>Kullanıcı listesi</a>
 </td>
 </tr>
 </table>
</form>
</div> <!-- container -->
<?php include "../footer.php"; ?>