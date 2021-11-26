<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{

$aksi="modul/mod_stok/aksi_stok.php";
switch($_GET[act]){
  // Tampil User
  default:
  echo"
<div class='col-12 col-sm-12 col-lg-12'>
    <div class='card card-primary card-tabs'>
        <div class='card-header p-0 pt-1'>
            <ul class='nav nav-tabs' id='custom-tabs-one-tab' role='tablist'>
                <li class='nav-item'>
                  <a class='nav-link active' id='custom-tabs-one-home-tab' data-toggle='pill' href='#custom-tabs-one-home' role='tab' aria-controls='custom-tabs-one-home' aria-selected='true'>Semua</a>
                </li>
                <li class='nav-item'>
                  <a class='nav-link' id='custom-tabs-one-profile-tab' data-toggle='pill' href='#custom-tabs-one-profile' role='tab' aria-controls='custom-tabs-one-profile' aria-selected='false'>Unsafe</a>
                </li>
            </ul>
        </div>
        <div class='card-body'>
            <div class='tab-content' id='custom-tabs-one-tabContent'>
                <div class='tab-pane fade show active' id='custom-tabs-one-home' role='tabpanel' aria-labelledby='custom-tabs-one-home-tab'>
                    <table class='table table-striped dt-responsive nowrap' id='dataTable'>
						<thead>
							<tr>
								<th width='30'>No.</th>
								<th>Barang</th>
								<th>Variasi Ukuran</th>
								<th>Lead Time</th>
								<th>Stok</th>
								<th>Rata-Rata</th>
								<th>Status</th>
							</tr>
						</thead>
						<tbody>";
						$tampil = mysqli_query($konek,"SELECT * FROM detail_barang JOIN detail_masuk ON detail_barang.id_detail_barang=detail_masuk.id_detail_barang 
																				   JOIN variasi_ukuran ON detail_barang.id_variasi_ukuran=variasi_ukuran.id_variasi_ukuran
																				   JOIN barang ON barang.id_barang=detail_barang.id_barang
																				   JOIN merek ON barang.id_merek=merek.id_merek
																				   GROUP BY detail_barang.id_detail_barang ORDER BY barang.id_barang ASC");
						$no=1;
						while ($r=mysqli_fetch_array($tampil)){
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
				$k = mysqli_fetch_array(mysqli_query($konek,"SELECT * FROM detail_barang JOIN safety_stock ON detail_barang.id_detail_barang=safety_stock.id_detail_barang
																						 JOIN variasi_ukuran ON detail_barang.id_variasi_ukuran=variasi_ukuran.id_variasi_ukuran
																				         JOIN barang ON barang.id_barang=detail_barang.id_barang
																						 WHERE detail_barang.id_detail_barang='$barang'"));
					
					$rata=$k[rerata];
					$rataakhir=round($k[rerata]);
					$persediaan=$k[stock];
					if ($persediaan < $rata) {
					$statusbarang='Unsafe';
					}
					else {
					$statusbarang='Safe';
					}
					mysqli_query($konek,"UPDATE safety_stock SET status  = '$statusbarang' WHERE id_detail_barang = '$r[id_detail_barang]'");
					echo"
                        <tr>
                            <td>$no</td>
                            <td>$r[id_barang] | $r[nama_merek] $r[nama_barang]</td>
							<td>$k[nama_variasi_ukuran]</td>
                            <td>$k[leadtime] Hari</td>
							<td>$k[stock]</td>
							<td>$rataakhir</td>
							<td>";
							if ($persediaan < $rata) {
							echo"Unsafe";
							}
							else {
							echo"Safe";
							}
							echo"
							</td>
                        </tr>";
						$no++;
						}
						echo"
            </tbody>
        </table>
                </div>
                <div class='tab-pane fade' id='custom-tabs-one-profile' role='tabpanel' aria-labelledby='custom-tabs-one-profile-tab'>";
				$cek = mysqli_query($konek,"SELECT * FROM detail_barang JOIN safety_stock ON detail_barang.id_detail_barang=safety_stock.id_detail_barang 
																		JOIN variasi_ukuran ON detail_barang.id_variasi_ukuran=variasi_ukuran.id_variasi_ukuran
																		JOIN barang ON barang.id_barang=detail_barang.id_barang
																		WHERE safety_stock.status='Unsafe' ORDER BY detail_barang.id_detail_barang ASC");
				$ketemu=mysqli_num_rows($cek);
				if ($ketemu > 0){
				echo"
				<form action=$aksi?module=stok&act=input method=POST class='form-horizontal'>
                    <table class='table table-striped dt-responsive nowrap' id='dataTable2'>
						<thead>
							<tr>
								<th width='30'>No.</th>
								<th>Barang</th>
								<th>Variasi Ukuran</th>
								<th>Terjual</th>
								<th>Max</th>
								<th>Rata-Rata</th>
								<th>Stock</th>
								<th>Reorder Point</th>
							</tr>
						</thead>
						<tbody>";
						$tampil = mysqli_query($konek,"SELECT * FROM detail_barang JOIN safety_stock ON detail_barang.id_detail_barang=safety_stock.id_detail_barang 
																		JOIN variasi_ukuran ON detail_barang.id_variasi_ukuran=variasi_ukuran.id_variasi_ukuran
																		JOIN barang ON barang.id_barang=detail_barang.id_barang
																		JOIN merek ON barang.id_merek=merek.id_merek
																		WHERE safety_stock.status='Unsafe' 
																		ORDER BY barang.id_barang ASC");
						$no=1;
						while ($r=mysqli_fetch_array($tampil)){
						$verifikasi=$r[verifikasi];
						echo"
                        <tr>
                            <td>$no";
							if ($verifikasi!=1){
							echo"
							<input type='checkbox' name='barang[]' value=$r[id_detail_barang]>";
							}
							
							echo"
							</td>
                            <td>$r[id_barang] | $r[nama_merek] $r[nama_barang]</td>
							<td>$r[nama_variasi_ukuran]</td>
							<td>$r[terjual]</td>
							<td>$r[max]</td>		         
							<td>$r[rerata]</td>
							<td>$r[stock]</td>
							<td>$r[rop]</td>
                        </tr>";
						$no++;
						}
						echo"
						</tbody>
					</table>
					<button type='submit' class='btn btn-success'>Verifikasi Order</button>";
				}
				else {
					echo"<center><p>Tidak ada data barang</p></center>";
				}
				echo"
                </div>
            </div>
			
        </div>
     <!-- /.card -->
    </div>
</div>
      ";
    break;
case "verifikasiorder":
echo"
  
<div class='card shadow-sm mb-4 border-bottom-primary'>
    <div class='card-header bg-white py-3'>
        <div class='row'>
            <div class='col'>
                <h4 class='h5 align-middle m-0 font-weight-bold text-primary'>
                    Verifikasi Order
                </h4>
            </div>
        </div>
    </div>
    <div class='table-responsive'>
	<form method=POST action='$aksi?module=stok&act=verifikasi'>
			<div class='card-body pb-2'>
                <div class='row form-group'>
                    <label class='col-md-4 text-md-right' for='nama'>Biaya Pemesanan</label>
                    <div class='col-md-6'>
                        <input type='number' min='0' id='nama' name='biaya_pemesanan' class='form-control' placeholder='Biaya Pemesanan' required>
                    </div>
                </div>
                
            </div>
        <table class='table table-striped dt-responsive nowrap'>
            <thead>
                <tr>
                    <th width='30'>No.</th>
                    <th>ID Barang</th>
					<th>Barang</th>
					<th>Ukuran</th>
					<th>Biaya Penyimpanan(% dari harga)</th>
					<th>Harga Beli</th>
                </tr>
            </thead>
            <tbody>";
					$tampil = mysqli_query($konek,"SELECT * FROM detail_barang JOIN safety_stock ON detail_barang.id_detail_barang=safety_stock.id_detail_barang 
																			   JOIN variasi_ukuran ON detail_barang.id_variasi_ukuran=variasi_ukuran.id_variasi_ukuran
																			   JOIN barang ON barang.id_barang=detail_barang.id_barang
																			   JOIN merek ON barang.id_merek=merek.id_merek
																			   WHERE safety_stock.kode='1'
																			   AND safety_stock.verifikasi='0'
																			   ORDER BY detail_barang.id_detail_barang ASC");
					$no=1;
					while ($r=mysqli_fetch_array($tampil)){
					echo"
                        <tr>
                            <td>$no</td>
                            <td><input type='hidden' name='id_detail_barang".$no."' value='$r[id_detail_barang]'>$r[id_barang]</td>
							<td>$r[nama_merek] $r[nama_barang]</td>
							<td>$r[nama_variasi_ukuran]</td>
							<td><input name='a".$no."' type='number' min='0' class='form-control' placeholder='Isikan Biaya Penyimpanan' required></td>
							<td><input name='b".$no."' type='number' min='0' class='form-control' placeholder='Isikan Harga Beli' required></td>
                        </tr>";
						$no++;
						}
						echo"
            </tbody>
        </table><br>
		<button type='submit' class='btn btn-success ml-3 mb-2'>Simpan</button><br>
	  </form>
    </div>
</div>
      ";
    break;
case "hasilverifikasi":	
echo"
  
<div class='card shadow-sm mb-4 border-bottom-primary'>
    <div class='card-header bg-white py-3'>
        <div class='row'>
            <div class='col'>
                <h4 class='h5 align-middle m-0 font-weight-bold text-primary'>
                    Data Verifikasi Order
                </h4>
            </div>
        </div>
    </div>
    <div class='table-responsive'>
        <table class='table table-striped dt-responsive nowrap' id='dataTable'>
            <thead>
                <tr>
                    <th width='30'>No.</th>
                    <th>ID Verifikasi Order</th>
					<th>Tanggal</th>
					<th>User</th>
					<th>Aksi</th>
                </tr>
            </thead>
            <tbody>";
					$no=1;
					$tampil = mysqli_query($konek,"SELECT * FROM verifikasiorder JOIN user ON verifikasiorder.id_user=user.id_user ORDER BY verifikasiorder.tanggal ASC");
					while($r=mysqli_fetch_array($tampil)){
					$tanggal=tgl_indo($r[tanggal]);
					echo"
                        <tr>
                            <td>$no</td>
                            <td>$r[id_verifikasiorder]</td>
							<td>$tanggal</td>	
							<td>$r[nama]</td>
							<td><a href='?module=stok&act=detailverifikasi&id=$r[id_verifikasiorder]' class='btn btn-circle btn-sm btn-warning'><i class='fa fa-fw fa-folder'></i></a></td>
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
case "detailverifikasi":
$data=mysqli_query($konek,"SELECT * FROM verifikasiorder JOIN user ON verifikasiorder.id_user=user.id_user WHERE verifikasiorder.id_verifikasiorder='$_GET[id]'");
$r=mysqli_fetch_array($data);
$cetak=$r[cetak];
$tanggal=tgl_indo($r[tanggal]);
echo"
   	<div class='row left-content-center'>
    <div class='col-md-6'>
        <div class='card shadow-sm mb-4 border-bottom-primary'>
            <div class='card-header bg-white py-3'>
                <div class='row'>
                    <div class='col'>
                        <h4 class='h5 align-middle m-0 font-weight-bold text-primary'>
                            Detail Order
                        </h4>
                    </div>
                    </div>
            </div>
            <div class='card-body pb-2'>
				<div class='row form-group'>
                    <label class='col-md-4 text-md-right' for='merek_id'>ID Verifikasi Order : </label>
                    <p>$r[id_verifikasiorder]</p>
                </div>
                <div class='row form-group'>
                    <label class='col-md-4 text-md-right' for='merek_id'>Tanggal : </label>
                    <p>$tanggal</p>
                </div>
                <div class='row form-group'>
                    <label class='col-md-4 text-md-right' for='merek_id'>Penanggung Jawab : </label>
                    <p>$r[nama]</p>
                </div>
            </div>
        </div>
    </div>
</div>";	
echo"
  
<div class='card shadow-sm mb-4 border-bottom-primary'>
    <div class='card-header bg-white py-3'>
        <div class='row'>
            <div class='col'>
                <h4 class='h5 align-middle m-0 font-weight-bold text-primary'>
                    Data Verifikasi Order
                </h4>
            </div>
        </div>
    </div>
    <div class='table-responsive'>
        <table class='table table-striped dt-responsive nowrap' id='dataTable'>
            <thead>
                <tr>
                    <th width='30'>No.</th>
                    <th>ID Barang</th>
                    <th>Barang</th>
					<th>Variasi Ukuran</th>
					<th>Biaya Simpan(% dari harga)</th>
					<th>Harga Beli</th>
					<th>Jumlah Order</th>
                </tr>
            </thead>
            <tbody>";
					$no=1;
					$tampil = mysqli_query($konek,"SELECT * FROM detail_barang JOIN safety_stock ON detail_barang.id_detail_barang=safety_stock.id_detail_barang
																			   JOIN barang ON barang.id_barang=detail_barang.id_barang
																			   JOIN variasi_ukuran ON detail_barang.id_variasi_ukuran=variasi_ukuran.id_variasi_ukuran
																			   JOIN detail_verifikasi ON detail_verifikasi.id_detail_barang=detail_barang.id_detail_barang
																			   JOIN verifikasiorder ON verifikasiorder.id_verifikasiorder=detail_verifikasi.id_verifikasiorder
																			   JOIN merek ON barang.id_merek=merek.id_merek
																			   WHERE verifikasiorder.id_verifikasiorder='$_GET[id]' ORDER BY barang.id_barang ASC");
					while($r=mysqli_fetch_array($tampil)){
					$hargarp=format_rupiah($r[harga_beli]);
					$biaya_simpan=($r[biaya_simpan]/100)*$r[harga_jual];
					$biaya_simpanrp=format_rupiah($biaya_simpan);
					$harga_beli=format_rupiah($r[harga_beli]);
					$harga_jual=format_rupiah($r[harga_jual]);
					$eoq=round($r[eoq]);
					echo"
                        <tr>
                            <td>$no</td>
                            <td>$r[id_barang]</td>
                            <td>$r[nama_merek] $r[nama_barang]</td>
							<td >$r[nama_variasi_ukuran]</td>							
							<td >Rp. $biaya_simpanrp ($r[biaya_simpan]% dari Rp. $harga_jual)</td>
							<td >Rp. $harga_beli</td>
							<td >$eoq</td>
                        </tr>";
						$no++;
						}
						echo"
            </tbody>
        </table>";
        if ($cetak=='0') {
        	echo"
		<a href=modul/mod_laporan/cetakverifikasi.php?id=$_GET[id] target='_blank' class='btn btn-success pull-left'><i class='fa fa-print'></i> Print</a><br><br>";
	}
	echo"
    </div>
</div>
      ";
break;
}
}
?>
