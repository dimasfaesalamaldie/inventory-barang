<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{

$aksi="modul/mod_keluar/aksi_keluar.php";
switch($_GET[act]){
  // Tampil User
  default:
  echo"
  
<div class='card shadow-sm mb-4 border-bottom-primary'>
    <div class='card-header bg-white py-3'>
        <div class='row'>
            <div class='col'>
                <h4 class='h5 align-middle m-0 font-weight-bold text-primary'>
                    Data Barang Keluar
                </h4>
            </div>
            
        </div>
    </div>
    <div class='table-responsive'>
        <table class='table table-striped dt-responsive nowrap' id='dataTable'>
            <thead>
                <tr>
                    <th width='30'>No.</th>
                    <th>ID Barang Keluar</th>
					<th>Pelanggan</th>
					<th>Tanggal Keluar</th>
					<th>User</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>";
					$tampil = mysqli_query($konek,"SELECT * FROM barang_keluar JOIN user ON barang_keluar.id_user=user.id_user
																			  ORDER BY barang_keluar.id_barang_keluar ASC");
					$no=1;
					while ($r=mysqli_fetch_array($tampil)){
					$tanggal=tgl_indo($r[tanggal_keluar]);
					echo"
                        <tr>
                            <td>$no</td>
                            <td>$r[id_barang_keluar]</td>
							<td>$r[nama_pelanggan]</td>
							<td>$tanggal</td>
							<td>$r[nama]</td>
                            <td>
                                <a href='?module=keluar&act=detailkeluar&id=$r[id_barang_keluar]' class='btn btn-circle btn-sm btn-warning'><i class='fa fa-fw fa-folder'></i></a>
                                <a onClick=\"return confirm('Apakah Anda Yakin Untuk Menghapus Data Ini ?')\" href='$aksi?module=keluar&act=hapus&id=$r[id_barang_keluar]' class='btn btn-circle btn-sm btn-danger'><i class='fa fa-fw fa-trash'></i></a>
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
  
  
   case "tambahkeluar":
   $tgl_sekarang = date("Y-m-d");
   echo"
<div class='row left-content-center'>
    <div class='col-md-12'>
        <div class='card shadow-sm mb-4 border-bottom-primary'>
            <div class='card-header bg-white py-3'>
                <div class='row'>
                    <div class='col'>
                        <h4 class='h5 align-middle m-0 font-weight-bold text-primary'>
                            Form Tambah Barang Keluar
                        </h4>
                    </div>
                    
                </div>
            </div>
            <div class='card-body pb-2'>
			  <form method=POST action='aksi.php?module=keranjang&act=tambah'>";
			  echo'
				<table id="dynamic-table" class="table table-striped table-bordered table-hover">
					<tr>
						<td>
							<label for="exampleInputPassword1">Cari Barang</label><br>
							<select class="form-control select2" id="barang2" name="prdId" onchange="changeValue(this.value)" required>';
												$tampil = mysqli_query($konek,"SELECT * FROM barang JOIN detail_barang ON barang.id_barang=detail_barang.id_barang
																									JOIN variasi_ukuran ON detail_barang.id_variasi_ukuran=variasi_ukuran.id_variasi_ukuran 
                                                                                                    JOIN merek ON barang.id_merek=merek.id_merek
																									ORDER BY barang.id_barang ASC");
												$jsArray = "var prdName = new Array();\n";
												echo "<option>-- Pilih Barang --</option>";
												while ($row = mysqli_fetch_array($tampil)) {
										echo '<option value="' . $row['id_detail_barang'] . '">' . $row['id_barang'] . ' | ' . $row['nama_merek'] . '  ' . $row['nama_barang'] . '  ' . $row['nama_variasi_ukuran'] . '</option>';  
										$jsArray .= "prdName['" . $row['id_detail_barang'] . "'] = {nama_barang:'" . addslashes($row['nama_barang']) . "',harga_jual:'".addslashes($row['harga_jual'])."',barang:'".addslashes($row['id_barang'])."',stok:'".addslashes($row['stok'])."',detail:'".addslashes($row['id_detail_barang'])."'};\n";  
										}	
											echo"</select>
							<input type='hidden' name='prod_barang' id='prd_barang'/>
							<input class='form-control' type='hidden' name='prod_nama_barang' id='prd_nama_barang' required readonly>
						</td>
						<td>
							<label for='exampleInputPassword1'>Stok</label>
							<input type='number' name='prod_stok' class='form-control' id='prd_stok' placeholder='Stok Barang' readonly>
						</td>
						<td>
							<label for='exampleInputPassword1'>Harga</label>
							<input type='number' name='prod_harga_jual' class='form-control' id='prd_harga_jual' placeholder='Harga Jual' readonly>
						</td>
						<td>
							<label for='exampleInputPassword1'>Jumlah</label>
							<input type='number' min='1' name='jml' class='form-control' id='exampleInputPassword1' placeholder='Masukkan Jumlah Barang' onkeypress='return hanyaAngka(event)' required>
						</td>
					</tr>
				</table>
                <div class='row form-group justify-content-end'>
                    <div class='col-md-8'>
                        <button type='submit' class='btn btn-primary btn-icon-split'>
                            <span class='icon'><i class='fa fa-save'></i></span>
                            <span class='text'>Simpan</span>
                        </button>
                        <button type='reset' class='btn btn-secondary'>
                            Reset
                        </button>
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
                    Data Barang Keluar
                </h4>
            </div>
        </div>
    </div>
    <div class='table-responsive'>
	<form method=post action=aksi.php?module=keranjang&act=update>
        <table class='table table-striped dt-responsive nowrap' id='dataTable'>
            <thead>
                <tr>
                    <th width='30'>No.</th>
					<th>Barang</th>
					<th>Variasi Ukuran</th>
					<th>Harga</th>
					<th>Jumlah</th>
					<th>Sub Total</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>";
					$no=1;
					$sid = session_id();
					$tampil = mysqli_query($konek,"SELECT * FROM keranjang JOIN detail_barang ON keranjang.id_detail_barang=detail_barang.id_detail_barang
																		   JOIN barang ON barang.id_barang=detail_barang.id_barang
																		   JOIN variasi_ukuran ON detail_barang.id_variasi_ukuran=variasi_ukuran.id_variasi_ukuran
																		   JOIN merek ON barang.id_merek=merek.id_merek
																		   WHERE id_session='$sid'");
							while ($r=mysqli_fetch_array($tampil)){
							$jml=$r[jumlah];
							$harga=$r[harga_jual];
							$subtotal=$jml*$harga;
							$total       = $total + $subtotal;
							$total_rp    = format_rupiah($total);
							$subtotal_rp = format_rupiah($subtotal);
							$harga_rp       = format_rupiah($harga);
					echo"
                        <tr>
                            <td><input type=hidden name=id[$no] value=$r[id_keranjang]>$no</td>
                            <td>$r[id_barang] | $r[nama_merek] $r[nama_barang]</a></td>
							<td>$r[nama_variasi_ukuran]</td>
							<td>Rp. $harga_rp</td>		         
							<td><input type='number' name='jml[$no]' value=$r[jumlah] class='form-control' onkeypress='return hanyaAngka(event)' onChange='this.form.submit()'></td>
							<td>Rp. $subtotal_rp</td>
							<td><a href=aksi.php?module=keranjang&act=hapus&id=$r[id_keranjang] class='btn btn-danger' onClick=\"return confirm('Apakah Anda Yakin Untuk Menghapus Data Ini ?')\">Hapus</a></td>
                            
                        </tr>";
						$no++;
						}
						echo"
						<tr>
							<td colspan=6 align=right>Total :  </td>
							<td align=left><b>Rp. $total_rp</b></td>
						</tr>
            </tbody>
        </table>
		</form>
    </div>
</div>";
echo"
<div class='row left-content-center'>
    <div class='col-md-6'>
        <div class='card shadow-sm mb-4 border-bottom-primary'>
            <div class='card-header bg-white py-3'>
                <div class='row'>
                    <div class='col'>
                        <h4 class='h5 align-middle m-0 font-weight-bold text-primary'>
                            Form Transaksi Barang Keluar
                        </h4>
                    </div>
                </div>
            </div>
            <div class='card-body pb-2'>
			  <form method=POST action='$aksi?module=keluar&act=input'>
                <div class='row form-group'>
                    <label class='col-md-4 text-md-right' for='nama'>Nama Pelanggan</label>
                    <div class='col-md-6'>
                        <input type='text' id='nama' name='nama_pelanggan' class='form-control' placeholder='Nama Pelanggan' required>
                    </div>
                </div>
				<div class='row form-group'>
                    <label class='col-md-4 text-md-right' for='nama'>Umur</label>
                    <div class='col-md-6'>
                        <input type='number' min='0' id='nama' name='umur' class='form-control' placeholder='Umur Pelanggan' required>
                    </div>
                </div>
				<div class='row form-group'>
                    <label class='col-md-4 text-md-right' for='nama'>Tanggal Keluar</label>
                    <div class='col-md-6'>
                        <input type='date' id='nama' name='tanggal_keluar' value='$tgl_sekarang' class='form-control' placeholder='Tanggal Keluar' required>
                    </div>
                </div>
                <div class='row form-group justify-content-end'>
                    <div class='col-md-8'>
                        <button type='submit' class='btn btn-primary btn-icon-split'>
                            <span class='icon'><i class='fa fa-save'></i></span>
                            <span class='text'>Selesai</span>
                        </button>
                    </div>
                </div>
			  </form>
            </div>
        </div>
    </div>
</div>";
     break;
	 
	case "detailkeluar":
	$keluar=mysqli_query($konek,"SELECT * FROM barang_keluar JOIN user ON barang_keluar.id_user=user.id_user 
															 WHERE barang_keluar.id_barang_keluar='$_GET[id]'");
    $k=mysqli_fetch_array($keluar);
	$tanggal=tgl_indo($k[tanggal_keluar]);
   echo"
<div class='row left-content-center'>
	<div class='col-md-6'>
        <div class='card shadow-sm mb-4 border-bottom-primary'>
            <div class='card-header bg-white py-3'>
                <div class='row'>
                    <div class='col'>
                        <h4 class='h5 align-middle m-0 font-weight-bold text-primary'>
                            Detail Transaksi Keluar $_GET[id]
                        </h4>
                    </div>
					</div>
            </div>
            <div class='card-body pb-2'>
				<div class='row form-group'>
                    <label class='col-md-4 text-md-right' for='nama'>Pelanggan</label>
                    <div class='col-md-6'>
                        <input type='text' id='nama' class='form-control' value='$k[nama_pelanggan]' readonly>
                    </div>
                </div>
                <div class='row form-group'>
                    <label class='col-md-4 text-md-right' for='nama'>Umur</label>
                    <div class='col-md-6'>
                        <input type='text' id='nama' class='form-control' value='$k[umur] Tahun' readonly>
                    </div>
                </div>
				<div class='row form-group'>
                    <label class='col-md-4 text-md-right' for='nama'>Tanggal</label>
                    <div class='col-md-6'>
                        <input type='text' id='nama' class='form-control' value='$tanggal' readonly>
                    </div>
                </div>
				<div class='row form-group'>
                    <label class='col-md-4 text-md-right' for='nama'>Penanggung Jawab</label>
                    <div class='col-md-6'>
                        <input type='text' id='nama' class='form-control' value='$k[nama]' readonly>
                    </div>
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
                    Data Barang Keluar
                </h4>
            </div>
        </div>
    </div>
    <div class='table-responsive'>
        <table class='table table-striped dt-responsive nowrap' id='dataTable'>
            <thead>
                <tr>
                    <th width='30'>#</th>
					<th>Id Barang</th>
					<th>Barang</th>
					<th>Variasi Ukuran</th>
					<th>Harga Jual</th>
					<th>Jumlah</th>
					<th>Sub Total</th>
                </tr>
            </thead>
            <tbody>";
					$no=1;
					$tampil = mysqli_query($konek,"SELECT * FROM detail_keluar JOIN detail_barang ON detail_keluar.id_detail_barang=detail_barang.id_detail_barang
																			  JOIN barang ON barang.id_barang=detail_barang.id_barang
																			  JOIN variasi_ukuran ON detail_barang.id_variasi_ukuran=variasi_ukuran.id_variasi_ukuran
																			  JOIN merek ON barang.id_merek=merek.id_merek
																			  WHERE detail_keluar.id_barang_keluar='$_GET[id]'");
							while ($r=mysqli_fetch_array($tampil)){
							$jml=$r[jumlah];
							$harga=$r[harga];
							$subtotal=$jml*$harga;
							$total       = $total + $subtotal;
							$total_rp    = format_rupiah($total);
							$subtotal_rp = format_rupiah($subtotal);
							$harga_rp       = format_rupiah($harga);
					echo"
                        <tr>
                            <td>$no</td>
                            <td>$r[id_barang]</a></td>
							<td>$r[nama_merek] $r[nama_barang]</td>
							<td>$r[nama_variasi_ukuran]</td>
							<td>Rp. $harga_rp</td>		         
							<td>$r[jumlah]</td>
							<td>Rp. $subtotal_rp</td>
                        </tr>";
						$no++;
						}
						echo"
						<tr>
							<td colspan=6 align=right>Total :  </td>
							<td align=left><b>Rp. $total_rp</b></td>
						</tr>
            </tbody>
        </table>
    </div>
</div>";

     break;
      
}
}
?>
<script type="text/javascript">  
<?php echo $jsArray; ?>
function changeValue(id){
document.getElementById('prd_barang').value = prdName[id].detail;
document.getElementById('prd_nama_barang').value = prdName[id].nama_barang;
document.getElementById('prd_harga_jual').value = prdName[id].harga_jual;
document.getElementById('prd_stok').value = prdName[id].stok;
};
</script>