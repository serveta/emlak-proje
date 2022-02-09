<?php 
include "header.php";

//veritabanını çağırıyoruz
include '../config/vtabani.php';


//sadece üyeleri sayan sorgu - kullanici onay = 2 olanları sayıyorum
 $uyeKullaniciSay = $con->query('SELECT count(*) FROM kullanicilar WHERE onay="2"')->fetchColumn(); 

//toplam ilan sayısını sorguluyorum ve onay = 1 olanları çağırıyorum
 $onayliIlanSay = $con->query('SELECT count(*) FROM urunler WHERE onay="1"')->fetchColumn(); 
 
//toplam EV ilan sayısını sorguluyorum ve onay = 1 olanları çağırıyorum
 $onayliEvIlanSay = $con->query('SELECT count(*) FROM urunler WHERE onay="1" AND evarsa_id="1" ')->fetchColumn(); 
 
//toplam ARSA ilan sayısını sorguluyorum ve onay = 1 olanları çağırıyorum
 $onayliArsaIlanSay = $con->query('SELECT count(*) FROM urunler WHERE onay="1" AND evarsa_id="2" ')->fetchColumn(); 
 
 //toplam mesaj sayısını sorguluyorum
 $admin_mesaj_Say = $con->query('SELECT count(*) FROM admin_mesajlar')->fetchColumn(); 
 
 ?>

 <div class="container m-t-1em">
 <!-- Sayfa kodları bu alana eklenecek -->
 <!-- Proje hakkında kısa bir bilgi içeren anasayfa -->
 <div class="jumbotron text-justify">
 <div class="page-header"><h2><span class='glyphicon glyphicon glyphicon glyphicon-stats'></span> Emlak Proje - Genel İstatistikler</h2></div>

 <a href="kullanici/liste.php" class="btn btn-primary btn-lg active m-b-1em col-xs col-md m-r-1em pull-left" role="button" aria-pressed="true">
 <span style="font-size:50px;" class='glyphicon glyphicon glyphicon glyphicon-user fa-5x'></span><br/>
 Toplam Üye Sayısı
 <br/><?php echo $uyeKullaniciSay; ?></a>
 
 <a href="mesaj/liste.php" class="btn btn-danger btn-lg active m-b-1em col-xs col-md m-r-1em pull-left" role="button" aria-pressed="true">
 <span style="font-size:50px;" class='glyphicon glyphicon glyphicon glyphicon-comment'></span><br/>
 Toplam Mesaj Sayısı
 <br/><?php echo $admin_mesaj_Say; ?></a>
 
 <a href="ilan/liste.php" class="btn btn-warning btn-lg active m-b-1em col-xs col-md m-r-1em pull-left" role="button" aria-pressed="true">
 <span style="font-size:50px;" class='glyphicon glyphicon glyphicon glyphicon-list'></span><br/>
 Toplam İlan Sayısı
 <br/><?php echo $onayliIlanSay; ?></a>
 
 <a href="ilan/liste.php?aranan=ev" class="btn btn-success btn-lg active m-b-1em col-xs col-md m-r-1em pull-left" role="button" aria-pressed="true">
 <span style="font-size:50px;" class='glyphicon glyphicon glyphicon glyphicon-home'></span><br/>
 Toplam Ev İlanı
 <br/><?php echo $onayliEvIlanSay; ?></a>
 
 <a href="ilan/liste.php?aranan=arsa" class="btn btn-info btn-lg active" role="button" aria-pressed="true">
 <span style="font-size:50px;" class='glyphicon glyphicon glyphicon glyphicon-road'></span><br/>
 Toplam Arsa İlanı
 <br/><?php echo $onayliArsaIlanSay; ?></a>

 </div>
 
 <div class="jumbotron text-justify">
 <div class="page-header"><h2><span class='glyphicon glyphicon glyphicon glyphicon-wrench'></span> Emlak Proje - Site Ayarları</h2></div>

 <a href="site_ayar/logo_liste.php" class="btn btn-primary btn-lg active m-b-1em col-xs col-md m-r-1em pull-left" role="button" aria-pressed="true">
 <span style="font-size:50px;" class='glyphicon glyphicon glyphicon glyphicon-cloud-upload'></span><br/>
 Logoyu Değiştir
 <br/></a>
 
 <a href="site_ayar/slider_liste.php" class="btn btn-info btn-lg active m-b-1em col-xs col-md m-r-1em pull-left" role="button" aria-pressed="true">
 <span style="font-size:50px;" class='glyphicon glyphicon glyphicon glyphicon-text-width'></span><br/>
 Sliderları Değiştir
 <br/></a>
 
  <a href="kategori/liste.php" class="btn btn-success btn-lg active" role="button" aria-pressed="true">
 <span style="font-size:50px;" class='glyphicon glyphicon glyphicon glyphicon-folder-open'></span><br/>
 Kategori İşlemleri
 <br/></a>
</div>
 </div>
 </div> <!-- /container -->
<?php include "footer.php"; ?>