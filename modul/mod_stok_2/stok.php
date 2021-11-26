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
  mysqli_query($konek,"DELETE FROM safety_stock");
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
								<th>Lead Time</th>
								<th>Stok</th>
								<th>Rerata</th>
								<th>Status</th>
							</tr>
						</thead>
						<tbody>";
						$tampil = mysqli_query($konek,"SELECT * FROM barang JOIN detail_masuk ON barang.id_barang=detail_masuk.id_barang GROUP BY barang.id_barang ORDER BY barang.id_barang ASC");
						$no=1;
						while ($r=mysqli_fetch_array($tampil)){
						$barang=$r[id_barang];
						$stok=$r[stok];
						$harga_rp    = format_rupiah($r[harga_jual]);
						$simpan=$r[biaya_simpan];
						$biaya_pesanrp=format_rupiah($r[biaya_pesan]);
						$biaya_simpan=($r[biaya_simpan]/100)*$r[harga_jual];
						$biaya_simpanrp=format_rupiah($biaya_simpan);
						$biaya_pesan=$r[biaya_pesan];
						$lead=$r[lead_time];
						$lead_time=round(($lead/30),3);
						$cariperiode1=mysqli_query($konek,"SELECT * FROM barang_masuk,detail_masuk WHERE barang_masuk.id_barang_masuk=detail_masuk.id_barang_masuk AND detail_masuk.id_barang='$barang' ORDER BY barang_masuk.tanggal_masuk ASC");
						$pr1=mysqli_fetch_array($cariperiode1);
						$tgl_mulai=$pr1[tanggal_masuk];
						$cariperiode2=mysqli_query($konek,"SELECT * FROM barang_keluar,detail_keluar WHERE barang_keluar.id_barang_keluar=detail_keluar.id_barang_keluar AND detail_keluar.id_barang='$barang' ORDER BY barang_keluar.tanggal_keluar DESC");
						$pr2=mysqli_fetch_array($cariperiode2);
						$tgl_selesai=$pr2[tanggal_keluar];
						//convert
						$timeStart = strtotime($tgl_mulai);
						$timeEnd = strtotime($tgl_selesai);
 
						// Menambah bulan ini + semua bulan pada tahun sebelumnya
						$periode = 12;
 
 

	$hari=$periode*30;
	$caritotal=mysqli_query($konek,"SELECT SUM(detail_keluar.jumlah) AS total_jual FROM barang_keluar,detail_keluar WHERE barang_keluar.id_barang_keluar=detail_keluar.id_barang_keluar AND detail_keluar.id_barang='$barang'");
    $ct=mysqli_fetch_array($caritotal);
	$total_jual=$ct[total_jual];
	$rata_jual=($total_jual/$periode);
	$eoq=sqrt((2*$biaya_pesan*$total_jual)/$biaya_simpan);
	$carimaxp=mysqli_query($konek,"SELECT SUM(detail_keluar.jumlah) AS jumlah FROM barang_keluar,detail_keluar WHERE barang_keluar.id_barang_keluar=detail_keluar.id_barang_keluar AND detail_keluar.id_barang='$barang' GROUP BY YEAR(barang_keluar.tanggal_keluar), MONTH(barang_keluar.tanggal_keluar) ORDER BY jumlah DESC");
    $cm=mysqli_fetch_array($carimaxp);
	$maxp=$cm[jumlah];
	$ss=($maxp-$rata_jual)*$lead;
	$ss2=round(($ss),0);
	$rop=($lead*($total_jual/$hari))+$ss;
	$rop2=round(($rop),0);
	$mi=$ss+$eoq;
	$mi2=round(($mi),0);
	mysqli_query($konek,"INSERT INTO safety_stock(id_barang,
												  terjual,
									              max,
												  rerata,
												  leadtime,
												  stock,
												  safety_stock,
												  rop,
												  eoq,
												  status) 
										VALUES ('$barang',
												'$total_jual',
												'$maxp',
												'$rata_jual',
												'$lead',
												'$stok',
												'$ss2',
												'$rop2',
												'$eoq',
												'$status')");
				$k = mysqli_fetch_array(mysqli_query($konek,"SELECT * FROM barang JOIN safety_stock ON barang.id_barang=safety_stock.id_barang
																	  WHERE barang.id_barang='$barang'"));
					
					$rata=$k[rerata];
					$persediaan=$k[stock];
					if ($persediaan < $rata) {
					$statusbarang='Unsafe';
					}
					else {
					$statusbarang='Safe';
					}
					mysqli_query($konek,"UPDATE safety_stock SET status  = '$statusbarang' WHERE id_barang = '$r[id_barang]'");
					echo"
                        <tr>
                            <td>$no</td>
                            <td>$r[nama_barang]</td>
                            <td>$k[leadtime]</td>
							<td>$k[stock]</td>
							<td>$k[rerata]</td>
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
				$cek = mysqli_query($konek,"SELECT * FROM barang JOIN safety_stock ON barang.id_barang=safety_stock.id_barang WHERE safety_stock.status='Unsafe' ORDER BY barang.id_barang ASC");
				$ketemu=mysqli_num_rows($cek);
				if ($ketemu > 0){
				echo"
                    <table class='table table-striped dt-responsive nowrap' id='dataTable2'>
						<thead>
							<tr>
								<th width='30'>No.</th>
								<th>Barang</th>
								<th>Terjual</th>
								<th>Max</th>
								<th>Rerata</th>
								<th>Stock</th>
								<th>ROP</th>
							</tr>
						</thead>
						<tbody>";
						$tampil = mysqli_query($konek,"SELECT * FROM barang JOIN safety_stock ON barang.id_barang=safety_stock.id_barang WHERE safety_stock.status='Unsafe' ORDER BY barang.id_barang ASC");
						$no=1;
						while ($r=mysqli_fetch_array($tampil)){
						echo"
                        <tr>
                            <td>$no<input type='checkbox' name='barang[]' value=$r[id_barang]</td>
                            <td>$r[id_barang]- $r[nama_barang]</td>
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
					<a href='?module=stok&act=verifikasiorder' class='btn-sm btn-success'> Verifikasi Order</a>";
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
					<th>Nama Barang</th>
					<th>Biaya Penyimpanan(% dari harga)</th>
					<th>Harga Beli</th>
                </tr>
            </thead>
            <tbody>";
					$tampil = mysqli_query($konek,"SELECT * FROM barang JOIN safety_stock ON barang.id_barang=safety_stock.id_barang WHERE safety_stock.status='Unsafe' ORDER BY barang.id_barang ASC");
					$no=1;
					while ($r=mysqli_fetch_array($tampil)){
					echo"
                        <tr>
                            <td>$no</td>
                            <td><input type='hidden' name='id_barang".$no."' value='$r[id_barang]'>$r[id_barang]</td>
							<td>$r[nama_barang]</td>
							<td><input name='a".$no."' type='number' min='0' class='form-control' placeholder='Isikan Biaya Penyimpanan' required></td>
							<td><input name='b".$no."' type='number' min='0' class='form-control' placeholder='Isikan Harga Beli' required></td>
                        </tr>";
						$no++;
						}
						echo"
            </tbody>
        </table><br>
		<button type='submit' class='btn btn-success'>Cetak</button><br>
	  </form>
    </div>
</div>
      ";
    break;	
}
}
?>
