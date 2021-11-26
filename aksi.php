<?php
session_start();
error_reporting(0);
include "config/koneksi.php";
include "config/library.php";

$module=$_GET[module];
$act=$_GET[act];

if ($module=='keranjang' AND $act=='tambah'){

	$sid = session_id();
    $barang=$_POST[prod_barang];
	$jml=$_POST[jml];
	$sql2 = mysqli_query($konek,"SELECT * FROM detail_barang WHERE id_detail_barang='$barang'");
	$r=mysqli_fetch_array($sql2);
	$stok=$r[stok];
    $harga=$r[harga_jual];
  if ($stok == 0){
      echo "<script>window.alert('Maaf Stok Habis');
        window.location=('media.php?module=keluar&act=tambahkeluar')</script>";
  }
  elseif ($jml > $stok) {
  echo "<script>window.alert('Maaf Jumlah Stok Tidak Mencukupi');
        window.location=('media.php?module=keluar&act=tambahkeluar')</script>";
  }
  
  else{
	// check if the product is already
	// in cart table for this session
	$sql = mysqli_query($konek,"SELECT id_detail_barang FROM keranjang
			WHERE id_detail_barang='$barang' AND id_session='$sid'");
	$ketemu=mysqli_num_rows($sql);
	if ($ketemu==0){
		// put the product in cart table
		mysqli_query($konek,"INSERT INTO keranjang (id_detail_barang, jumlah, id_session, tgl, jam, stok_temp,price)
				VALUES ('$barang', '$_POST[jml]', '$sid', '$tgl_sekarang', '$jam_sekarang', '$stok','$harga')");	
	} else {
		// update product quantity in cart table
		mysqli_query($konek,"UPDATE keranjang 
		        SET jumlah = jumlah + 1
				WHERE id_session ='$sid' AND id_detail_barang='$barang'");
					
	}	
	deleteAbandonedCart();
	header('Location:media.php?module=keluar&act=tambahkeluar');
  }				
}

elseif ($module=='keranjang' AND $act=='hapus'){
$edit2=mysqli_query($konek,"SELECT * FROM keranjang WHERE id_keranjang='$_GET[id]'");
    $r2=mysqli_fetch_array($edit2);
	$jumlah=$r2[jumlah];
	$id_barang=$r2[id_barang];
	mysqli_query($konek,"DELETE FROM keranjang WHERE id_keranjang='$_GET[id]'");
	header('Location:media.php?module=keluar&act=tambahkeluar');				
}

elseif ($module=='keranjang' AND $act=='update'){
  $id       = $_POST[id];
  $jml_data = count($id);
  $jumlah   = $_POST[jml]; // quantity
  for ($i=1; $i <= $jml_data; $i++){
	$sql2 = mysqli_query($konek,"SELECT stok_temp FROM keranjang WHERE id_keranjang='".$id[$i]."'");
	while($r=mysqli_fetch_array($sql2)){
    if ($jumlah[$i] > $r[stok_temp]){
        echo "<script>window.alert('Jumlah yang Anda sewa melebihi stok yang ada');
        window.location=('media.php?module=keluar&act=tambahkeluar')</script>";
    }
elseif ($jumlah[$i] ==0) {
  echo "<script>window.alert('Maaf Jumlah Tidak Boleh 0');
        window.location=('media.php?module=keluar&act=tambahkeluar')</script>";
  }
    else{
      mysqli_query($konek,"UPDATE keranjang SET jumlah = '".$jumlah[$i]."'
                                      WHERE id_keranjang = '".$id[$i]."'");
		
      header('Location:media.php?module=keluar&act=tambahkeluar');
    }
  }
  }
}


/*
	Delete all cart entries older than one day
*/
function deleteAbandonedCart(){
	$kemarin = date('Y-m-d', mktime(0,0,0, date('m'), date('d') - 1, date('Y')));
	mysqli_query($konek,"DELETE FROM keranjang 
	        WHERE tgl < '$kemarin'");
}
?>
