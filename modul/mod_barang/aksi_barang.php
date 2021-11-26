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
// Hapus barang
if ($module=='barang' AND $act=='hapus'){
  mysqli_query($konek,"DELETE FROM barang WHERE id_barang='$_GET[id]'");
  mysqli_query($konek,"DELETE FROM detail_barang WHERE id_barang='$_GET[id]'");
  header('location:../../media.php?module='.$module);
}
// Input barang
elseif ($module=='barang' AND $act=='input'){
$id=$_POST[id_barang];
  mysqli_query($konek,"INSERT INTO barang(id_barang,
										  nama_barang,
										  id_merek) 
	                              VALUES('$_POST[id_barang]',
								         '$_POST[nama_barang]',
										 '$_POST[merek]')");
header('location:../../media.php?module=barang&act=stok&id='.$id);
}

// Update barang
elseif ($module=='barang' AND $act=='update'){
    mysqli_query($konek,"UPDATE barang SET nama_barang   = '$_POST[nama_barang]',
										   id_merek      = '$_POST[merek]'
                                      WHERE id_barang    = '$_POST[id]'");
  echo "<script>window.alert('Data berhasil diubah');
        window.location=('../../media.php?module=barang')</script>";
}
// Input barang
elseif ($module=='barang' AND $act=='stok'){
$id=$_POST[id_barang];
mysqli_query($konek,"INSERT INTO detail_barang(id_barang,
										       stok,
										       id_variasi_ukuran,
										       harga_jual,
										       biaya_pesan,
										       biaya_simpan,
										       lead_time) 
										VALUES('$_POST[id_barang]',
										       '$_POST[stok]',
										       '$_POST[variasi_ukuran]',
										       '$_POST[harga]',
										       '$_POST[biaya_pesan]',
										       '$_POST[biaya_simpan]',
										       '$_POST[lead_time]')");
  header('location:../../media.php?module=barang&act=stok&id='.$id);
}
// Update barang
elseif ($module=='barang' AND $act=='updatestok'){
$id=$_POST[id_barang];
    mysqli_query($konek,"UPDATE detail_barang SET harga_jual    	= '$_POST[harga]',
												  id_variasi_ukuran = '$_POST[variasi_ukuran]',
												  biaya_pesan   	= '$_POST[biaya_pesan]',
												  biaya_simpan  	= '$_POST[biaya_simpan]',
												  lead_time     	= '$_POST[lead_time]'
											WHERE id_detail_barang  = '$_POST[id_detail_barang]'");
  header('location:../../media.php?module=barang&act=stok&id='.$id);
}
// Hapus barang
elseif ($module=='barang' AND $act=='hapusstok'){
$id=$_GET[id];
  mysqli_query($konek,"DELETE FROM detail_barang WHERE id_detail_barang='$_GET[kode]'");
  mysqli_query($konek,"DELETE FROM safety_stock WHERE id_detail_barang='$_GET[id]'");
  header('location:../../media.php?module=barang&act=stok&id='.$id);
}
}
?>
