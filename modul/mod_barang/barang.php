<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{

$aksi="modul/mod_barang/aksi_barang.php";
switch($_GET[act]){
  // Tampil User
  default:
  echo"
  
<div class='card shadow-sm mb-4 border-bottom-primary'>
    <div class='card-header bg-white py-3'>
        <div class='row'>
            <div class='col'>
                <h4 class='h5 align-middle m-0 font-weight-bold text-primary'>
                    Data Barang
                </h4>
            </div>
            <div class='col-auto'>
                <a href='?module=barang&act=tambahbarang' class='btn btn-sm btn-primary btn-icon-split'>
                    <span class='icon'>
                        <i class='fa fa-user-plus'></i>
                    </span>
                    <span class='text'>
                        Tambah Barang
                    </span>
                </a>
            </div>
        </div>
    </div>
    <div class='table-responsive'>
        <table class='table table-striped dt-responsive nowrap' id='dataTable'>
            <thead>
                <tr>
                    <th width='30'>No.</th>
                    <th>ID Barang</th>
					<th>Merek</th>
					<th>Nama Barang</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>";
					$tampil = mysqli_query($konek,"SELECT * FROM barang JOIN merek ON barang.id_merek=merek.id_merek
																		ORDER BY id_barang ASC");
					$no=1;
					while ($r=mysqli_fetch_array($tampil)){
					echo"
                        <tr>
                            <td>$no</td>
                            <td>$r[id_barang]</td>
							<td>$r[nama_merek]</td>
							<td>$r[nama_barang]</td>
                            <td>
                                <a href='?module=barang&act=editbarang&id=$r[id_barang]' class='btn btn-circle btn-sm btn-warning'><i class='fa fa-fw fa-edit'></i></a>
								<a href='?module=barang&act=stok&id=$r[id_barang]' class='btn btn-circle btn-sm btn-info'><i class='fa fa-fw fa-folder'></i></a>
                                <a onClick=\"return confirm('Apakah Anda Yakin Untuk Menghapus Data Ini ?')\" href='$aksi?module=barang&act=hapus&id=$r[id_barang]' class='btn btn-circle btn-sm btn-danger'><i class='fa fa-fw fa-trash'></i></a>
                            </td>
                        </tr>";
						$no++;
						}
						echo"
            </tbody>
        </table>
    </div>
</div>
      ";
    break;
  
  case "tambahbarang":
   $sql=mysqli_query($konek,"select * from barang order by id_barang DESC LIMIT 0,1");
	$r=mysqli_fetch_array($sql);
	$kodeawal=substr($r['id_barang'],5,5)+1;
	if($kodeawal<10){
		$kode='B00000'.$kodeawal;
	}elseif($kodeawal > 9 && $kodeawal <=99){
		$kode='B0000'.$kodeawal;
	}else{
		$kode='B000'.$kodeawal;
	}

   echo"
   	<div class='row justify-content-center'>
    <div class='col-md-8'>
        <div class='card shadow-sm mb-4 border-bottom-primary'>
            <div class='card-header bg-white py-3'>
                <div class='row'>
                    <div class='col'>
                        <h4 class='h5 align-middle m-0 font-weight-bold text-primary'>
                            Form Tambah Barang
                        </h4>
                    </div>
                    <div class='col-auto'>
                        <a href='?module=barang' class='btn btn-sm btn-secondary btn-icon-split'>
                            <span class='icon'>
                                <i class='fa fa-arrow-left'></i>
                            </span>
                            <span class='text'>
                                Kembali
                            </span>
                        </a>
                    </div>
                </div>
            </div>
            <div class='card-body pb-2'>
			  <form method=POST action='$aksi?module=barang&act=input'>
                <div class='row form-group'>
                    <label class='col-md-3 text-md-right' for='nama'>ID Barang</label>
                    <div class='col-md-9'>
                        <input type='text' id='nama' name='id_barang' class='form-control' value='$kode' readonly>
                    </div>
                </div>
				<div class='row form-group'>
                    <label class='col-md-3 text-md-right' for='merek_id'>Merek Produk</label>
                    <div class='col-md-9'>
						<div class='input-group'>
                        <select class='custom-select' name='merek' required>
							<option value=0 selected>Pilih Merek Produk</option>";
								$tampil=mysqli_query($konek,"SELECT * FROM merek ORDER BY nama_merek ASC");
								while($r=mysqli_fetch_array($tampil)){
									echo "<option value=$r[id_merek]>$r[nama_merek]</option>";
								}
						echo "</select>
						<div class='input-group-append'>
                           <a class='btn btn-primary' href=media.php?module=merek&act=tambahmerek><i class='fa fa-plus'></i></a>
                        </div>
						</div>
                    </div>
                </div>
				<div class='row form-group'>
                    <label class='col-md-3 text-md-right' for='nama'>Nama Barang</label>
                    <div class='col-md-9'>
                        <input type='text' id='nama' name='nama_barang' class='form-control' placeholder='Nama Barang' required>
                    </div>
                </div>
				
                <div class='row form-group'>
                    <div class='col-md-9 offset-md-3'>
                        <button type='submit' class='btn btn-primary'>Simpan</button>
                        <button type='reset' class='btn btn-secondary'>Reset</bu>
                    </div>
                </div>
			  </form>
            </div>
        </div>
    </div>
</div>";
     break;
    
  case "editbarang":
    $edit=mysqli_query($konek,"SELECT * FROM barang WHERE id_barang='$_GET[id]'");
    $r=mysqli_fetch_array($edit);
	echo"
   	<div class='row justify-content-center'>
    <div class='col-md-8'>
        <div class='card shadow-sm mb-4 border-bottom-primary'>
            <div class='card-header bg-white py-3'>
                <div class='row'>
                    <div class='col'>
                        <h4 class='h5 align-middle m-0 font-weight-bold text-primary'>
                            Form Edit Barang
                        </h4>
                    </div>
                    <div class='col-auto'>
                        <a href='?module=barang' class='btn btn-sm btn-secondary btn-icon-split'>
                            <span class='icon'>
                                <i class='fa fa-arrow-left'></i>
                            </span>
                            <span class='text'>
                                Kembali
                            </span>
                        </a>
                    </div>
                </div>
            </div>
            <div class='card-body pb-2'>
			  <form method=POST action=$aksi?module=barang&act=update>
              <input type=hidden name=id value='$r[id_barang]'>
                <div class='row form-group'>
                    <label class='col-md-3 text-md-right' for='nama'>ID Barang</label>
                    <div class='col-md-9'>
                        <input type='text' id='nama' name='id_barang' class='form-control' value='$r[id_barang]' readonly>
                    </div>
                </div>
				<div class='row form-group'>
                    <label class='col-md-3 text-md-right' for='merek_id'>Merek Produk</label>
                    <div class='col-md-9'>
						<div class='input-group'>
                        <select class='custom-select' name='merek' required";
								$tampil=mysqli_query($konek,"SELECT * FROM merek ORDER BY nama_merek ASC");
									if ($r[id_merek]==0){
										echo "<option value=0 selected>- Pilih Merek Produk -</option>";
									}   

								while($w=mysqli_fetch_array($tampil)){
									if ($r[id_merek]==$w[id_merek]){
										echo "<option value=$w[id_merek] selected>$w[nama_merek]</option>";
									}
									else{
										echo "<option value=$w[id_merek]>$w[nama_merek]</option>";
									}
								}
						echo "</select>
						<div class='input-group-append'>
                           <a class='btn btn-primary' href=media.php?module=merek&act=tambahmerek><i class='fa fa-plus'></i></a>
                        </div>
						</div>
                    </div>
                </div>
				<div class='row form-group'>
                    <label class='col-md-3 text-md-right' for='nama'>Nama Barang</label>
                    <div class='col-md-9'>
                        <input type='text' id='nama' name='nama_barang' class='form-control' placeholder='Nama Barang' value='$r[nama_barang]' required>
                    </div>
                </div>
                <div class='row form-group'>
                    <div class='col-md-9 offset-md-3'>
                        <button type='submit' class='btn btn-primary'>Simpan</button>
                        <button type='reset' class='btn btn-secondary'>Reset</bu>
                    </div>
                </div>
			  </form>
            </div>
        </div>
    </div>
</div>";
       
    break;  
	case "hitungbarang":
    $cekdata=mysqli_query($konek,"SELECT * FROM detail_barang 
                                                            JOIN variasi_ukuran ON detail_barang.id_variasi_ukuran=variasi_ukuran.id_variasi_ukuran
                                                            JOIN barang ON barang.id_barang=detail_barang.id_barang
                                                            JOIN merek ON barang.id_merek=merek.id_merek
                                                            WHERE detail_barang.id_detail_barang='$_GET[id]'");
    $cd=mysqli_fetch_array($cekdata);
	$data=mysqli_query($konek,"SELECT * FROM detail_barang JOIN detail_masuk ON detail_barang.id_detail_barang=detail_masuk.id_detail_barang 
															JOIN variasi_ukuran ON detail_barang.id_variasi_ukuran=variasi_ukuran.id_variasi_ukuran
															JOIN barang ON barang.id_barang=detail_barang.id_barang
															JOIN merek ON barang.id_merek=merek.id_merek
															WHERE detail_barang.id_detail_barang='$_GET[id]'");
    $r=mysqli_fetch_array($data);
	$barang=$r[id_detail_barang];
	$stok=$r[stok];
	$harga_rp    = format_rupiah($r[harga_jual]);
	$simpan=$r[biaya_simpan];
	$biaya_pesanrp=format_rupiah($r[biaya_pesan]);
	$biaya_simpan=($r[biaya_simpan]/100)*$r[harga_jual];
	$biaya_simpanrp=format_rupiah($biaya_simpan);
	$biaya_pesan=$r[biaya_pesan];
	$lead=$r[lead_time];
	$lead_time=round(($lead/30),3);
	
 
// Menambah bulan ini + semua bulan pada tahun sebelumnya
$periode = 12;
 

 

	$hari=$periode*30;
	$caritotal=mysqli_query($konek,"SELECT SUM(detail_keluar.jumlah) AS total_jual FROM barang_keluar,detail_keluar WHERE barang_keluar.id_barang_keluar=detail_keluar.id_barang_keluar AND detail_keluar.id_detail_barang='$barang'");
    $ct=mysqli_fetch_array($caritotal);
	$total_jual=$ct[total_jual];
	$rata_jual=($total_jual/$periode);
	$eoq=sqrt((2*$biaya_pesan*$total_jual)/$biaya_simpan);
	$carimaxp=mysqli_query($konek,"SELECT SUM(detail_keluar.jumlah) AS jumlah FROM barang_keluar,detail_keluar WHERE barang_keluar.id_barang_keluar=detail_keluar.id_barang_keluar AND detail_keluar.id_detail_barang='$barang' GROUP BY YEAR(barang_keluar.tanggal_keluar), MONTH(barang_keluar.tanggal_keluar) ORDER BY jumlah DESC");
    $cm=mysqli_fetch_array($carimaxp);
	$maxp=$cm[jumlah];
	$ss=($maxp-$rata_jual)*$lead;
	$ss2=round(($ss),0);
	$rop=($lead*($total_jual/$hari))+$ss;
	$rop2=round(($rop),0);
	$mi=$ss+$eoq;
	$mi2=round(($mi),0);
	mysqli_query($konek,"UPDATE safety_stock SET terjual   = '$total_jual',
												 max   	   = '$maxp',
												 rerata    = '$rata_jual',
												 leadtime  = '$lead',
												 stock     = '$stok',
												 safety_stock   = '$ss2',
												 rop   	   = '$rop2',
												 eoq   	   = '$eoq',
												 status    = '$status'
											 WHERE  id_detail_barang = '$barang'");
   echo"
   	<div class='row left-content-center'>
    <div class='col-md-6'>
        <div class='card shadow-sm mb-4 border-bottom-primary'>
            <div class='card-header bg-white py-3'>
                <div class='row'>
                    <div class='col'>
                        <h4 class='h5 align-middle m-0 font-weight-bold text-primary'>
                            Detail Barang
                        </h4>
                    </div>
                    
                </div>
            </div>
            <div class='card-body pb-2'>
				<div class='row form-group'>
                    <label class='col-md-4 text-md-right' for='merek_id'>Nama Merek: </label>
                    <p>$cd[nama_merek]</p>
                </div>
                <div class='row form-group'>
                    <label class='col-md-4 text-md-right' for='merek_id'>Nama Barang: </label>
                    <p>$cd[nama_barang]</p>
                </div>
                <div class='row form-group'>
                    <label class='col-md-4 text-md-right' for='merek_id'>Variasi Ukuran: </label>
                    <p>$cd[nama_variasi_ukuran]</p>
                </div>
				<div class='row form-group'>
                    <label class='col-md-4 text-md-right' for='nama'>Biaya Pesan: </label>
                    <p>Rp. $biaya_pesanrp</p>
                </div>
				<div class='row form-group'>
                    <label class='col-md-4 text-md-right' for='nama'>Biaya Simpan: </label>
                    <p>Rp. $biaya_simpanrp ($simpan% dari Rp. $harga_rp)</p>
                </div>
				<div class='row form-group'>
                    <label class='col-md-4 text-md-right' for='nama'>Lead Time: </label>
                    <p>$lead </p>
                </div>
				<div class='row form-group'>
                    <label class='col-md-4 text-md-right' for='nama'>Jumlah Periode: </label>
                    <p>$periode </p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class='card shadow-sm mb-4 border-bottom-primary'>
    <div class='card-header bg-white py-3'>
        <div class='row'>
            <div class='col'>
                <h4 class='h5 align-middle m-0 font-weight-bold text-primary'>
                    Perhitungan Barang
                </h4>
            </div>
        </div>
    </div>
    <div class='table-responsive'>
        <table class='table table-striped dt-responsive nowrap' id='dataTable'>
            <thead>
                <tr>
                    <th width='30'>No.</th>
					<th>Terjual</th>
					<th>Max</th>
					<th>Rata-Rata</th>
					<th>Lead Time</th>
					<th>Stock</th>
					<th>Safety Stock</th>
					<th>Reoreder Point</th>
					<th>EOQ</th>
                </tr>
            </thead>
            <tbody>";
					$no=1;
					$tampil = mysqli_query($konek,"SELECT * FROM detail_barang JOIN safety_stock ON detail_barang.id_detail_barang=safety_stock.id_detail_barang
																		WHERE detail_barang.id_detail_barang='$_GET[id]'");
					while ($k=mysqli_fetch_array($tampil)){
							
					echo"
                        <tr>
                            <td>$no</td>
                            <td>$k[terjual]</td>
							<td>$k[max]</td>		         
							<td>$k[rerata]</td>
                            <td>$k[leadtime]</td>
							<td>$k[stock]</td>
							<td>$k[safety_stock]</td>
							<td>$k[rop]</td>
							<td>$k[eoq]</td>
                        </tr>";
						$no++;
						}
						echo"
            </tbody>
        </table>
    </div>
</div>";
     break;
	 case "stok":
   $sql=mysqli_query($konek,"select * from barang WHERE id_barang='$_GET[id]'");
	$r=mysqli_fetch_array($sql);

   echo"
   	<div class='row justify-content-center'>
    <div class='col-md-8'>
        <div class='card shadow-sm mb-4 border-bottom-primary'>
            <div class='card-header bg-white py-3'>
                <div class='row'>
                    <div class='col'>
                        <h4 class='h5 align-middle m-0 font-weight-bold text-primary'>
                            Form Detail Barang $r[nama_barang]
                        </h4>
                    </div>
                    
                </div>
            </div>
            <div class='card-body pb-2'>
			  <form method=POST action='$aksi?module=barang&act=stok'>
                <input type=hidden name=id_barang value='$r[id_barang]'>
				<div class='row form-group'>
                    <label class='col-md-3 text-md-right' for='merek_id'>Variasi ukuran</label>
                    <div class='col-md-9'>
						<div class='input-group'>
                        <select class='custom-select' name='variasi_ukuran' required>
							<option value=0 selected> Pilih variasi ukuran </option>";
								$tampil=mysqli_query($konek,"SELECT * FROM variasi_ukuran ORDER BY nama_variasi_ukuran ASC");
								while($r=mysqli_fetch_array($tampil)){
									echo "<option value=$r[id_variasi_ukuran]>$r[nama_variasi_ukuran]</option>";
								}
						echo "
                        </select>
						</div>
                    </div>
                </div>
				<div class='row form-group'>
                    <label class='col-md-3 text-md-right' for='nama'>Harga</label>
                    <div class='col-md-9'>
                        <input type='number' id='nama' name='harga' min='0' class='form-control' placeholder='Harga Barang' required>
                    </div>
                </div>
				<div class='row form-group'>
                    <label class='col-md-3 text-md-right' for='nama'>Biaya Pesan</label>
                    <div class='col-md-9'>
                        <input type='number' id='nama' name='biaya_pesan' min='0' class='form-control' placeholder='Biaya Pesan' required>
                    </div>
                </div>
				<div class='row form-group'>
                    <label class='col-md-3 text-md-right' for='nama'>Biaya Simpan (% dari Harga Per Unit)</label>
                    <div class='col-md-9'>
                        <input type='number' id='nama' name='biaya_simpan' min='0' class='form-control' placeholder='Biaya Simpan' required>
                    </div>
                </div>
				<div class='row form-group'>
                    <label class='col-md-3 text-md-right' for='nama'>Lead Time</label>
                    <div class='col-md-9'>
                        <input type='number' id='nama' name='lead_time' min='0' class='form-control' placeholder='Lead Time' required>
                    </div>
                </div>
                <div class='row form-group'>
                    <div class='col-md-9 offset-md-3'>
                        <button type='submit' class='btn btn-primary'>Simpan</button>
                        <button type='reset' class='btn btn-secondary'>Reset</bu>
                    </div>
                </div>
			  </form>
            </div>
        </div>
    </div>
</div>

<div class='card shadow-sm mb-4 border-bottom-primary'>
    <div class='card-header bg-white py-3'>
        <div class='row'>
            <div class='col'>
                <h4 class='h5 align-middle m-0 font-weight-bold text-primary'>
                    Detail Barang
                </h4>
            </div>
        </div>
    </div>
    <div class='table-responsive'>
        <table class='table table-striped dt-responsive nowrap' id='dataTable'>
            <thead>
                <tr>
                    <th width='30'>No.</th>
					<th>Variasi Ukuran</th>
					<th>Harga</th>
					<th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>";
					$no=1;
					$tampil = mysqli_query($konek,"SELECT * FROM detail_barang JOIN variasi_ukuran ON detail_barang.id_variasi_ukuran=variasi_ukuran.id_variasi_ukuran
																		       WHERE detail_barang.id_barang='$_GET[id]'
																			   ORDER BY detail_barang.id_detail_barang ASC");
					while ($r=mysqli_fetch_array($tampil)){
					$harga_rp = format_rupiah($r[harga_jual]);		
					echo"
                        <tr>
                            <td>$no</td>
							<td>$r[nama_variasi_ukuran]</td>
							<td>Rp. $harga_rp</td>
							<td>$r[stok]</td>
                            <td>
                                <a href='?module=barang&act=editstok&id=$r[id_detail_barang]' class='btn btn-circle btn-sm btn-warning'><i class='fa fa-fw fa-edit'></i></a>
								<a href='?module=barang&act=hitungbarang&id=$r[id_detail_barang]' class='btn btn-circle btn-sm btn-success'><i class='fa fa-fw fa-folder'></i></a>
								<a onClick=\"return confirm('Apakah Anda Yakin Untuk Menghapus Data Ini ?')\" href='$aksi?module=barang&act=hapusstok&kode=$r[id_detail_barang]&id=$r[id_barang]' class='btn btn-circle btn-sm btn-danger'><i class='fa fa-fw fa-trash'></i></a>
                            </td>
                        </tr>";
						$no++;
						}
						echo"
            </tbody>
        </table>
    </div>
</div>";
     break;
	 
	 case "editstok":
   $sql=mysqli_query($konek,"select * from detail_barang WHERE id_detail_barang='$_GET[id]'");
	$r=mysqli_fetch_array($sql);
	$id_barang=$r[id_barang];
   echo"
   	<div class='row justify-content-center'>
    <div class='col-md-8'>
        <div class='card shadow-sm mb-4 border-bottom-primary'>
            <div class='card-header bg-white py-3'>
                <div class='row'>
                    <div class='col'>
                        <h4 class='h5 align-middle m-0 font-weight-bold text-primary'>
                            Form Edit Detail Barang
                        </h4>
                    </div>
                    <div class='col-auto'>
                        <a href='?module=barang&act=stok&id=$id_barang' class='btn btn-sm btn-secondary btn-icon-split'>
                            <span class='icon'>
                                <i class='fa fa-arrow-left'></i>
                            </span>
                            <span class='text'>
                                Kembali
                            </span>
                        </a>
                    </div>
                </div>
            </div>
            <div class='card-body pb-2'>
			  <form method=POST action='$aksi?module=barang&act=updatestok'>
                <input type=hidden name=id_detail_barang value='$r[id_detail_barang]'>
				<input type=hidden name=id_barang value='$r[id_barang]'>
				<div class='row form-group'>
                    <label class='col-md-3 text-md-right' for='merek_id'>Variasi Ukuran Barang</label>
                    <div class='col-md-9'>
						<div class='input-group'>
                        <select class='custom-select' name='variasi_ukuran' required>";
								$tampil=mysqli_query($konek,"SELECT * FROM variasi_ukuran ORDER BY nama_variasi_ukuran ASC");
									if ($r[id_variasi_ukuran]==0){
										echo "<option value=0 selected>- Pilih Variasi Ukuran Barang -</option>";
									}   

								while($w=mysqli_fetch_array($tampil)){
									if ($r[id_variasi_ukuran]==$w[id_variasi_ukuran]){
										echo "<option value=$w[id_variasi_ukuran] selected>$w[nama_variasi_ukuran]</option>";
									}
									else{
										echo "<option value=$w[id_variasi_ukuran]>$w[nama_variasi_ukuran]</option>";
									}
								}
						echo "</select>
						<div class='input-group-append'>
                           <a class='btn btn-primary' href=media.php?module=variasi_ukuran&act=tambahvariasi_ukuran><i class='fa fa-plus'></i></a>
                        </div>
						</div>
                    </div>
                </div>
				<div class='row form-group'>
                    <label class='col-md-3 text-md-right' for='nama'>Harga</label>
                    <div class='col-md-9'>
                        <input type='number' id='nama' name='harga' min='0' class='form-control' placeholder='Harga Barang' value='$r[harga_jual]' required>
                    </div>
                </div>
				<div class='row form-group'>
                    <label class='col-md-3 text-md-right' for='nama'>Biaya Pesan</label>
                    <div class='col-md-9'>
                        <input type='number' id='nama' name='biaya_pesan' min='0' class='form-control' placeholder='Biaya Pesan' value='$r[biaya_pesan]' required>
                    </div>
                </div>
				<div class='row form-group'>
                    <label class='col-md-3 text-md-right' for='nama'>Biaya Simpan (% dari Harga Per Unit)</label>
                    <div class='col-md-9'>
                        <input type='number' id='nama' name='biaya_simpan' min='0' class='form-control' placeholder='Biaya Simpan' value='$r[biaya_simpan]' required>
                    </div>
                </div>
				<div class='row form-group'>
                    <label class='col-md-3 text-md-right' for='nama'>Lead Time</label>
                    <div class='col-md-9'>
                        <input type='number' id='nama' name='lead_time' min='0' class='form-control' placeholder='Lead Time' value='$r[lead_time]' required>
                    </div>
                </div>
                <div class='row form-group'>
                    <div class='col-md-9 offset-md-3'>
                        <button type='submit' class='btn btn-primary'>Update</button>
                        <button type='reset' class='btn btn-secondary'>Reset</bu>
                    </div>
                </div>
			  </form>
            </div>
        </div>
    </div>
</div>

";
     break;
}
}
?>
