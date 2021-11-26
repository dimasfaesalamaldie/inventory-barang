<?php
session_start();
include "../../config/koneksi.php";
include "../../config/fungsi_indotgl.php";
include "../../config/fungsi_rupiah.php";

$tanggal = date("Y-m-d");
$tanggal3=tgl_indo($tanggal);
?>
<!DOCTYPE html>
<html lang="en"><head>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Cetak Verifikasi Order</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<meta name="description" content="">
<meta name="author" content="">

<!-- CSS -->
<link href="bootstrap.css" rel="stylesheet">
<style type="text/css" media="print">
body{
	font-size: 12px;
}
@page
{
	size: landscape;
	margin: 2cm;
	font-size: 10px;
}
</style>
</head>

<body onload="print()">
<?php
mysqli_query($konek,"UPDATE verifikasiorder SET cetak = '1'
											WHERE id_verifikasiorder  = '$_GET[id]'");
?>
<!-- Part 1: Wrap all page content here -->
<div id="wrap">

<header class="container jumbotron subhead" id="overview">
  <div class="container">
    <div class="row-fluid">
      <div class="span12">
      <center>
        <h3>Seera Beauty </h3>
    
    </center>
      </div>
    </div>
  </div>
</header>
<!-- Begin page content -->
<div class="container bg">
  <div class="row-fluid">
    <div class="span12">
      <div>
<center><h5>Cetak Verifikasi Order</h5></center>
<?php
$data=mysqli_query($konek,"SELECT * FROM verifikasiorder JOIN user ON verifikasiorder.id_user=user.id_user WHERE verifikasiorder.id_verifikasiorder='$_GET[id]'");
$x=mysqli_fetch_array($data);
$tanggal=tgl_indo($x[tanggal]);
echo"
<table>
<tr><td>ID Verifikasi Order  </td><td>: $x[id_verifikasiorder]</td></tr>
<tr><td>Tanggal  </td><td>: $tanggal</td></tr>
<tr><td>Penanggung Jawab  </td><td>: $x[nama]</td></tr>
</table><br>";
?>
  <table border="1" width="100%">
    <thead>
      <tr>
        <th>No</th>
		<th>ID Barang</th>
		<th>Nama Barang</th>
		<th>Variasi Ukuran</th>
		<th>Biaya Simpan(% dari harga)</th>
		<th>Harga Beli</th>
		<th>Jumlah Order</th>
      </tr>
    </thead>
    <tbody>
    <?php
	$no=1;
	$tampil = mysqli_query($konek,"SELECT * FROM detail_barang JOIN safety_stock ON detail_barang.id_detail_barang=safety_stock.id_detail_barang
																			   JOIN barang ON barang.id_barang=detail_barang.id_barang
																			   JOIN variasi_ukuran ON detail_barang.id_variasi_ukuran=variasi_ukuran.id_variasi_ukuran
																			   JOIN detail_verifikasi ON detail_verifikasi.id_detail_barang=detail_barang.id_detail_barang
																			   JOIN verifikasiorder ON verifikasiorder.id_verifikasiorder=detail_verifikasi.id_verifikasiorder
																			   WHERE verifikasiorder.id_verifikasiorder='$_GET[id]' ORDER BY barang.id_barang ASC");
	while($r=mysqli_fetch_array($tampil)){
	$hargarp=format_rupiah($r[harga_beli]);
	$biaya_simpan=($r[biaya_simpan]/100)*$r[harga_jual];
	$biaya_simpanrp=format_rupiah($biaya_simpan);
	$harga_beli=format_rupiah($r[harga_beli]);
	$harga_jual=format_rupiah($r[harga_jual]);
	$eoq=round($r[eoq]);
     echo "<tr>
	          <td>$no</td>
			  <td>$r[id_barang]</td>
			  <td >$r[nama_barang]</td>
			  <td >$r[nama_variasi_ukuran]</td>							
			  <td >Rp. $biaya_simpanrp ($r[biaya_simpan]% dari Rp. $harga_jual)</td>
			  <td >Rp. $harga_beli</td>
			  <td >$eoq</td>
		  </tr>";
		  $no++;
    }
    ?>
    </tbody>
  </table>
  <div style="clear:both"></div>
  <table width="100%">
  <tbody>
	<tr>
		<td colspan="8" style="height:20px"></td>
	</tr>
	<tr>
		<td width="70%"></td>
		<td align="center">
		Yogyakarta, <?php echo" $tanggal3";?>
		</td>
	</tr>
	<tr>
		<td></td>
		<td align="center">
		Mengetahui
		</td>
	</tr>
	<tr>
		<td></td>
		<td align="center">
		
		</td>
	</tr>
	<tr>
		<td colspan=2 style="height:65px"></td>
	</tr>
	<tr>
		<td></td>
		<th>
		(<?php echo"$x[nama]";?> )
		</th>
	</tr>
	</tbody>
  </table>
      </div>
    </div>
  </div>
  <div id="push"></div>
</div>
</body>
</html>
