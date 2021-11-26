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
// Hapus masuk
if ($module=='masuk' AND $act=='hapus'){
  mysqli_query($konek,"DELETE FROM barang_masuk WHERE id_barang_masuk='$_GET[id]'");
  mysqli_query($konek,"DELETE FROM detail_masuk WHERE id_barang_masuk='$_GET[id]'");
  header('location:../../media.php?module='.$module);
}
// Tambah masuk
elseif ($module=='masuk' AND $act=='tambah'){
    $kode=$_POST[id_barang_masuk];
	mysqli_query($konek,"INSERT INTO barang_masuk(id_barang_masuk,
												  id_user,								 
												  id_supplier,
									              tanggal_masuk) 
	                       VALUES('$_POST[id_barang_masuk]',
								  '$_SESSION[user_id]',
                                  '$_POST[supplier]',
								  '$_POST[tanggal_masuk]')");

	header('location:../../media.php?module=masuk&act=transaksimasuk&kode='.$kode);
}
// Tambah masuk
elseif ($module=='masuk' AND $act=='input'){
	$edit=mysqli_query($konek,"SELECT * FROM barang_masuk WHERE id_barang_masuk='$_POST[id_barang_masuk]'");
    $r=mysqli_fetch_array($edit);
	$kode=$_POST[id_barang_masuk];
	mysqli_query($konek,"INSERT INTO detail_masuk(id_barang_masuk,
												  id_detail_barang,
												  harga_beli,
												  jumlah) 
										VALUES('$_POST[id_barang_masuk]',
											   '$_POST[barang]',
								               '$_POST[harga_beli]',
								               '$_POST[jumlah]')");
$kode_barang=$_POST[barang];
$kode_supplier=$_POST[id_supplier];							
$cek=mysqli_query($konek,"SELECT * FROM barang WHERE id_barang='$kode_barang'");

															
	mysqli_query($konek,"UPDATE detail_barang SET stok   = stok+'$_POST[jumlah]'
                       WHERE  id_detail_barang = '$_POST[barang]'");
	mysqli_query($konek,"INSERT INTO safety_stock(id_detail_barang) 
										VALUES('$_POST[barang]')");
	mysqli_query($konek,"UPDATE safety_stock SET verifikasi   = '0',
												 kode ='0'
                       WHERE  id_detail_barang = '$_POST[barang]'");

  header('location:../../media.php?module=masuk&act=transaksimasuk&kode='.$kode);							
							
}
// Delete masuk
elseif ($module=='masuk' AND $act=='delete'){
$edit=mysqli_query($konek,"SELECT * FROM detail_masuk WHERE id_detail_masuk='$_GET[kode]'");
    $r=mysqli_fetch_array($edit);
	$kodes=$r[id_barang_masuk];
	$jumlah=$r[jumlah];
	$kode_barang=$r[id_detail_barang];
  mysqli_query($konek,"DELETE FROM detail_masuk WHERE id_detail_masuk='$_GET[kode]'");
  mysqli_query($konek,"UPDATE detail_barang SET stok   = stok-'$jumlah'                                   
                           WHERE  id_detail_barang     = '$kode_barang'");
  header('location:../../media.php?module=masuk&act=transaksimasuk&kode='.$kodes);
   
}
}
?>
