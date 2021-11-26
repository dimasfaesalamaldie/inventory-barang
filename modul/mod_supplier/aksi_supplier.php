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
// Hapus supplier
if ($module=='supplier' AND $act=='hapus'){
  mysqli_query($konek,"DELETE FROM supplier WHERE id_supplier='$_GET[id]'");
  header('location:../../media.php?module='.$module);
}
// Input supplier
elseif ($module=='supplier' AND $act=='input'){
  mysqli_query($konek,"INSERT INTO supplier(nama_supplier,
											no_telp,
											alamat) 
	                                VALUES('$_POST[nama_supplier]',
										   '$_POST[no_telp]',
										   '$_POST[alamat]')");
  echo "<script>window.alert('Data berhasil disimpan');
        window.location=('../../media.php?module=supplier')</script>";
}

// Update supplier
elseif ($module=='supplier' AND $act=='update'){
    mysqli_query($konek,"UPDATE supplier SET nama_supplier   = '$_POST[nama_supplier]',
											 no_telp         = '$_POST[no_telp]',
											 alamat          = '$_POST[alamat]'
                                      WHERE  id_supplier     = '$_POST[id]'");
  echo "<script>window.alert('Data berhasil diubah');
        window.location=('../../media.php?module=supplier')</script>";
}
}
?>
