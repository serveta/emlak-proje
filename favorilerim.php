<?php include "header.php";
// favori boşsa uyar
if(!isset($_SESSION['favori']) || empty($_SESSION['favori'])) {
 echo "<br/>
 <div class='container mt-5 mb-5'><div class='col-md-12'><div class='alert alert-danger'>
 Favorilerinize eklenmiş bir ürün yok!</div></div></div><br/><br/>";
}
// favori boş değilse ürünleri listele
else {
 // favorideki ürün bilgilerini veritabanından okuyan kodlar burada yer alacak
 // favorideki ürün id'lerini diziye kaydet
 $ids = array();
 if(isset($_SESSION['favori']) || !empty($_SESSION['favori'])){foreach($_SESSION['favori'] as $id=>$value){
 array_push($ids, $id);
 }
 $ids_arr = str_repeat('?,', count($ids) - 1) . '?';
 }else{ $ids_arr=0; }
 
 // veritabanı yapılandırma dosyasını dahil et
 include 'config/vtabani.php';
 // favorideki ürünleri getiren sorgu
 $sorgu = "SELECT urunler.id, urunler.urunadi, kategoriler.kategoriadi, il.sehir, ilce.ilce, urunler.fiyat, urunler.resim, urunler.evarsa_id 
 FROM urunler 
 LEFT JOIN il ON il.id=urunler.il_id
 LEFT JOIN ilce ON ilce.id=urunler.ilce_id
 LEFT JOIN kategoriler ON kategoriler.id=urunler.kategori_id
 WHERE urunler.id IN ({$ids_arr}) ORDER BY urunler.urunadi";
 // sorguyu hazırla
 $stmt = $con->prepare($sorgu);
 // sorguyu çalıştır
 $stmt->execute($ids);

 ?>
 <div class="container mt-4 mb-5">
 <!-- favorideki ürünleri görüntüleyen HTML tablosu burada yer alacak -->
 <div class="baslik">
 <h3>Favorilerim</h3>
 </div>
 <!-- favorideki ürünleri görüntüleyen HTML tablosu -->

 <div class="table-responsive">
 <table class="table table-bordered favori-tablo">
 <thead class="bg-light">
 <tr>
 <th>Resim</th>
 <th>Başlık</th>
 <th>İl / İlçe</th>
 <th>Kategori</th>
 <th>Fiyat</th>
 <th>Sil</th>
 </tr>
 </thead>
 <tbody>
 <!-- İlanları listeleyen döngü kodları burada yer alacak -->
<?php
$urun_toplami = 0;
$urun_sayisi = 0;
// Sepetteki ilanları listeleyen döngü
while ($kayit = $stmt->fetch(PDO::FETCH_ASSOC)) {
 extract($kayit);
 $adet = $_SESSION['favori'][$id]['adet'];
 $urun_sayisi += $adet;
 $urun_toplami += $fiyat * $adet;
 ?>
 <tr>
 <td>
 <?php echo $resim ? "<img src='content/images/{$resim}' alt='{$urunadi}' class='img-fluid img-thumbnail' width='80' />":"<img src='content/images/gorsel-yok.jpg' class='img-fluid img-thumbnail' width='80' />"; ?>
 </td>
 <td class="text-left">
 <h6><a href="urundetay.php?id=<?php echo $id; ?>" class="link2"><?php echo $urunadi; ?></a></h6>
 </td>
 <td>
 <h6><?php echo $sehir."/".$ilce; ?></h6>
 </td>
 <td>
 <h6><?php 
 if($evarsa_id=="1"){$evORarsa="Ev";}else if($evarsa_id=="2"){$evORarsa="Arsa";}
 echo $kategoriadi." ".$evORarsa; ?></h6>
 </td>
 <td>
 <h6><?php echo number_format($fiyat, 0, ',', '.'); ?>&#8378;</h6>
 </td>
 <td>
 <h6><a href="#" class="link2 urun-sil" id="<?php echo $id; ?>"><i class="fa fa-trash fa-2x"></i></a></h6>
 </td>
 </tr>
 <?php
} // while döngüsü sonu
?>
 </tbody>
 </table>
 </div><!--/favorideki ürünler son-->

 </div>
<?php
}
include "footer.php"; ?>