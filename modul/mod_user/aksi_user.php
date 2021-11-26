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
// Hapus admin
if ($module=='user' AND $act=='hapus'){
  mysqli_query($konek,"DELETE FROM user WHERE id_user='$_GET[id]'");
  header('location:../../media.php?module='.$module);
}
// Input user
elseif ($module=='user' AND $act=='input'){
  $pass=md5($_POST[password]);
  $sql = mysqli_query($konek,"SELECT * FROM user WHERE email='$_POST[email]' OR username='$_POST[username]'");
$ketemu=mysqli_num_rows($sql);
	if ($ketemu > 0){
	echo"
	<p align=center>Maaf! Email Atau Username yang Anda masukkan sudah terdaftar, Silahkan ganti yang lain<br />
  	    <a href=javascript:history.go(-1)><b>Ulangi Lagi</b></a>
			</b></p>";
	}
	else {
  mysqli_query($konek,"INSERT INTO user(username,
                                 password,
                                 nama,
                                 email, 
                                 no_telp,
								 role,
								 is_active) 
	                       VALUES('$_POST[username]',
                                '$pass',
                                '$_POST[nama]',
                                '$_POST[email]',
                                '$_POST[no_telp]',
								'$_POST[role]',
								'1')");
  echo "<script>window.alert('Data berhasil disimpan');
        window.location=('../../media.php?module=user')</script>";
}
}
// Update user
elseif ($module=='user' AND $act=='update'){
  if (empty($_POST[password])) {
    mysqli_query($konek,"UPDATE user SET nama     = '$_POST[nama]',
                                         email    = '$_POST[email]',
                                         username = '$_POST[username]',  
                                         no_telp  = '$_POST[no_telp]',
										 role     = '$_POST[role]'
                                  WHERE  id_user  = '$_POST[id]'");
  }
  // Apabila password diubah
  else{
    $pass=md5($_POST[password]);
    mysqli_query($konek,"UPDATE user SET password  = '$pass',
                                         nama      = '$_POST[nama]',
                                         email     = '$_POST[email]',  
                                         username  = '$_POST[username]',  
                                         no_telp   = '$_POST[no_telp]',
										 role     = '$_POST[role]'
                                     WHERE id_user = '$_POST[id]'");
  }
  echo "<script>window.alert('Data berhasil diubah');
        window.location=('../../media.php?module=user')</script>";
}
}
?>
