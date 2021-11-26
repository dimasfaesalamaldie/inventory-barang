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
// Proses Input Verifikasi
if ($module=='stok' AND $act=='input'){
$barang=$_POST['barang'];
		if(!empty($barang)){
			foreach($barang as $val){
				$qry_insert=mysqli_query($konek,"UPDATE safety_stock SET kode = '1'
																		WHERE id_detail_barang='$val'");
			}
		}
header('location:../../media.php?module=stok&act=verifikasiorder');
}
// Proses Verifikasi
elseif ($module=='stok' AND $act=='verifikasi'){
$tgl_sekarang = date("Y-m-d");
$tgl_skrg = date("Ymd");
$cek=mysqli_query($konek,"SELECT * FROM verifikasiorder ORDER BY id_verifikasiorder DESC");
$ketemu=mysqli_num_rows($cek);
$r=mysqli_fetch_array($cek);
 if ($ketemu > 0){
 $hasil=$r[id_verifikasiorder]+1;
 }
 else {
 $kode=1;
 $hasil=$tgl_skrg.$kode;
 }
 mysqli_query($konek,"INSERT INTO verifikasiorder(id_verifikasiorder,
												  id_user,
												  tanggal) 
										VALUES('$hasil',
											   '$_SESSION[user_id]',
											   '$tgl_sekarang')");
 $cekdata = mysqli_query($konek,"SELECT * FROM detail_barang JOIN safety_stock ON detail_barang.id_detail_barang=safety_stock.id_detail_barang 
																			   JOIN variasi_ukuran ON detail_barang.id_variasi_ukuran=variasi_ukuran.id_variasi_ukuran
																			   JOIN barang ON barang.id_barang=detail_barang.id_barang
																			   WHERE safety_stock.kode='1'
																			   AND safety_stock.verifikasi='0'
																			   ORDER BY detail_barang.id_detail_barang ASC");
					
					while ($c=mysqli_fetch_array($cekdata)){
					$idbarang=$c[id_detail_barang];
					mysqli_query($konek,"INSERT INTO detail_verifikasi(id_verifikasiorder,id_detail_barang) 
										VALUES('$hasil','$idbarang')");
					mysqli_query($konek,"UPDATE safety_stock SET verifikasi = '1'
															WHERE id_detail_barang='$idbarang'");
 }
$jumls = mysqli_num_rows(mysqli_query($konek,"SELECT * FROM detail_barang JOIN variasi_ukuran ON detail_barang.id_variasi_ukuran=variasi_ukuran.id_variasi_ukuran
																		  JOIN barang ON barang.id_barang=detail_barang.id_barang
																		  ORDER BY barang.id_barang ASC"));
for ($ia=1; $ia<=$jumls; $ia++){
          $a  = $_POST['a'.$ia];
		  $b  = $_POST['b'.$ia];
          $parameter = $_POST['id_detail_barang'.$ia];
mysqli_query($konek,"UPDATE detail_barang SET biaya_simpan = '$a',
									   harga_beli   = '$b',
									   biaya_pesan  = '$_POST[biaya_pemesanan]'
                           WHERE  id_detail_barang  = '$parameter'");
	}
	$tampil = mysqli_query($konek,"SELECT * FROM detail_barang JOIN detail_masuk ON detail_barang.id_detail_barang=detail_masuk.id_detail_barang GROUP BY detail_barang.id_detail_barang ORDER BY detail_barang.id_detail_barang ASC");
						$no=1;
						while ($r=mysqli_fetch_array($tampil)){
						$barang=$r[id_detail_barang];
						$stok=$r[stok];
						$simpan=$r[biaya_simpan];
						$biaya_simpan=($r[biaya_simpan]/100)*$r[harga_jual];
						$periode = 12;
 
 
	$biaya_pesan=$r[biaya_pesan];
	$hari=$periode*30;
	$caritotal=mysqli_query($konek,"SELECT SUM(detail_keluar.jumlah) AS total_jual FROM barang_keluar,detail_keluar WHERE barang_keluar.id_barang_keluar=detail_keluar.id_barang_keluar AND detail_keluar.id_detail_barang='$barang'");
    $ct=mysqli_fetch_array($caritotal);
	$total_jual=$ct[total_jual];
	$rata_jual=($total_jual/$periode);
	$eoq=sqrt((2*$biaya_pesan*$total_jual)/$biaya_simpan);
	mysqli_query($konek,"UPDATE safety_stock SET eoq = '$eoq'
                           WHERE  id_detail_barang  = '$barang'");					
	}
header('location:../../media.php?module=stok&act=detailverifikasi&id='.$hasil);
}
}
?>
