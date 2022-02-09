
<link href="content/css/sayfalama-ilan.css" type="text/css" rel="stylesheet"/>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

<?php
 echo "<div class='sayfala pull-left'><ul class='pull-left margin-zero mt-0'>";

 // önceki sayfa butonu burada yer alacak
  // önceki sayfa butonu
 if($sayfa>1){

 $onceki_sayfa = $sayfa - 1;
 echo "<li>";
 echo "<a href='{$sayfa_url}?sayfa={$onceki_sayfa}&aranan={$aranan}&id={$kategori}&siralama={$siralama}&evarsa_id={$evarsa_id}&fiyat={$fiyat}'>";
 echo "<span style='margin:0 .5em;'>&laquo;</span>";
 echo "</a>";
 echo "</li>";
 }

 // tıklanabilir sayfa numaraları burada yer alacak
 // tıklanabilir sayfa numaraları
 // sayfa sayısını hesapla
 $sayfa_sayisi = ceil($kayit_sayisi / $sayfa_kayit_sayisi);

 // aktif sayfanın öncesinde ve sonrasında gösterilecek sayfa numarası aralığı
 $aralik = 2;

 // aktif sayfanın önce ve sonrasındaki sayfa numaralarını görüntüle
 $baslangic_no = $sayfa - $aralik;
 $bitis_no = ($sayfa + $aralik) + 1;

 for ($x=$baslangic_no; $x<$bitis_no; $x++) {
	 // $x değerinin 0'dan büyük VE $sayfa_sayisi'na eşit veya küçük olduğundan emin ol
 if (($x > 0) && ($x <= $sayfa_sayisi)) {

 // aktif sayfa
 if ($x == $sayfa) {
 echo "<li class='active'>";
 echo "<a href='javascript::void();'>{$x}</a>";
 echo "</li>";
 }
 // aktif olmayan sayfa
 else {
 echo "<li>";
 echo " <a href='{$sayfa_url}?sayfa={$x}&aranan={$aranan}&id={$kategori}&siralama={$siralama}&evarsa_id={$evarsa_id}&fiyat={$fiyat}'>{$x}</a> ";
 echo "</li>";
 }
 }
 }

 // sonraki sayfa butonu burada yer alacak
 // sonraki sayfa butonu
 if($sayfa<$sayfa_sayisi){
 $sonraki_sayfa = $sayfa + 1;

 echo "<li>";
 echo "<a href='{$sayfa_url}?sayfa={$sonraki_sayfa}&aranan={$aranan}&id={$kategori}&siralama={$siralama}&evarsa_id={$evarsa_id}&fiyat={$fiyat}'>";
 echo "<span style='margin:0 .5em;'>&raquo;</span>";
 echo "</a>";
 echo "</li>";
 }

 echo "</ul></div>";
?>
