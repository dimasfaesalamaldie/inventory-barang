<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{

$aksi="modul/mod_supplier/aksi_supplier.php";
switch($_GET[act]){
  // Tampil User
  default:
  echo"
  
<div class='card shadow-sm mb-4 border-bottom-primary'>
    <div class='card-header bg-white py-3'>
        <div class='row'>
            <div class='col'>
                <h4 class='h5 align-middle m-0 font-weight-bold text-primary'>
                    Data Supplier
                </h4>
            </div>
            <div class='col-auto'>
                <a href='?module=supplier&act=tambahsupplier' class='btn btn-sm btn-primary btn-icon-split'>
                    <span class='icon'>
                        <i class='fa fa-user-plus'></i>
                    </span>
                    <span class='text'>
                        Tambah Supplier
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
                    <th>Nama Supplier</th>
					<th>No. Telp</th>
					<th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>";
					$tampil = mysqli_query($konek,"SELECT * FROM supplier ORDER BY id_supplier ASC");
					$no=1;
					while ($r=mysqli_fetch_array($tampil)){
					echo"
                        <tr>
                            <td>$no</td>
                            <td>$r[nama_supplier]</td>
							<td>$r[no_telp]</td>
							<td>$r[alamat]</td>
                            <td>
                                <a href='?module=supplier&act=editsupplier&id=$r[id_supplier]' class='btn btn-circle btn-sm btn-warning'><i class='fa fa-fw fa-edit'></i></a>
                                <a onClick=\"return confirm('Apakah Anda Yakin Untuk Menghapus Data Ini ?')\" href='$aksi?module=supplier&act=hapus&id=$r[id_supplier]' class='btn btn-circle btn-sm btn-danger'><i class='fa fa-fw fa-trash'></i></a>
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
  
  case "tambahsupplier":
    
   echo"
   	<div class='row justify-content-center'>
    <div class='col-md-8'>
        <div class='card shadow-sm mb-4 border-bottom-primary'>
            <div class='card-header bg-white py-3'>
                <div class='row'>
                    <div class='col'>
                        <h4 class='h5 align-middle m-0 font-weight-bold text-primary'>
                            Form Tambah Supplier
                        </h4>
                    </div>
                    <div class='col-auto'>
                        <a href='?module=supplier' class='btn btn-sm btn-secondary btn-icon-split'>
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
			  <form method=POST action='$aksi?module=supplier&act=input'>
                <div class='row form-group'>
                    <label class='col-md-4 text-md-right' for='nama'>Nama Supplier</label>
                    <div class='col-md-6'>
                        <input type='text' id='nama' name='nama_supplier' class='form-control' placeholder='Nama supplier' required>
                    </div>
                </div>
				<div class='row form-group'>
                    <label class='col-md-4 text-md-right' for='nama'>No. Telp</label>
                    <div class='col-md-6'>
                        <input type='number' min='0' id='nama' name='no_telp' class='form-control' placeholder='No. Telp' required>
                    </div>
                </div>
				<div class='row form-group'>
                    <label class='col-md-4 text-md-right' for='nama'>Alamat</label>
                    <div class='col-md-6'>
                        <input type='text' id='nama' name='alamat' class='form-control' placeholder='Alamat Supplier' required>
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
    
  case "editsupplier":
    $edit=mysqli_query($konek,"SELECT * FROM supplier WHERE id_supplier='$_GET[id]'");
    $r=mysqli_fetch_array($edit);
	echo"
   	<div class='row justify-content-center'>
    <div class='col-md-8'>
        <div class='card shadow-sm mb-4 border-bottom-primary'>
            <div class='card-header bg-white py-3'>
                <div class='row'>
                    <div class='col'>
                        <h4 class='h5 align-middle m-0 font-weight-bold text-primary'>
                            Form Edit Supplier
                        </h4>
                    </div>
                    <div class='col-auto'>
                        <a href='?module=supplier' class='btn btn-sm btn-secondary btn-icon-split'>
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
			  <form method=POST action=$aksi?module=supplier&act=update>
              <input type=hidden name=id value='$r[id_supplier]'>
                <div class='row form-group'>
                    <label class='col-md-4 text-md-right' for='nama'>Nama Supplier</label>
                    <div class='col-md-6'>
                        <input type='text' id='nama' name='nama_supplier' class='form-control' placeholder='Nama supplier' value='$r[nama_supplier]' required>
                    </div>
                </div>
				<div class='row form-group'>
                    <label class='col-md-4 text-md-right' for='nama'>No. Telp</label>
                    <div class='col-md-6'>
                        <input type='number' min='0' id='nama' name='no_telp' class='form-control' placeholder='No. Telp' value='$r[no_telp]' required>
                    </div>
                </div>
				<div class='row form-group'>
                    <label class='col-md-4 text-md-right' for='nama'>Alamat</label>
                    <div class='col-md-6'>
                        <input type='text' id='nama' name='alamat' class='form-control' placeholder='Alamat Supplier' value='$r[alamat]' required>
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
}
}
?>
