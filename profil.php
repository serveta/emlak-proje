<?php 
include "header.php";
 if ($_SESSION["kullanici_loginkey"] == "") {
 // oturum açılmamışsa login.php sayfasına git
 header("Location: index.php");
 }
// veritabanı bağlantı dosyasını dahil et
 include 'config/vtabani.php';

 // aktif kayıt bilgilerini oku
 try {
 // seçme sorgusunu hazırla
 $sorgu = "SELECT * FROM kullanicilar WHERE eposta = ? LIMIT 0,1";
 $stmt = $con->prepare( $sorgu );

 // eposta parametresini bağla (? işaretini $_SESSION["kullanici_loginkey"] değeri ile değiştir)
 $stmt->bindParam(1, $_SESSION["kullanici_loginkey"]);

 // sorguyu çalıştır
 $stmt->execute();

 // okunan kayıt bilgilerini bir değişkene kaydet
 $kayit = $stmt->fetch(PDO::FETCH_ASSOC);

 // formu dolduracak değişken bilgileri
 $id= $kayit['id'];
 $adsoyad = $kayit['adsoyad'];
 $kadi = $kayit['kadi'];
 $sifre = $kayit['sifre'];
 $eposta = $kayit['eposta'];
 $tel_no = $kayit['tel_no'];
 }
 // hatayı göster
 catch(PDOException $exception){
 die('HATA: ' . $exception->getMessage());
 }

 // Güncelle butonu tıklanmışsa
 if($_POST){

 try{
 // güncelleme sorgusu
 // çok fazla parametre olduğundan karışmaması için
 // soru işaretleri yerine etiketler kullanacağız
 $sorgu = "UPDATE kullanicilar SET adsoyad=:adsoyad, kadi=:kadi,
sifre=:sifre, eposta=:eposta, tel_no=:tel_no WHERE id=$id";

 // sorguyu hazırla
 $stmt = $con->prepare($sorgu);

 // gelen bilgileri değişkenlere kaydet
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
 echo "<div class='alert alert-success'>Bilgileriniz güncellendi.</div>";
 $_SESSION["kullanici_loginkey"] = $eposta;
 }else{
 echo "<div class='alert alert-danger'>Bilgileriniz güncellenemedi.</div>";
 }

 }
 // hata varsa göster
 catch(PDOException $exception){
 die('HATA: ' . $exception->getMessage());
 }
 }
?>

<div class="container p-5">
 <!-- Başlık burada yer alacak -->
 <h1 class="text-center baslik"><?php echo "Merhaba, ".$kadi; ?></h1>
<p class="text-center p-4">Aşağıdaki formu kullanarak bilgilerinizi güncelleyebilirsiniz.</p><hr>
 
 <!-- Form burada yer alacak -->
 <div class="row mt-4">
 <div class="col-md-4">
 <h2 class="baslik">Üye Bilgileri Formu</h2>
 </div>
 <div class="col-md-8">
 <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" name="kayit">
 <div class="form-group">
 <label for="exampleInputEmail1">Ad - Soyad</label>
 <input type="text" class="form-control" id="exampleInputText1" value="<?php echo $adsoyad; ?>" name="adsoyad">
 </div>
 <div class="form-group">
 <label for="exampleInputEmail1">Kullanıcı adı</label>
 <input type="text" class="form-control" value="<?php echo $kadi; ?>" name="kadi">
 </div>
 <div class="form-group">
 <label for="exampleInputEmail1">E-Posta adresi</label>
 <input type="email" class="form-control" id="exampleInputEmail1" ariadescribedby="emailHelp" value="<?php echo $eposta; ?>" name="eposta">
 </div>
 <div class="form-group">
 <label for="exampleInputEmail1">Telefon</label>
 <input type="tel" class="form-control" value="<?php echo $tel_no; ?>" name="tel_no">
 </div>
 <div class="form-group">
 <label for="exampleInputText2">Şifre</label>
 <input type="password" class="form-control" id="exampleInputText2"
value="<?php echo $sifre; ?>" name="sifre">
 </div>
 <button type="submit" class="btn btn-success">Güncelle</button>
 </form>
 </div>
 </div>
 
</div>
<?php include "footer.php"; ?>