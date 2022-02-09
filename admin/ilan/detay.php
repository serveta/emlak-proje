<?php include "../header.php"; ?>

 <div class="container">
 <div class="page-header">
 <h1>İlan Bilgisi</h1>
 </div>
 <!-- ilan bilgilerini getiren PHP kodu burada yer alacak -->
 <?php
 // gelen Id parametresini al
 // isset() bir değer olup olmadığını kontrol eden PHP fonksiyonudur
 $id=isset($_GET['id']) ? $_GET['id'] : die('HATA: Kayıt bulunamadı.');

 // veritabanı bağlantı dosyasını çağır
 include '../../config/vtabani.php';
 // aktif kayıt bilgilerini oku
 try {
 // seçme sorgusunu hazırla
 $sorgu = "SELECT urunler.urunadi, urunler.aciklama, urunler.fiyat, urunler.giris_tarihi, urunler.dzltm_tarihi,
urunler.resim, urunler.resim_iki, urunler.resim_uc, urunler.resim_dort, urunler.evarsa_id, kategoriler.kategoriadi, evbilgi.ev_tipi, evbilgi.ev_metrekare, evbilgi.oda_sayisi,
	evbilgi.bina_yasi, evbilgi.kat_sayisi, evbilgi.isitma, evbilgi.banyo_sayisi, evbilgi.esyali, evbilgi.kullanim_durumu,
	evbilgi.site_icinde, evbilgi.aidat, evbilgi.ev_krediye_uygun, evbilgi.ev_kimden, evbilgi.ev_takas,
	arsabilgi.imar_durumu, arsabilgi.arsa_metrekare, arsabilgi.metrekare_fiyat, arsabilgi.ada_no, arsabilgi.parsel_no,
	arsabilgi.pafta_no, arsabilgi.emsal, arsabilgi.tapu_durumu, arsabilgi.kat_karsiligi, arsabilgi.arsa_krediye_uygun, arsabilgi.arsa_kimden, arsabilgi.arsa_takas
FROM urunler 
LEFT JOIN kategoriler ON urunler.kategori_id = kategoriler.id 
LEFT JOIN evbilgi ON urunler.id = evbilgi.ev_urun_id 
LEFT JOIN arsabilgi ON urunler.id = arsabilgi.arsa_urun_id 
WHERE urunler.id = ? LIMIT 0,1";
$stmt = $con->prepare( $sorgu );


 // Id parametresini bağla
 $stmt->bindParam(1, $id);

 // sorguyu çalıştır
 $stmt->execute();

 // gelen kaydı bir değişkende sakla
 $kayit = $stmt->fetch(PDO::FETCH_ASSOC);

 // tabloya yazılacak bilgileri değişkenlere doldur
 $urunadi = $kayit['urunadi'];
 $aciklama = $kayit['aciklama'];
 $fiyat = $kayit['fiyat'];
 $giris_tarihi = $kayit['giris_tarihi'];
 $dzltm_tarihi = $kayit['dzltm_tarihi'];
 $resim = htmlspecialchars($kayit['resim'], ENT_QUOTES);
 $resim_iki = htmlspecialchars($kayit['resim_iki'], ENT_QUOTES);
 $resim_uc = htmlspecialchars($kayit['resim_uc'], ENT_QUOTES);
 $resim_dort = htmlspecialchars($kayit['resim_dort'], ENT_QUOTES);
 $evarsa_id = $kayit['evarsa_id'];
 $kategoriadi = $kayit['kategoriadi'];
 $ev_tipi = $kayit['ev_tipi'];
 $ev_metrekare = $kayit['ev_metrekare'];
 $oda_sayisi = $kayit['oda_sayisi'];
 $bina_yasi = $kayit['bina_yasi'];
 $kat_sayisi = $kayit['kat_sayisi'];
 $isitma = $kayit['isitma'];
 $banyo_sayisi = $kayit['banyo_sayisi'];
 $esyali = $kayit['esyali'];
 $kullanim_durumu = $kayit['kullanim_durumu'];
 $site_icinde = $kayit['site_icinde'];
 $aidat = $kayit['aidat'];
 $ev_krediye_uygun = $kayit['ev_krediye_uygun'];
 $ev_kimden = $kayit['ev_kimden'];
 $ev_takas = $kayit['ev_takas'];
 $imar_durumu = $kayit['imar_durumu'];
 $arsa_metrekare = $kayit['arsa_metrekare'];
 $metrekare_fiyat = $kayit['metrekare_fiyat'];
 $ada_no = $kayit['ada_no'];
 $parsel_no = $kayit['parsel_no'];
 $pafta_no = $kayit['pafta_no'];
 $emsal = $kayit['emsal'];
 $tapu_durumu = $kayit['tapu_durumu'];
 $kat_karsiligi = $kayit['kat_karsiligi'];
 $arsa_krediye_uygun = $kayit['arsa_krediye_uygun'];
 $arsa_kimden = $kayit['arsa_kimden'];
 $arsa_takas = $kayit['arsa_takas'];
 }

 // hatayı göster
 catch(PDOException $exception){
 die('HATA: ' . $exception->getMessage());
 }
 ?>

 <!-- ilan bilgilerini görüntüleyen HTML tablosu burada yer alacak -->
 <!--kayıt bilgilerini görüntüleyen HTML tablosu -->
 <table class='table table-hover table-responsive table-bordered'>
 <tr>
 <td>Resim-1</td>
 <td><?php echo $resim ? "<img src='../../content/images/{$resim}' style='width:300px;' />" : "<img src='../../content/images/gorsel-yok.jpg' style='width:300px;'/>"; ?></td>
 </tr>
 <tr>
 <td>Resim-2</td>
 <td><?php echo $resim_iki ? "<img src='../../content/images/{$resim_iki}' style='width:300px;' />" : "<img src='../../content/images/gorsel-yok.jpg' style='width:300px;'/>"; ?></td>
 </tr>
 <tr>
 <td>Resim-3</td>
 <td><?php echo $resim_uc ? "<img src='../../content/images/{$resim_uc}' style='width:300px;' />" : "<img src='../../content/images/gorsel-yok.jpg' style='width:300px;'/>"; ?></td>
 </tr>
 <tr>
 <td>Resim-4</td>
 <td><?php echo $resim_dort ? "<img src='../../content/images/{$resim_dort}' style='width:300px;' />" : "<img src='../../content/images/gorsel-yok.jpg' style='width:300px;'/>"; ?></td>
 </tr>
 <tr>
 <td>İlan Giriş Tarihi</td>
 <td><?php echo substr(htmlspecialchars($giris_tarihi, ENT_QUOTES),'0','10'); ?></td>
 </tr>
 <tr>
 <td>İlan Güncellenme Tarihi</td>
 <td><?php echo substr(htmlspecialchars($dzltm_tarihi, ENT_QUOTES),'0','10'); ?></td>
 </tr>
 <tr>
 <td>İlan Başlığı</td>
 <td><?php echo htmlspecialchars($urunadi, ENT_QUOTES); ?></td>
 </tr>
 <tr>
 <td>Açıklama</td>
 <td><?php echo htmlspecialchars($aciklama, ENT_QUOTES); ?></td>
 </tr>
 <tr>
 <td>Fiyat</td>
 <td><?php echo htmlspecialchars(number_format($fiyat, 0, ',', '.'), ENT_QUOTES); ?> &#8378;</td>
 </tr>
 <tr>
 <td>Kategori</td>
 <td><?php echo htmlspecialchars($kategoriadi, ENT_QUOTES); ?></td>
 </tr>
 <?php if($evarsa_id == 1){  ?>
	<tr>
	<td>Ev Tipi</td>
	<td><?php echo htmlspecialchars($ev_tipi, ENT_QUOTES); ?></td>
	</tr>
	<tr>
	<td>Metrekare</td>
	<td><?php echo htmlspecialchars($ev_metrekare, ENT_QUOTES); ?> m<sup>2</sup></td>
	</tr>
	<tr>
	<td>Oda Sayısı</td>
	<td><?php echo htmlspecialchars($oda_sayisi, ENT_QUOTES); ?></td>
	</tr>
	<tr>
	<td>Bina Yaşı</td>
	<td><?php echo htmlspecialchars($bina_yasi, ENT_QUOTES); ?></td>
	</tr>
	<tr>
	<td>Kat Sayısı</td>
	<td><?php echo htmlspecialchars($kat_sayisi, ENT_QUOTES); ?></td>
	</tr>
	<tr>
	<td>Isıtma</td>
	<td><?php echo htmlspecialchars($isitma, ENT_QUOTES); ?></td>
	</tr>
	<tr>
	<td>Banyo Sayısı</td>
	<td><?php echo htmlspecialchars($banyo_sayisi, ENT_QUOTES); ?></td>
	</tr>
	<tr>
	<td>Eşyalı mı?</td>
	<td><?php echo htmlspecialchars($esyali, ENT_QUOTES); ?></td>
	</tr>
	<tr>
	<td>Kullanım Durumu</td>
	<td><?php echo htmlspecialchars($kullanim_durumu, ENT_QUOTES); ?></td>
	</tr>
	<tr>
	<td>Site içinde mi?</td>
	<td><?php echo htmlspecialchars($site_icinde, ENT_QUOTES); ?></td>
	</tr>
	<tr>
	<td>Aidat</td>
	<td><?php echo htmlspecialchars($aidat, ENT_QUOTES); ?></td>
	</tr>
	<tr>
	<td>Krediye Uygun mu?</td>
	<td><?php echo htmlspecialchars($ev_krediye_uygun, ENT_QUOTES); ?></td>
	</tr>
	<tr>
	<td>Kimden</td>
	<td>
	<?php
	// kayıt listeleme sorgusu
	$sorgu='SELECT * FROM kullanicilar WHERE id='.$ev_kimden;
	$stmt = $con->prepare($sorgu); // sorguyu hazırla
	$stmt->execute(); // sorguyu çalıştır
	$veri = $stmt->fetchAll(PDO::FETCH_ASSOC); // tablo verilerini oku
	 foreach ($veri as $kayit) {
		echo $kayit["adsoyad"]." (Tel= ".$kayit["tel_no"].")";
	 }?>
	</td>
	</tr>
	<tr>
	<td>Takas</td>
	<td><?php echo htmlspecialchars($ev_takas, ENT_QUOTES); ?></td>
	</tr>
 <?php } else if($evarsa_id == 2){ ?>
	<tr>
	<td>İmar Durumu</td>
	<td><?php echo htmlspecialchars($imar_durumu, ENT_QUOTES); ?></td>
	</tr>
	<tr>
	<td>Metrekare</td>
	<td><?php echo htmlspecialchars($arsa_metrekare, ENT_QUOTES); ?> m<sup>2</sup></td>
	</tr>
	<tr>
	<td>Metrekare Fiyatı</td>
	<td><?php echo htmlspecialchars($metrekare_fiyat, ENT_QUOTES); ?></td>
	</tr>
	<tr>
	<td>Ada No</td>
	<td><?php echo htmlspecialchars($ada_no, ENT_QUOTES); ?></td>
	</tr>
	<tr>
	<td>Parsel No</td>
	<td><?php echo htmlspecialchars($parsel_no, ENT_QUOTES); ?></td>
	</tr>
	<tr>
	<td>Pafta No</td>
	<td><?php echo htmlspecialchars($pafta_no, ENT_QUOTES); ?></td>
	</tr>
	<tr>
	<td>Emsal</td>
	<td><?php echo htmlspecialchars($emsal, ENT_QUOTES); ?></td>
	</tr>
	<tr>
	<td>Tapu Durumu</td>
	<td><?php echo htmlspecialchars($tapu_durumu, ENT_QUOTES); ?></td>
	</tr>
	<tr>
	<td>Kat Karşılığı</td>
	<td><?php echo htmlspecialchars($kat_karsiligi, ENT_QUOTES); ?></td>
	</tr>
	<tr>
	<td>Krediye Uygun mu?</td>
	<td><?php echo htmlspecialchars($arsa_krediye_uygun, ENT_QUOTES); ?></td>
	</tr>
	<tr>
	<td>Kimden</td>
	<td>
	<?php
	// kayıt listeleme sorgusu
	$sorgu='SELECT * FROM kullanicilar WHERE id='.$arsa_kimden;
	$stmt = $con->prepare($sorgu); // sorguyu hazırla
	$stmt->execute(); // sorguyu çalıştır
	$veri = $stmt->fetchAll(PDO::FETCH_ASSOC); // tablo verilerini oku
	 foreach ($veri as $kayit) {
		echo $kayit["adsoyad"]." (Tel= ".$kayit["tel_no"].")";
	 }?>
	</td>
	</tr>
	<tr>
	<td>Takas</td>
	<td><?php echo htmlspecialchars($arsa_takas, ENT_QUOTES); ?></td>
	</tr>
<?php } else{echo "<div class='alert alert-danger'>İlana ait tüm bilgiler bulunamadı. Çünkü Ev veya Arsa olduğu saptanamadı.</div>";} ?>
 <tr>
 <td></td>
 <td>
 <a href='liste.php' class='btn btn-danger'> <span class='glyphicon glyphicon
glyphicon-list'></span> İlan listesi</a>
 </td>
 </tr>
 </table>
 </div> <!-- container -->

 <?php include "../footer.php"; ?>