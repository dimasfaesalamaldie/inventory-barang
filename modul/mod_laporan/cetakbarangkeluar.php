<?php
session_start();
include "../../config/koneksi.php";
include "../../config/fungsi_indotgl.php";
include "../../config/fungsi_rupiah.php";
$mulai=$_POST[dari];
$selesai=$_POST[sampai];
$tanggal = date("Y-m-d");
$tanggal3=tgl_indo($tanggal);
$dari=tgl_indo($mulai);
$sampai=tgl_indo($selesai);
?>
<!DOCTYPE html>
<html lang="en"><head>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Laporan Barang Keluar</title>
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
<center><h5>Laporan Barang Keluar Dari Tanggal <?php echo"$dari Sampai Tanggal $sampai";?></h5></center>

  <table border="1" width="100%">
    <thead>
      <tr>
        <th>No</th>
		<th>Kode Barang</th>
		<th>Tanggal Keluar</th>
		<th>Nama</th>
		<th>Umur</th>
		<th>Barang</th>
		<th>Qty</th>
		<th>Sub Total</th>
      </tr>
    </thead>
    <tbody>
    <?php
	$no=1;
    // tampilkan rincian produk yang di order
   $tampil = mysqli_query($konek,"SELECT * FROM detail_keluar JOIN detail_barang ON detail_keluar.id_detail_barang=detail_barang.id_detail_barang
															 JOIN barang ON barang.id_barang=detail_barang.id_barang
															 JOIN variasi_ukuran ON detail_barang.id_variasi_ukuran=variasi_ukuran.id_variasi_ukuran
															 JOIN merek ON barang.id_merek=merek.id_merek
															 JOIN barang_keluar ON detail_keluar.id_barang_keluar=barang_keluar.id_barang_keluar
															 WHERE (barang_keluar.tanggal_keluar BETWEEN '$mulai' AND '$selesai')");
	 while($r=mysqli_fetch_array($tampil)){
    $hargarp=format_rupiah($r[harga]);
    $jml=$r[jumlah];
	$harga=$r[harga];
	$subtotal=$jml*$harga;
	$subtotal_rp = format_rupiah($subtotal);
    $total       = $total + $subtotal;
	$total_rp    = format_rupiah($total);
     echo "<tr>
	          <td>$no</td>
			  <td>$r[id_barang]</td>
			  <td>$r[tanggal_keluar]</td>
			  <td>$r[nama_pelanggan]</td>
			  <td>$r[umur] Tahun</td>
			  <td>$r[nama_merek] $r[nama_barang] $r[nama_variasi_ukuran]</td>
			  <td >$r[jumlah]</td>
			  <td >Rp. $subtotal_rp</td>
		  </tr>";
		  $no++;
    }
echo "<tr><td colspan=7 align=right><b>Grand Total</b> : </td><td align=right>Rp. $total_rp</td></tr>
     ";
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
		(<?php echo"$_SESSION[namalengkap]";?> )
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
