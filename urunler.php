<?php include "header.php"; ?>
<!-- Banner satırı kodları burada yer alacak -->
<!--
<div class="row">
 <div class="col-md text-center">
 <img style="width:70%;" src="content/images/banner.jpg">
 <div class="carousel-caption">
 <span class="fa-stack fa-3x">
 <i class="fa fa-circle-thin fa-stack-2x"></i>
 <i class="fa fa-search fa-stack-1x"></i>
 </span>
 <h1 class="baslik"><b>İlanlar</b></h1>
 </div>
 </div>
</div>
-->
 <div class="container mt-4">
 <div class="row">
 <div class="col-md-3">
 <!-- Kategori liste kodları burada yer alacak -->
 <div><!--kategoriler-->
 <h4 class="baslik">Kategoriler</h4>
 <ul class="list-group list-group-flush">
 <?php
 
 
 // SAYFALANDIRMA DEĞİŞKENLERİ
 // sayfa parametresi aktif sayfa numarasını gösterir, parametre boşsa değeri 1'dir
 $sayfa = isset($_GET['sayfa']) ? $_GET['sayfa'] : 1;

 // bir sayfada görüntülenecek kayıt sayısı
 $sayfa_kayit_sayisi = 5;

 // sorgudaki LIMIT başlangıç değerini hesapla
 $ilk_kayit_no = ($sayfa_kayit_sayisi * $sayfa) - $sayfa_kayit_sayisi;
 
 // gelen parametreleri değişkenlere kaydet
 $aranan=isset($_GET["aranan"]) ? $_GET["aranan"]:"";
 $arama_sarti = isset($_GET['aranan']) ? "%".$_GET['aranan']."%" : "%";
 $kategori=isset($_GET["id"]) ? $_GET["id"]:"";
 $siralama=isset($_GET["siralama"]) ? $_GET["siralama"]:"akilli";
 $fiyat=isset($_GET["fiyat"]) ? $_GET["fiyat"]:"0";
 $evarsa_id=isset($_GET["evarsa_id"]) ? $_GET["evarsa_id"]:"3";
 // kategori haricindeki seçenekleri de linke dahil etmek için
 $parametre="&aranan=$aranan&siralama=$siralama&fiyat=$fiyat&evarsa_id=$evarsa_id&sayfa=1";
 // veritabanı yapılandırma dosyasını dahil et
 include 'config/vtabani.php';
 // kayıt listeleme sorgusu
 $sorgu='SELECT kategoriler.*, COUNT(urunler.id) AS adet FROM kategoriler LEFT JOIN urunler ON kategoriler.id=urunler.kategori_id WHERE urunler.onay="1" GROUP BY kategoriler.id ORDER BY kategoriler.kategoriadi';
 $stmt = $con->prepare($sorgu); // sorguyu hazırla
 $stmt->execute(); // sorguyu çalıştır
 $veri = $stmt->fetchAll(PDO::FETCH_ASSOC); // tablo verilerini oku
 $toplam=0;
 foreach ($veri as $kayit) { ?>
 <a href="urunler.php?id=<?php echo $kayit["id"];echo $parametre ?>" class="list-group-item d-flex justify-content-between align-items-center list-group-item-action<?php echo $kategori==$kayit["id"] ? "active":""; ?>" > <?php echo $kayit["kategoriadi"]; ?>
 <span class="badge badge-success badge-pill"><?php echo $kayit["adet"] ?></span>
 </a>
 <?php $toplam+=$kayit["adet"]; } ?>
 <a href="urunler.php?id=<?php echo $parametre ?>" class="list-group-item d-flex justify-content-between align-items-center list-group-item-action<?php echo $kategori=="" ? "active":""; ?>">Hepsi
 <span class="badge badge-success badge-pill"><?php echo $toplam ?></span>
 </a>
 </ul>
</div><!--/kategoriler-->

 <!-- Ev veya Arsa Listeleme -->
 <div class="pt-4">
 <h4 class="baslik">Ev mi Arsa mı?</h4>
 <div class="list-group list-group-flush">
 <!-- evarsa_id haricindeki seçenekleri de linke dahil etmek için -->
 <?php $parametre="&aranan=$aranan&id=$kategori&siralama=$siralama&fiyat=$fiyat&sayfa=1"; ?>
 <a href="urunler.php?evarsa_id=1<?php echo $parametre ?>" class="list-group-item
