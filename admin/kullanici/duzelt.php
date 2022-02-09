<?php include "../header.php"; ?>

 <div class="container">
 <div class="page-header">
 <h1>Kullanıcı Güncelleme</h1>
 </div>
 <!-- Kullanıcı bilgilerini getiren PHP kodu burada yer alacak -->
 <?php
 // gelen parametre değerini oku, Id bilgisi...
 $id=isset($_GET['id']) ? $_GET['id'] : die('HATA: Id bilgisi bulunamadı.');

 // veritabanı bağlantı dosyasını dahil et
 include '../../config/vtabani.php';

 // aktif kayıt bilgilerini oku
 try {
 // seçme sorgusunu hazırla
 $sorgu = "SELECT * FROM kullanicilar WHERE id = ? LIMIT 0,1";
 $stmt = $con->prepare( $sorgu );

 // id parametresini bağla (? işaretini id değeri ile değiştir)
 $stmt->bindParam(1, $id);

 // sorguyu çalıştır
 $stmt->execute();

 // okunan kayıt bilgilerini bir değişkene kaydet
 $kayit = $stmt->fetch(PDO::FETCH_ASSOC);

 // formu dolduracak değişken bilgileri
 $adsoyad = $kayit['adsoyad'];
 $kadi = $kayit['kadi'];
 $sifre = $kayit['sifre'];
 $eposta = $kayit['eposta'];
 $tel_no = $kayit['tel_no']; 
 $onay = $kayit['onay'];
 }
 // hatayı göster
 catch(PDOException $exception){
 die('HATA: ' . $exception->getMessage());
 }
?>
 
 <!-- Kullanıcı bilgilerini düzeltme HTML formu burada yer alacak -->
  <!-- kaydı güncelleyecek PHP kodu burada yer alacak -->
  <?php
 // Kaydet butonu tıklanmışsa
 if($_POST){

 try{
 // güncelleme sorgusu
 $sorgu = "UPDATE kullanicilar SET adsoyad=:adsoyad, kadi=:kadi,
sifre=:sifre, eposta=:eposta, tel_no=:tel_no, onay=:onay WHERE id=:id";

 // sorguyu hazırla
 $stmt = $con->prepare($sorgu);

 // gelen bilgileri değişkenlere kaydet
 $adsoyad=htmlspecialchars(strip_tags($_POST['adsoyad']));
 $kadi=htmlspecialchars(strip_tags($_POST['kadi']));
 $sifre=htmlspecialchars(strip_tags($_POST['sifre']));
 $eposta=htmlspecialchars(strip_tags($_POST['eposta']));
 $tel_no=htmlspecialchars(strip_tags($_POST['tel_no']));
 $onay=htmlspecialchars(strip_tags($_POST['onay']));

 // parametreleri bağla
 $stmt->bindParam(':adsoyad', $adsoyad);
 $stmt->bindParam(':kadi', $kadi);
 $stmt->bindParam(':sifre', $sifre);
 $stmt->bindParam(':id', $id);
 $stmt->bindParam(':eposta', $eposta);
 $stmt->bindParam(':tel_no', $tel_no);
 $stmt->bindParam(':onay', $onay);

 // sorguyu çalıştır
 if($stmt->execute()){
 echo "<div class='alert alert-success'>Kayıt güncellendi.</div>";
 }else{
 echo "<div class='alert alert-danger'>Kayıt güncellenemedi.</div>";
 }

 }
 // hata varsa göster
 catch(PDOException $exception){
 die('HATA: ' . $exception->getMessage());
 }
 }
?>
 <!-- kayıt bilgilerini güncelleyebileceğimiz HTML formu -->
 <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]."?id={$id}");?>"
method="post">
 <table class='table table-hover table-responsive table-bordered'>
 <tr>
 <td>Ad ve Soyad</td>
 <td><input type='text' name='adsoyad' value="<?php echo
htmlspecialchars($adsoyad, ENT_QUOTES); ?>" class='form-control' /></td>
 </tr>
 <tr>
 <td>Kullanıcı adı</td>
 <td><input type='text' name='kadi' value="<?php echo
htmlspecialchars($kadi, ENT_QUOTES); ?>" class='form-control' /></td>
 </tr>
 <tr>
 <td>E-Posta</td>
 <td><input type='text' name='eposta' value="<?php echo
htmlspecialchars($eposta, ENT_QUOTES); ?>" class='form-control' /></td>
 </tr>
 <tr>
 <td>Telefon</td>
 <td><input type='text' name='tel_no' value="<?php echo
htmlspecialchars($tel_no, ENT_QUOTES); ?>" class='form-control' /></td>
 </tr>
 <tr>
 <td>Şifre</td>
 <td><input type='password' name='sifre' value="<?php echo
htmlspecialchars($sifre, ENT_QUOTES); ?>" class='form-control' /></td>
 </tr>
 <tr>
 <td>Onay Durumu</td>
 <td><select name='onay' class='form-control'>
 <option value='1' <?php if($onay=="1") echo " selected" ?>>Admin</option>
 <option value='2' <?php if($onay=="2") echo " selected" ?>>Normal Üye</option>
 <option value='0' <?php if($onay=="0") echo " selected" ?>>Onaylanmamış</option>
</select></td>
 </tr>
 <tr>
 <td></td>
 <td>
 <button type="submit" class='btn btn-primary'><span class="glyphicon glyphicon-ok"></span> Kaydet</button>
 <a href='liste.php' class='btn btn-danger'><span class='glyphicon glyphicon glyphicon glyphicon-list'></span> Kullanıcı listesi</a>
 </td>
 </tr>
 </table>
 </form>
 
 </div> <!-- container -->

 <?php include "../footer.php"; ?>