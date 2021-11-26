<?php
session_start();
include "../../config/koneksi.php";

$module=$_GET[module];
$act=$_GET[act];
$tgl_skrg = date("Ymd");
$jam_skrg = date("H:i:s");
// Hapus keluar
if ($module=='keluar' AND $act=='hapus'){
  mysqli_query($konek,"DELETE FROM barang_keluar WHERE id_barang_keluar='$_GET[id]'");
  mysqli_query($konek,"DELETE FROM detail_keluar WHERE id_barang_keluar='$_GET[id]'");
  header('location:../../media.php?module='.$module);
}
// Tambah keluar
elseif ($module=='keluar' AND $act=='input'){

$sql=mysqli_query($konek,"select * from barang_keluar order by id_barang_keluar DESC LIMIT 0,1");
	$data=mysqli_fetch_array($sql);
	$kodeawal=substr($data['id_barang_keluar'],7,5)+1;
	if($kodeawal<10){
		$kode = 'TBK-00000'.$kodeawal;
	}elseif($kodeawal > 9 && $kodeawal <=99){
		$kode='TBK-0000'.$kodeawal;
	}else{
		$kode='TBK-000'.$kodeawal;
	} 
	$sid = session_id();
    $data = mysqli_query($konek,"SELECT * FROM keranjang,detail_barang WHERE keranjang.id_detail_barang=detail_barang.id_detail_barang AND keranjang.id_session='$sid'");
    while($p=mysqli_fetch_array($data)){
		// simpan data detail pemesanan  
		$id=$p[id_detail_barang];
		$jumlah=$p[jumlah];
		$price=$p[price];
		$subtotal=$jumlah*$price;
		$total   = $total + $subtotal;
	mysqli_query($konek,"INSERT INTO detail_keluar(id_barang_keluar, id_detail_barang,harga, jumlah) 
               VALUES('$kode','$id','$price', '$jumlah')");

	mysqli_query($konek,"UPDATE detail_barang SET stok = stok - $jumlah
									   WHERE id_detail_barang='$id'");		   
	}
mysqli_query($konek,"INSERT INTO barang_keluar(id_barang_keluar,
											   id_user,
									           tanggal_keluar,
											   nama_pelanggan,
											   umur) 
										VALUES('$kode',
											   '$_SESSION[user_id]',
											   '$_POST[tanggal_keluar]',
											   '$_POST[nama_pelanggan]',
											   '$_POST[umur]')");
// setelah data pemesanan tersimpan, hapus data pemesanan di tabel pemesanan sementara (keranjang)
mysqli_query($konek,"DELETE FROM keranjang
	  	         WHERE id_session='$sid'");
header('location:../../media.php?module=keluar&act=detailkeluar&id='.$kode);

}


?>
