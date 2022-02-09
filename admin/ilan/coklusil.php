<?php
 include '../../config/vtabani.php';
 
 
 // silinecek kayıt bilgilerini oku
// seçme sorgusunu hazırla
$sorgu = "SELECT id, resim, resim_iki, resim_uc, resim_dort FROM urunler WHERE id = ? LIMIT 0,1";
$stmt = $con->prepare( $sorgu );
// id parametresini bağla (? işaretini id değeri ile değiştir)
$stmt->bindParam(1, $id);
// sorguyu çalıştır
$stmt->execute();
$kayit = $stmt->fetch(PDO::FETCH_ASSOC);
// okunan resim bilgilerini bir değişkene kaydet
$resim = $kayit['resim'];
$resim_iki = $kayit['resim_iki'];
$resim_uc = $kayit['resim_uc'];
$resim_dort = $kayit['resim_dort'];

 // kayda ait resim varsa sunucudan sil
if(!empty($resim)){
 $silinecek_resim = "../../content/images/".$resim;
 if (file_exists($silinecek_resim)) unlink($silinecek_resim);
}
if(!empty($resim_iki)){
 $silinecek_resim = "../../content/images/".$resim_iki;
 if (file_exists($silinecek_resim)) unlink($silinecek_resim);
}
if(!empty($resim_uc)){
 $silinecek_resim = "../../content/images/".$resim_uc;
 if (file_exists($silinecek_resim)) unlink($silinecek_resim);
}
if(!empty($resim_dort)){
 $silinecek_resim = "../../content/images/".$resim_dort;
 if (file_exists($silinecek_resim)) unlink($silinecek_resim);
}
 
 
 $ids = implode(',', $_POST['id']);
 $con->query("DELETE FROM urunler WHERE id IN ($ids)");
 $con->query("DELETE FROM evbilgi WHERE ev_urun_id IN ($ids)");
 $con->query("DELETE FROM arsabilgi WHERE arsa_urun_id IN ($ids)");
?>