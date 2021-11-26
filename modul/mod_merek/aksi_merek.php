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
// Hapus merek
if ($module=='merek' AND $act=='hapus'){
  mysqli_query($konek,"DELETE FROM merek WHERE id_merek='$_GET[id]'");
  header('location:../../media.php?module='.$module);
}
// Input merek
elseif ($module=='merek' AND $act=='input'){
  mysqli_query($konek,"INSERT INTO merek(nama_merek) 
	                       VALUES('$_POST[nama_merek]')");
  echo "<script>window.alert('Data berhasil disimpan');
        window.location=('../../media.php?module=merek')</script>";
}

// Update merek
elseif ($module=='merek' AND $act=='update'){
    mysqli_query($konek,"UPDATE merek SET nama_merek   = '$_POST[nama_merek]' 
                           WHERE  id_merek     = '$_POST[id]'");
  echo "<script>window.alert('Data berhasil diubah');
        window.location=('../../media.php?module=merek')</script>";
}
}
?>