list-group-item-action<?php echo $evarsa_id=="1" ? "active":""; ?>">Sadece Ev İlanları</a>
 <a href="urunler.php?evarsa_id=2<?php echo $parametre ?>" class="list-group-item
list-group-item-action<?php echo $evarsa_id=="2" ? "active":""; ?>">Sadece Arsa İlanları</a>
<a href="urunler.php?evarsa_id=3<?php echo $parametre ?>" class="list-group-item
list-group-item-action<?php echo $evarsa_id=="3" ? "active":""; ?>">Hepsi</a>
 </div>
 </div>
<!-- / Ev veya Arsa Listeleme -->
 
 <!-- Sıralama seçenekleri burada yer alacak -->
 <div class="pt-4"><!--sıralama-->
 <h4 class="baslik">Sıralama</h4>
 <div class="list-group list-group-flush">
 <!-- sıralama haricindeki seçenekleri de linke dahil etmek için -->
 <?php $parametre="&aranan=$aranan&id=$kategori&fiyat=$fiyat&evarsa_id=$evarsa_id&sayfa=1"; ?>

 <a href="urunler.php?siralama=akilli<?php echo $parametre ?>" class="list-group-item list-group-item-action<?php echo $siralama=="akilli" ? "active":"";
?>">Akıllı sıralama</a>
 <a href="urunler.php?siralama=yeni<?php echo $parametre ?>" class="list-group-item list-group-item-action<?php echo $siralama=="yeni" ? "active":""; ?>">Yeni
ilanlar</a>
<a href="urunler.php?siralama=artan<?php echo $parametre ?>" class="list-group-item list-group-item-action<?php echo $siralama=="artan" ? "active":"";
?>">Artan fiyat</a>
 <a href="urunler.php?siralama=azalan<?php echo $parametre ?>" class="list-group-item list-group-item-action<?php echo $siralama=="azalan" ? "active":"";
?>">Azalan fiyat</a>
 </div>
</div><!--/sıralama-->
 
 <!-- Fiyat seçenekleri burada yer alacak -->
 <div class="pt-4"><!--fiyat-->
 <h4 class="baslik">Fiyat Aralığı</h4>
 <div class="list-group list-group-flush">
 <!-- fiyat haricindeki seçenekleri de linke dahil etmek için -->
 <?php $parametre="&aranan=$aranan&id=$kategori&siralama=$siralama&evarsa_id=$evarsa_id&sayfa=1"; ?>
 <a href="urunler.php?fiyat=0<?php echo $parametre ?>" class="list-group-item
list-group-item-action<?php echo $fiyat=="0" ? "active":""; ?>">Yok</a>
 <a href="urunler.php?fiyat=1<?php echo $parametre ?>" class="list-group-item
list-group-item-action<?php echo $fiyat=="1" ? "active":""; ?>">0 - 2.500 &#8378;</a>
 <a href="urunler.php?fiyat=2<?php echo $parametre ?>" class="list-group-item
list-group-item-action<?php echo $fiyat=="2" ? "active":""; ?>">2.500 - 5.000
&#8378;</a>
 <a href="urunler.php?fiyat=3<?php echo $parametre ?>" class="list-group-item
list-group-item-action<?php echo $fiyat=="3" ? "active":""; ?>">5.000 - 10.000
&#8378;</a>
 <a href="urunler.php?fiyat=4<?php echo $parametre ?>" class="list-group-item
list-group-item-action<?php echo $fiyat=="4" ? "active":""; ?>">10.000 - 25.000
&#8378;</a>
 <a href="urunler.php?fiyat=5<?php echo $parametre ?>" class="list-group-item
list-group-item-action<?php echo $fiyat=="5" ? "active":""; ?>">25.000 - 50.000
&#8378;</a>
 <a href="urunler.php?fiyat=6<?php echo $parametre ?>" class="list-group-item
