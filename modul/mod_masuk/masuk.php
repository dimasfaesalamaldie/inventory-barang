<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{

$aksi="modul/mod_masuk/aksi_masuk.php";
switch($_GET[act]){
  // Tampil User
  default:
  echo"
  
<div class='card shadow-sm mb-4 border-bottom-primary'>
    <div class='card-header bg-white py-3'>
        <div class='row'>
            <div class='col'>
                <h4 class='h5 align-middle m-0 font-weight-bold text-primary'>
                    Data Barang Masuk
                </h4>
            </div>
            <div class='col-auto'>
                <a href='?module=masuk&act=tambahmasuk' class='btn btn-sm btn-primary btn-icon-split'>
                    <span class='icon'>
                        <i class='fa fa-user-plus'></i>
                    </span>
                    <span class='text'>
                        Tambah Barang Masuk
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
                    <th>ID Barang Masuk</th>
					<th>Supplier</th>
                    <th>Barang</th>
					<th>Tanggal Masuk</th>
					<th>User</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>";
					$tampil = mysqli_query($konek,"SELECT * FROM barang_masuk JOIN supplier ON barang_masuk.id_supplier=supplier.id_supplier
																			  JOIN user ON barang_masuk.id_user=user.id_user
									                                           JOIN detail_masuk ON barang_masuk.id_barang_masuk=detail_masuk.id_barang_masuk
                                                                               JOIN detail_barang ON detail_masuk.id_detail_barang=detail_barang.id_detail_barang
                                                                               
                                                                               JOIN barang ON barang.id_barang=detail_barang.id_barang
                                                                               JOIN merek ON barang.id_merek=merek.id_merek
                                                                               JOIN variasi_ukuran ON detail_barang.id_variasi_ukuran=variasi_ukuran.id_variasi_ukuran
                                    										  ORDER BY barang_masuk.id_barang_masuk ASC");
					$no=1;
					while ($r=mysqli_fetch_array($tampil)){
					$tanggal=tgl_indo($r[tanggal_masuk]);
					echo"
                        <tr>
                            <td>$no</td>
                            <td>$r[id_barang_masuk]</td>
							<td>$r[nama_supplier]</td>
                            <td>$r[nama_merek] $r[nama_barang] $r[nama_variasi_ukuran]</td>
							<td>$tanggal</td>
							<td>$r[nama]</td>
                            <td>
                                <a href='?module=masuk&act=detailmasuk&kode=$r[id_barang_masuk]' class='btn btn-circle btn-sm btn-warning'><i class='fa fa-fw fa-folder'></i></a>
                                <a onClick=\"return confirm('Apakah Anda Yakin Untuk Menghapus Data Ini ?')\" href='$aksi?module=masuk&act=hapus&id=$r[id_barang_masuk]' class='btn btn-circle btn-sm btn-danger'><i class='fa fa-fw fa-trash'></i></a>
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
  
  case "tambahmasuk":
    $sql=mysqli_query($konek,"select * from barang_masuk order by id_barang_masuk DESC LIMIT 0,1");
	$data=mysqli_fetch_array($sql);
	$kodeawal=substr($data['id_barang_masuk'],7,5)+1;
	if($kodeawal<10){
		$kode = 'TBM-00000'.$kodeawal;
	}elseif($kodeawal > 9 && $kodeawal <=99){
		$kode='TBM-0000'.$kodeawal;
	}else{
		$kode='TBM-000'.$kodeawal;
	} 
	$tgl_sekarang = date("Y-m-d");
   echo"
   	<div class='row justify-content-center'>
    <div class='col-md-8'>
        <div class='card shadow-sm mb-4 border-bottom-primary'>
            <div class='card-header bg-white py-3'>
                <div class='row'>
                    <div class='col'>
                        <h4 class='h5 align-middle m-0 font-weight-bold text-primary'>
                            Form Tambah Barang Masuk
                        </h4>
                    </div>
                    </div>
            </div>
            <div class='card-body pb-2'>
			  <form method=POST action='$aksi?module=masuk&act=tambah'>
                <div class='row form-group'>
                    <label class='col-md-4 text-md-right' for='nama'>ID Barang Masuk</label>
                    <div class='col-md-6'>
                        <input type='text' id='nama' name='id_barang_masuk' value='$kode' class='form-control' placeholder='Nama masuk' readonly>
                    </div>
                </div>
				<div class='row form-group'>
                    <label class='col-md-4 text-md-right' for='merek_id'>Supplier</label>
                    <div class='col-md-6'>
						<div class='input-group'>
                        <select class='custom-select' name='supplier' required>
							<option value=0 selected>- Pilih Supplier -</option>";
								$tampil=mysqli_query($konek,"SELECT * FROM supplier ORDER BY nama_supplier ASC");
								while($r=mysqli_fetch_array($tampil)){
									echo "<option value=$r[id_supplier]>$r[nama_supplier]</option>";
								}
						echo "</select>
						<div class='input-group-append'>
                           <a class='btn btn-primary' href=media.php?module=merek&act=tambahsupplier><i class='fa fa-plus'></i></a>
                        </div>
						</div>
                    </div>
                </div>
				<div class='row form-group'>
                    <label class='col-md-4 text-md-right' for='nama'>Tanggal Masuk</label>
                    <div class='col-md-6'>
                        <input type='date' id='nama' name='tanggal_masuk' value='$tgl_sekarang' class='form-control' placeholder='Tanggal masuk' required>
                    </div>
                </div>
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
</div>";
     break;
	case "transaksimasuk":
	$supplier=mysqli_query($konek,"SELECT * FROM supplier JOIN barang_masuk ON supplier.id_supplier=barang_masuk.id_supplier 
														  AND barang_masuk.id_barang_masuk='$_GET[kode]'");
    $p=mysqli_fetch_array($supplier);
	$tanggal=tgl_indo($p[tanggal_masuk]);
   echo"
   	<div class='row left-content-center'>
    <div class='col-md-6'>
        <div class='card shadow-sm mb-4 border-bottom-primary'>
            <div class='card-header bg-white py-3'>
                <div class='row'>
                    <div class='col'>
                        <h4 class='h5 align-middle m-0 font-weight-bold text-primary'>
                            Form Tambah Barang Masuk
                        </h4>
                    </div>
                    </div>
            </div>
            <div class='card-body pb-2'>
			  <form method=POST action='$aksi?module=masuk&act=input'>
			  <input type=hidden name='id_supplier' value='$r[id_supplier]'>
			  <input type=hidden name='id_barang_masuk' value='$_GET[kode]'>
				<div class='row form-group'>
                    <label class='col-md-4 text-md-right' for='merek_id'>Barang</label>
                    <div class='col-md-6'>
						<div class='input-group'>
                        <select class='form-control select2' name='barang' required>
							<option value=0 selected>- Pilih Barang -</option>";
								$tampil=mysqli_query($konek,"SELECT * FROM barang JOIN merek ON barang.id_merek=merek.id_merek 
																				  JOIN detail_barang ON detail_barang.id_barang=barang.id_barang
																				  JOIN variasi_ukuran ON variasi_ukuran.id_variasi_ukuran=detail_barang.id_variasi_ukuran
																				  ORDER BY detail_barang.id_detail_barang ASC");
								while($r=mysqli_fetch_array($tampil)){
									echo "<option value=$r[id_detail_barang]>$r[id_barang] | $r[nama_merek] $r[nama_barang]  $r[nama_variasi_ukuran]</option>";
								}
						echo "</select>
						</div>
                    </div>
                </div>
				<div class='row form-group'>
                    <label class='col-md-4 text-md-right' for='nama'>Jumlah</label>
                    <div class='col-md-6'>
                        <input type='number' id='nama' name='jumlah' min='0' class='form-control' placeholder='Jumlah Barang' required>
                    </div>
                </div>
				<div class='row form-group'>
                    <label class='col-md-4 text-md-right' for='nama'>Harga Beli</label>
                    <div class='col-md-6'>
                        <input type='number' name='harga_beli' min='0' class='form-control' placeholder='Harga Beli' required>
                    </div>
                </div>
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
	
	
	
	<div class='col-md-6'>
        <div class='card shadow-sm mb-4 border-bottom-primary'>
            <div class='card-header bg-white py-3'>
                <div class='row'>
                    <div class='col'>
                        <h4 class='h5 align-middle m-0 font-weight-bold text-primary'>
                            Transaksi Masuk $_GET[kode]
                        </h4>
                    </div>
                </div>
            </div>
            <div class='card-body pb-2'>
				<div class='row form-group'>
                    <label class='col-md-4 text-md-right' for='nama'>Supplier</label>
                    <div class='col-md-6'>
                        <input type='text' id='nama' class='form-control' value='$p[nama_supplier]' readonly>
                    </div>
                </div>
				<div class='row form-group'>
                    <label class='col-md-4 text-md-right' for='nama'>Tanggal</label>
                    <div class='col-md-6'>
                        <input type='text' id='nama' class='form-control' value='$tanggal' readonly>
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
                    Data Barang Masuk
                </h4>
            </div>
        </div>
    </div>
    <div class='table-responsive'>
        <table class='table table-striped dt-responsive nowrap' id='dataTable'>
            <thead>
                <tr>
                    <th width='30'>No.</th>
					<th>Barang</th>
					<th>variasi ukuran</th>
					<th>Harga Beli</th>
					<th>Jumlah</th>
					<th>Sub Total</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>";
					$no=1;
					$tampil = mysqli_query($konek,"SELECT barang.id_barang,barang.nama_barang,detail_masuk.harga_beli,variasi_ukuran.nama_variasi_ukuran,detail_masuk.jumlah,detail_masuk.id_detail_masuk, merek.nama_merek FROM detail_masuk 
																			  JOIN detail_barang ON detail_masuk.id_detail_barang=detail_barang.id_detail_barang
																			  JOIN barang ON detail_barang.id_barang=barang.id_barang
																			  JOIN variasi_ukuran ON detail_barang.id_variasi_ukuran=variasi_ukuran.id_variasi_ukuran
																			  JOIN merek ON barang.id_merek=merek.id_merek
																			  WHERE detail_masuk.id_barang_masuk='$_GET[kode]'");
							while ($r=mysqli_fetch_array($tampil)){
							$jml=$r[jumlah];
							$harga=$r[harga_beli];
							$subtotal=$jml*$harga;
							$total       = $total + $subtotal;
							$total_rp    = format_rupiah($total);
							$subtotal_rp = format_rupiah($subtotal);
							$harga_rp       = format_rupiah($harga);
					echo"
                        <tr>
                            <td>$no</td>
                            <td>$r[id_barang] : $r[nama_merek] $r[nama_barang]</a></td>
							<td>$r[nama_variasi_ukuran]</td>
							<td>Rp. $harga_rp</td>		         
							<td>$r[jumlah]</td>
							<td>Rp. $subtotal_rp</td>
							<td><a href=$aksi?module=masuk&act=delete&kode=$r[id_detail_masuk] class='btn btn-danger' onClick=\"return confirm('Apakah Anda Yakin Untuk Menghapus Data Ini ?')\">Hapus</a></td>
                            
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
		<div class='col-auto'>
                        <a href='?module=masuk' class='btn btn-sm btn-secondary btn-icon-split'>
                            <span class='icon'>
                                <i class='fa fa-arrow-left'></i>
                            </span>
                            <span class='text'>
                                Selesai
                            </span>
                        </a>
                    </div><br>
    </div>
					
</div>";
     break;
	 
	 case "detailmasuk":
	$supplier=mysqli_query($konek,"SELECT * FROM supplier JOIN barang_masuk ON supplier.id_supplier=barang_masuk.id_supplier 
														JOIN user ON user.id_user=barang_masuk.id_user
                                                        WHERE barang_masuk.id_barang_masuk='$_GET[kode]'");
    $p=mysqli_fetch_array($supplier);
	$tanggal=tgl_indo($p[tanggal_masuk]);
   echo"
<div class='row left-content-center'>
	<div class='col-md-6'>
        <div class='card shadow-sm mb-4 border-bottom-primary'>
            <div class='card-header bg-white py-3'>
                <div class='row'>
                    <div class='col'>
                        <h4 class='h5 align-middle m-0 font-weight-bold text-primary'>
                            Detail Barang Masuk
                        </h4>
                    </div>
					</div>
            </div>
            <div class='card-body pb-2'>
				<div class='row form-group'>
                    <label class='col-md-4 text-md-right' for='nama'>ID Barang Masuk</label>
                    <div class='col-md-6'>
                        <input type='text' id='nama' class='form-control' value=' $_GET[kode]' readonly>
                    </div>
                </div>
                <div class='row form-group'>
                    <label class='col-md-4 text-md-right' for='nama'>Supplier</label>
                    <div class='col-md-6'>
                        <input type='text' id='nama' class='form-control' value='$p[nama_supplier]' readonly>
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
                        <input type='text' id='nama' class='form-control' value='$p[nama]' readonly>
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
					<th>Barang</th>
					<th>Variasi Ukuran</th>
					<th>Harga satuan</th>
					<th>Jumlah</th>
					<th>Sub Total</th>
                </tr>
            </thead>
            <tbody>";
					$no=1;
					$tampil = mysqli_query($konek,"SELECT barang.id_barang,barang.nama_barang,detail_masuk.harga_beli,variasi_ukuran.nama_variasi_ukuran,detail_masuk.jumlah,detail_masuk.id_detail_masuk, merek.nama_merek FROM detail_masuk 
                                                                              JOIN detail_barang ON detail_masuk.id_detail_barang=detail_barang.id_detail_barang
                                                                              JOIN barang ON detail_barang.id_barang=barang.id_barang
                                                                              JOIN variasi_ukuran ON detail_barang.id_variasi_ukuran=variasi_ukuran.id_variasi_ukuran
                                                                              JOIN merek ON barang.id_merek=merek.id_merek
                                                                              WHERE detail_masuk.id_barang_masuk='$_GET[kode]'");
							while ($r=mysqli_fetch_array($tampil)){
							$jml=$r[jumlah];
							$harga=$r[harga_beli];
							$subtotal=$jml*$harga;
							$total       = $total + $subtotal;
							$total_rp    = format_rupiah($total);
							$subtotal_rp = format_rupiah($subtotal);
							$harga_rp       = format_rupiah($harga);
					echo"
                        <tr>
                            <td>$no</td>
                            <td>$r[id_barang] | $r[nama_merek] $r[nama_barang]</a></td>
							<td>$r[nama_variasi_ukuran]</td>
							<td>Rp. $harga_rp</td>		         
							<td>$r[jumlah]</td>
							<td>Rp. $subtotal_rp</td>
                        </tr>";
						$no++;
						}
						echo"
						<tr>
							<td colspan=5 align=right>Total :  </td>
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
