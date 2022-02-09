<?php
 include 'config/vtabani.php';
 $ids = implode(',', $_POST['k_msj_id']);
 //$con->query("SELECT * FROM kullanicilar_mesaj WHERE k_msj_id IN ($ids)");
 
 
 $sorgu = "SELECT * FROM kullanicilar_mesaj WHERE k_msj_id IN ($ids)";
 $stmt = $con->prepare( $sorgu );
 $stmt->execute();
 $veri = $stmt->fetchAll(PDO::FETCH_ASSOC);
 
 foreach ($veri as $kayit) {
 // silinecek kayıt bilgilerini oku
 $sorgu = "DELETE FROM kullanicilar_mesaj WHERE (k_msj_kime=".$kayit['k_msj_kime']." AND k_msj_kimden=".$kayit['k_msj_kimden']." AND k_msj_konu='".$kayit['k_msj_konu']."') OR (k_msj_kime=".$kayit['k_msj_kimden']." AND k_msj_kimden=".$kayit['k_msj_kime']." AND k_msj_konu='".$kayit['k_msj_konu']."')";
 $stmt = $con->prepare($sorgu);

	 // sorguyu çalıştır
	 if($stmt->execute()){
	 // kayıt listeleme sayfasına yönlendir
	 // ve kullanıcıya kaydın silindiğini
	 header('Location: mesajlarim.php?islem=silindi');
	 } // veya silinemediğini bildir
	 else{
	 header('Location: mesajlarim.php?islem=silinemedi');
	 }
 }
 
 // header('Location: mesajlarim.php?islem=silindi');
?>