list-group-item-action<?php echo $fiyat=="6" ? "active":""; ?>">50.000 - 100.000
&#8378;</a>
<a href="urunler.php?fiyat=7<?php echo $parametre ?>" class="list-group-item
list-group-item-action<?php echo $fiyat=="7" ? "active":""; ?>">100.000 - 200.000
&#8378;</a>
<a href="urunler.php?fiyat=8<?php echo $parametre ?>" class="list-group-item
list-group-item-action<?php echo $fiyat=="8" ? "active":""; ?>">200.000
&#8378; ve üzeri</a>
 </div>
 </div><!--/fiyat-->

 
 </div>
 
 <div class="col-md-9">
 <!-- İlanları listeleme kodları burada yer alacak -->
 <div class="row">
 <?php
 // select sorgusu için sıralama seçenekleri hazırlanıyor
 switch($siralama){
 case 'yeni': $orderby="giris_tarihi desc";break;
 case 'artan': $orderby="fiyat";break;
 case 'azalan':$orderby="fiyat desc";break;
 default: $orderby="dzltm_tarihi desc";
 }
 // select sorgusu için fiyat aralığı hazırlanıyor
 switch($fiyat){
 case '1': $where1="fiyat between 0 and 2500";break;
 case '2': $where1="fiyat between 2500 and 5000";break;
 case '3': $where1="fiyat between 5000 and 10000";break;
 case '4': $where1="fiyat between 10000 and 25000";break;
 case '5': $where1="fiyat between 25000 and 50000";break;
 case '6': $where1="fiyat between 50000 and 100000";break;
 case '7': $where1="fiyat between 100000 and 200000";break;
 case '8': $where1="fiyat between 200000 and 100000000";break;
 }
 // select sorgusu için evarsa_id aralığı hazırlanıyor
 switch($evarsa_id){
 case '1': $where_evarsa_id="evarsa_id='1'";break;
 case '2': $where_evarsa_id="evarsa_id='2'";break;
 case '3': $where_evarsa_id="evarsa_id='1' or evarsa_id='2'";break;
 }
 // select sorgusu için kategori şartı hazırlanıyor
 if($kategori!="") $where2="kategori_id=$kategori";
 // select sorgusu için arama şartı hazırlanıyor
 if($aranan!="") $where3="urunadi like '%$aranan%'"; else $where3="urunadi like '%'";
 // select sorgusu için şartlar birleştiriliyor
 if(isset($where1) && isset($where2) && isset($where_evarsa_id)) {$where="(".$where1.") and (".$where2.") and (".$where3.") and (".$where_evarsa_id.")";}
 elseif(isset($where2) && isset($where_evarsa_id)) {$where="(".$where_evarsa_id.") and (".$where2.") and (".$where3.")";}
 elseif(isset($where1) && isset($where_evarsa_id)) {$where="(".$where1.") and (".$where3.") and (".$where_evarsa_id.")";}
 elseif(isset($where1)) {$where="(".$where1.") and (".$where3.")";}
 elseif(isset($where2)) {$where="(".$where2.") and (".$where3.")";}
 elseif(isset($where_evarsa_id)) {$where="(".$where_evarsa_id.") and (".$where3.")";}
 else {$where=$where3;}
 // veritabanı yapılandırma dosyasını dahil et
 include 'config/vtabani.php';
 // kayıt listeleme sorgusu
 $sorgu="SELECT urunler.*, il.sehir, ilce.ilce, evarsa.ilanTuru, kategoriler.kategoriadi
 FROM urunler
 LEFT JOIN il ON urunler.il_id=il.id
 LEFT JOIN ilce ON urunler.ilce_id=ilce.id
 LEFT JOIN evarsa ON urunler.evarsa_id=evarsa.id
 LEFT JOIN kategoriler ON urunler.kategori_id=kategoriler.id
 WHERE urunler.onay='1' AND $where ORDER BY $orderby LIMIT :ilk_kayit_no, :sayfa_kayit_sayisi";
 $stmt = $con->prepare($sorgu); // sorguyu hazırla
 $stmt->bindParam(":ilk_kayit_no", $ilk_kayit_no, PDO::PARAM_INT);
 $stmt->bindParam(":sayfa_kayit_sayisi", $sayfa_kayit_sayisi, PDO::PARAM_INT);
 $stmt->execute(); // sorguyu çalıştır
 $veri = $stmt->fetchAll(PDO::FETCH_ASSOC); // tablo verilerini oku
 
  // geriye dönen kayıt sayısı
 $sayi = $stmt->rowCount();
  //kayıt varsa listele
 if($sayi>0){
	
	 $sorguKategori="SELECT * FROM kategoriler";
	 $stmtKategori = $con->prepare($sorguKategori);
	 $stmtKategori->execute();
	 $veriKategori = $stmtKategori->fetchAll(PDO::FETCH_ASSOC);
	 
	 $sorguEvArsa="SELECT * FROM evarsa";
	 $stmtEvArsa = $con->prepare($sorguEvArsa);
	 $stmtEvArsa->execute();
	 $veriEvArsa = $stmtEvArsa->fetchAll(PDO::FETCH_ASSOC);
	 
	 $url = 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
	 
	 foreach ($veriKategori as $kayitKategori) {
		 if(strstr($url,"id=".$kayitKategori['id'])){	
		$urlDuzen=str_replace("id=".$kayitKategori['id'], "id=", $url);		
	
		echo "<a style='text-decoration:none;color:#212529;' class='btn btn-danger text-white pull-left m-3'>
			<form action='".$urlDuzen."' method='POST'>
				Kategori Filtresi: <b>".$kayitKategori['kategoriadi']."</b>&nbsp;
				<button style='margin-top:-2px;' type='submit' class='close text-white' aria-label='Close'>
				<span aria-hidden='true'>&times;</span>
				</button>
			</form>
			</a>";
		 }
	 }
	 foreach ($veriEvArsa as $kayitEvArsaID) {
		 if(strstr($url,"evarsa_id=".$kayitEvArsaID['id'])){
			$urlDuzen=str_replace("evarsa_id=".$kayitEvArsaID['id'], "evarsa_id=3", $url);		
	
		echo "<a style='text-decoration:none;color:#212529;' class='btn btn-danger text-white pull-left m-3'>
			<form action='".$urlDuzen."' method='POST'>
				Ev - Arsa Filtresi: <b>".$kayitEvArsaID['ilanTuru']."</b>&nbsp;
				<button style='margin-top:-2px;' type='submit' class='close text-white' aria-label='Close'>
				<span aria-hidden='true'>&times;</span>
				</button>
			</form>
			</a>";
		 }
	 }
	 if(strstr($url,"siralama=yeni")){
		$urlDuzen=str_replace("siralama=yeni", "siralama=akilli", $url);		
	
		echo "<a style='text-decoration:none;color:#212529;' class='btn btn-danger text-white pull-left m-3'>
			<form action='".$urlDuzen."' method='POST'>
				Sıralama Filtresi: <b>Yeniden eskiye</b>&nbsp;
				<button style='margin-top:-2px;' type='submit' class='close text-white' aria-label='Close'>
				<span aria-hidden='true'>&times;</span>
				</button>
			</form>
			</a>";
	 }
	 if(strstr($url,"siralama=artan")){
		$urlDuzen=str_replace("siralama=artan", "siralama=akilli", $url);		
	
		echo "<a style='text-decoration:none;color:#212529;' class='btn btn-danger text-white pull-left m-3'>
			<form action='".$urlDuzen."' method='POST'>
				Sıralama Filtresi: <b>Artan fiyat</b>&nbsp;
				<button style='margin-top:-2px;' type='submit' class='close text-white' aria-label='Close'>
				<span aria-hidden='true'>&times;</span>
				</button>
			</form>
			</a>";
	 }
	 if(strstr($url,"siralama=azalan")){
		$urlDuzen=str_replace("siralama=azalan", "siralama=akilli", $url);		
	
		echo "<a style='text-decoration:none;color:#212529;' class='btn btn-danger text-white pull-left m-3'>
			<form action='".$urlDuzen."' method='POST'>
				Sıralama Filtresi: <b>Azalan fiyat</b>&nbsp;
				<button style='margin-top:-2px;' type='submit' class='close text-white' aria-label='Close'>
				<span aria-hidden='true'>&times;</span>
				</button>
			</form>
			</a>";
	 }
	 if(strstr($url,"fiyat=1") || strstr($url,"fiyat=2") || strstr($url,"fiyat=3") || strstr($url,"fiyat=4") || strstr($url,"fiyat=5") || strstr($url,"fiyat=6") || strstr($url,"fiyat=7") || strstr($url,"fiyat=8")){
		if(strstr($url,"fiyat=1")){
			$urlDuzen=str_replace("fiyat=1", "fiyat=0", $url);		
		}
		if(strstr($url,"fiyat=2")){
			$urlDuzen=str_replace("fiyat=2", "fiyat=0", $url);		
		}
		if(strstr($url,"fiyat=3")){
			$urlDuzen=str_replace("fiyat=3", "fiyat=0", $url);		
		}
		if(strstr($url,"fiyat=4")){
			$urlDuzen=str_replace("fiyat=4", "fiyat=0", $url);		
		}
		if(strstr($url,"fiyat=5")){
			$urlDuzen=str_replace("fiyat=5", "fiyat=0", $url);		
		}
		if(strstr($url,"fiyat=6")){
			$urlDuzen=str_replace("fiyat=6", "fiyat=0", $url);		
		}
		if(strstr($url,"fiyat=7")){
			$urlDuzen=str_replace("fiyat=7", "fiyat=0", $url);		
		}
		if(strstr($url,"fiyat=8")){
			$urlDuzen=str_replace("fiyat=8", "fiyat=0", $url);		
		}
		echo "<a style='text-decoration:none;color:#212529;' class='btn btn-danger text-white pull-left m-3'>
			<form action='".$urlDuzen."' method='POST'>
				Fiyat Filtresi: <b>";
				if(strstr($url,"fiyat=1")){
					echo "0 - 2.500 &#8378";		
				}
				if(strstr($url,"fiyat=2")){
					echo "2.500 - 5.000 &#8378";		
				}
				if(strstr($url,"fiyat=3")){
					echo "5.000 - 10.000 &#8378";	
				}
				if(strstr($url,"fiyat=4")){
					echo "10.000 - 25.000 &#8378";		
				}
				if(strstr($url,"fiyat=5")){
					echo "25.000 - 50.000 &#8378";	
				}
				if(strstr($url,"fiyat=6")){
					echo "50.000 - 100.000 &#8378";	
				}
				if(strstr($url,"fiyat=7")){
					echo "100.000 - 200.000 &#8378";		
				}
				if(strstr($url,"fiyat=8")){
					echo "200.000 &#8378 ve üzeri";		
				}
				echo "</b>&nbsp;
				<button style='margin-top:-2px;' type='submit' class='close text-white' aria-label='Close'>
				<span aria-hidden='true'>&times;</span>
				</button>
			</form>
			</a>";
	 }
 foreach ($veri as $kayit) { ?>
 <!--<div class="col-md-6 mb-4">
 <div class="card">
 <a href="urundetay.php?id=<?php // echo $kayit['id']?>">
 <?php // echo $kayit['resim'] ? "<img src='content/images/".$kayit['resim']."' alt='".$kayit['urunadi']."' style='width:100%;height:330px' class='card-img-top' />":"<img src='content/images/gorsel-yok.jpg' style='width:100%;height:330px' class='card-img-top' />"; ?>
 </a>
 <div class="card-body">
 <h4 class="card-title"><?php // echo mb_substr($kayit['urunadi'],'0','17','UTF-8')."..."?></h4>
 <p class="card-text"><?php // echo $kayit['sehir']."/".$kayit['ilce']?></p>
 <p class="card-text"><?php // echo "<b>İlan Türü:</b> ".$kayit['kategoriadi']." ".$kayit['ilanTuru']?></p>
 </div>
 <div class="card-footer text-muted">
 <a href="#" class="text-secondary float-left favori-ekle" id="<?php // echo $kayit['id']?>"><i class="fa fa-heart fa-2x"></i>Favorile</a>
 <span class="badge badge-success p-2 float-right"><?php // echo number_format($kayit['fiyat'], 0, ',', '.')?>&#8378;</span>
 </div>
 </div>
 </div>-->
 
 
<div class="card mb-3" style="max-width: 940px;">
  <div class="row no-gutters">
    <div class="col-md-4">
		<a href="urundetay.php?id=<?php echo $kayit['id']?>">
			<?php echo $kayit['resim'] ? "<img src='content/images/".$kayit['resim']."' alt='".$kayit['urunadi']."' style='max-height:100%;max-width:95%;' class='card-img-top' />":"<img src='content/images/gorsel-yok.jpg' style='max-height:100%;max-width:95%;' class='card-img-top' />"; ?>
		</a>
    </div>
    <div class="col-md-8">
      <div class="card-body">
        <a href="urundetay.php?id=<?php echo $kayit['id']?>" style="color:green;"><h5 class="card-title"><?php echo /*mb_substr(*/$kayit['urunadi']/*,'0','50','UTF-8')."..."*/?></h5></a>
        <p class="card-text"><?php echo $kayit['sehir']."/".$kayit['ilce']?></p>
		<p class="card-text"><?php echo "<b>İlan Türü:</b> ".$kayit['kategoriadi']." ".$kayit['ilanTuru']?></p>
        <!--<p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>-->
      </div>
    </div>
  </div>
  <div class="card-footer text-muted" style="max-width: 940px;">
		<a style="text-decoration:none; color:#212529;" class='btn btn-info text-white pull-left mr-3' href="urundetay.php?id=<?php echo $kayit['id']?>">
		İlanı Gör
		</a>
		
		<a title="Favorile" href="#" style="text-decoration:none;font-size:18px;" class="text-secondary favori-ekle pull-left" id="<?php echo $kayit['id']?>">
		<span class="fa-stack fa-1x">
		<i class="fa fa-circle-thin fa-stack-2x"></i>
		<i class="fa fa-heart fa-stack-1x"></i>
		</span></a>
		<span style="font-size:18px;" class="badge badge-success p-2 pull-right"><?php echo number_format($kayit['fiyat'], 0, ',', '.')?> &#8378;</span>
	</div>
</div>
 
 

 <?php } ?>
</div>
<div class="row">
  <hr/>
 <?php
 // SAYFALANDIRMA
 // toplam kayıt sayısını hesapla
$sorgu = "SELECT COUNT(*) as kayit_sayisi FROM urunler WHERE onay='1' AND $where";
$stmt = $con->prepare($sorgu);
//$stmt->bindParam(":aranan", $where3);

 // sorguyu çalıştır
 $stmt->execute();

 // kayıt sayısını oku
 $kayit = $stmt->fetch(PDO::FETCH_ASSOC);
 //echo $kayit['kayit_sayisi'];
 $kayit_sayisi = $kayit['kayit_sayisi'];
 // kayıtları sayfalandır
 $sayfa_url="urunler.php";
 include_once "sayfalama.php";
 }
 // kayıt yoksa mesajla bildir
 else{
	 
	 $sorguKategori="SELECT * FROM kategoriler";
	 $stmtKategori = $con->prepare($sorguKategori);
	 $stmtKategori->execute();
	 $veriKategori = $stmtKategori->fetchAll(PDO::FETCH_ASSOC);
	 
	 $sorguEvArsa="SELECT * FROM evarsa";
	 $stmtEvArsa = $con->prepare($sorguEvArsa);
	 $stmtEvArsa->execute();
	 $veriEvArsa = $stmtEvArsa->fetchAll(PDO::FETCH_ASSOC);
	 
	 $url = 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
	 
	 foreach ($veriKategori as $kayitKategori) {
		 if(strstr($url,"id=".$kayitKategori['id'])){	
		$urlDuzen=str_replace("id=".$kayitKategori['id'], "id=", $url);		
	
		echo "<a style='text-decoration:none;color:#212529;' class='btn btn-danger text-white pull-left m-3'>
			<form action='".$urlDuzen."' method='POST'>
				Kategori Filtresi: <b>".$kayitKategori['kategoriadi']."</b>&nbsp;
				<button style='margin-top:-2px;' type='submit' class='close text-white' aria-label='Close'>
				<span aria-hidden='true'>&times;</span>
				</button>
			</form>
			</a>";
		 }
	 }
	 foreach ($veriEvArsa as $kayitEvArsaID) {
		 if(strstr($url,"evarsa_id=".$kayitEvArsaID['id'])){
			$urlDuzen=str_replace("evarsa_id=".$kayitEvArsaID['id'], "evarsa_id=3", $url);		
	
		echo "<a style='text-decoration:none;color:#212529;' class='btn btn-danger text-white pull-left m-3'>
			<form action='".$urlDuzen."' method='POST'>
				Ev - Arsa Filtresi: <b>".$kayitEvArsaID['ilanTuru']."</b>&nbsp;
				<button style='margin-top:-2px;' type='submit' class='close text-white' aria-label='Close'>
				<span aria-hidden='true'>&times;</span>
				</button>
			</form>
			</a>";
		 }
	 }
	 if(strstr($url,"siralama=yeni")){
		$urlDuzen=str_replace("siralama=yeni", "siralama=akilli", $url);		
	
		echo "<a style='text-decoration:none;color:#212529;' class='btn btn-danger text-white pull-left m-3'>
			<form action='".$urlDuzen."' method='POST'>
				Sıralama Filtresi: <b>Yeniden eskiye</b>&nbsp;
				<button style='margin-top:-2px;' type='submit' class='close text-white' aria-label='Close'>
				<span aria-hidden='true'>&times;</span>
				</button>
			</form>
			</a>";
	 }
	 if(strstr($url,"siralama=artan")){
		$urlDuzen=str_replace("siralama=artan", "siralama=akilli", $url);		
	
		echo "<a style='text-decoration:none;color:#212529;' class='btn btn-danger text-white pull-left m-3'>
			<form action='".$urlDuzen."' method='POST'>
				Sıralama Filtresi: <b>Artan fiyat</b>&nbsp;
				<button style='margin-top:-2px;' type='submit' class='close text-white' aria-label='Close'>
				<span aria-hidden='true'>&times;</span>
				</button>
			</form>
			</a>";
	 }
	 if(strstr($url,"siralama=azalan")){
		$urlDuzen=str_replace("siralama=azalan", "siralama=akilli", $url);		
	
		echo "<a style='text-decoration:none;color:#212529;' class='btn btn-danger text-white pull-left m-3'>
			<form action='".$urlDuzen."' method='POST'>
				Sıralama Filtresi: <b>Azalan fiyat</b>&nbsp;
				<button style='margin-top:-2px;' type='submit' class='close text-white' aria-label='Close'>
				<span aria-hidden='true'>&times;</span>
				</button>
			</form>
			</a>";
	 }
	 if(strstr($url,"fiyat=1") || strstr($url,"fiyat=2") || strstr($url,"fiyat=3") || strstr($url,"fiyat=4") || strstr($url,"fiyat=5") || strstr($url,"fiyat=6") || strstr($url,"fiyat=7") || strstr($url,"fiyat=8")){
		if(strstr($url,"fiyat=1")){
			$urlDuzen=str_replace("fiyat=1", "fiyat=0", $url);		
		}
		if(strstr($url,"fiyat=2")){
			$urlDuzen=str_replace("fiyat=2", "fiyat=0", $url);		
		}
		if(strstr($url,"fiyat=3")){
			$urlDuzen=str_replace("fiyat=3", "fiyat=0", $url);		
		}
		if(strstr($url,"fiyat=4")){
			$urlDuzen=str_replace("fiyat=4", "fiyat=0", $url);		
		}
		if(strstr($url,"fiyat=5")){
			$urlDuzen=str_replace("fiyat=5", "fiyat=0", $url);		
		}
		if(strstr($url,"fiyat=6")){
			$urlDuzen=str_replace("fiyat=6", "fiyat=0", $url);		
		}
		if(strstr($url,"fiyat=7")){
			$urlDuzen=str_replace("fiyat=7", "fiyat=0", $url);		
		}
		if(strstr($url,"fiyat=8")){
			$urlDuzen=str_replace("fiyat=8", "fiyat=0", $url);		
		}
		echo "<a style='text-decoration:none;color:#212529;' class='btn btn-danger text-white pull-left m-3'>
			<form action='".$urlDuzen."' method='POST'>
				Fiyat Filtresi: <b>";
				if(strstr($url,"fiyat=1")){
					echo "0 - 2.500 &#8378";		
				}
				if(strstr($url,"fiyat=2")){
					echo "2.500 - 5.000 &#8378";		
				}
				if(strstr($url,"fiyat=3")){
					echo "5.000 - 10.000 &#8378";	
				}
				if(strstr($url,"fiyat=4")){
					echo "10.000 - 25.000 &#8378";		
				}
				if(strstr($url,"fiyat=5")){
					echo "25.000 - 50.000 &#8378";	
				}
				if(strstr($url,"fiyat=6")){
					echo "50.000 - 100.000 &#8378";	
				}
				if(strstr($url,"fiyat=7")){
					echo "100.000 - 200.000 &#8378";		
				}
				if(strstr($url,"fiyat=8")){
					echo "200.000 &#8378 ve üzeri";		
				}
				echo "</b>&nbsp;
				<button style='margin-top:-2px;' type='submit' class='close text-white' aria-label='Close'>
				<span aria-hidden='true'>&times;</span>
				</button>
			</form>
			</a>";
		
	 }
	 
 echo "<div class='alert alert-danger'>İstediğiniz kriterlere sahip ilan bulunamadı.</div>";
 }
 ?>
 </div>
 </div> 
 </div>
 </div>
 <!--
  <div class="container">
 <div class="row">
 <div class="col-md-3">
  </div>
 <div class="col-md-9">

 </div>
 </div>
 </div>-->
<?php include "footer.php"; ?>