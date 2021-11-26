<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
include "../../config/koneksi.php";

$module=$_GET[module];
$act=$_GET[act];
// Proses Verifikasi
if ($module=='stok' AND $act=='verifikasi'){
$jumls = mysqli_num_rows(mysqli_query($konek,"SELECT * FROM barang JOIN safety_stock ON barang.id_barang=safety_stock.id_barang WHERE safety_stock.status='Unsafe' ORDER BY barang.id_barang ASC"));
for ($ia=1; $ia<=$jumls; $ia++){
          $a  = $_POST['a'.$ia];
		  $b  = $_POST['b'.$ia];
          $parameter = $_POST['id_barang'.$ia];
mysqli_query($konek,"UPDATE barang SET biaya_simpan = '$a',
									   harga_beli   = '$b',
									   biaya_pesan  = '$_POST[biaya_pemesanan]'
                           WHERE  id_barang  = '$parameter'");
	}
	$tampil = mysqli_query($konek,"SELECT * FROM barang JOIN detail_masuk ON barang.id_barang=detail_masuk.id_barang GROUP BY barang.id_barang ORDER BY barang.id_barang ASC");
						$no=1;
						while ($r=mysqli_fetch_array($tampil)){
						$barang=$r[id_barang];
						$stok=$r[stok];
						$simpan=$r[biaya_simpan];
						$biaya_simpan=($r[biaya_simpan]/100)*$r[harga_jual];
						$periode = 12;
 
 
	$biaya_pesan=$r[biaya_pesan];
	$hari=$periode*30;
	$caritotal=mysqli_query($konek,"SELECT SUM(detail_keluar.jumlah) AS total_jual FROM barang_keluar,detail_keluar WHERE barang_keluar.id_barang_keluar=detail_keluar.id_barang_keluar AND detail_keluar.id_barang='$barang'");
    $ct=mysqli_fetch_array($caritotal);
	$total_jual=$ct[total_jual];
	$rata_jual=($total_jual/$periode);
	$eoq=sqrt((2*$biaya_pesan*$total_jual)/$biaya_simpan);
	mysqli_query($konek,"UPDATE safety_stock SET eoq = '$eoq'
                           WHERE  id_barang  = '$barang'");					
	}
header('location:../../modul/mod_laporan/cetakverifikasi.php');
}
}
?>
