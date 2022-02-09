
<?php
include '../config/vtabani.php';

//script koduyla post ettiğimiz il id değeri...
$ilid = $_POST["il"];

// ilce listeleme sorgusu
 $sorgu='SELECT id, ilce FROM ilce WHERE il_id="'.$ilid.'"';
 $stmt = $con->prepare($sorgu); // sorguyu hazırla
 $stmt->execute(); // sorguyu çalıştır
 $veri = $stmt->fetchAll(PDO::FETCH_ASSOC); // tablo verilerini oku

 foreach ($veri as $kayit) {
	echo '<option value="'.$kayit['id'].'">'.$kayit['ilce'].'</option>';
 }
?>