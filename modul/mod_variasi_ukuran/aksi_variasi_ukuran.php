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
// Hapus variasi_ukuran
if ($module=='variasi_ukuran' AND $act=='hapus'){
  mysqli_query($konek,"DELETE FROM variasi_ukuran WHERE id_variasi_ukuran='$_GET[id]'");
  header('location:../../media.php?module='.$module);
}
// Input variasi_ukuran
elseif ($module=='variasi_ukuran' AND $act=='input'){
  mysqli_query($konek,"INSERT INTO variasi_ukuran(nama_variasi_ukuran) 
	                       VALUES('$_POST[nama_variasi_ukuran]')");
  echo "<script>window.alert('Data berhasil disimpan');
        window.location=('../../media.php?module=variasi_ukuran')</script>";
}

// Update variasi_ukuran
elseif ($module=='variasi_ukuran' AND $act=='update'){
    mysqli_query($konek,"UPDATE variasi_ukuran SET nama_variasi_ukuran   = '$_POST[nama_variasi_ukuran]' 
                           WHERE  id_variasi_ukuran     = '$_POST[id]'");
  echo "<script>window.alert('Data berhasil diubah');
        window.location=('../../media.php?module=variasi_ukuran')</script>";
}
}
?>
