<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{

$aksi="modul/mod_variasi_ukuran/aksi_variasi_ukuran.php";
switch($_GET[act]){
  // Tampil User
  default:
  echo"
  
<div class='card shadow-sm mb-4 border-bottom-primary'>
    <div class='card-header bg-white py-3'>
        <div class='row'>
            <div class='col'>
                <h4 class='h5 align-middle m-0 font-weight-bold text-primary'>
                    Variasi ukuran
                </h4>
            </div>
            <div class='col-auto'>
                <a href='?module=variasi_ukuran&act=tambahvariasi_ukuran' class='btn btn-sm btn-primary btn-icon-split'>
                    <span class='icon'>
                        <i class='fa fa-user-plus'></i>
                    </span>
                    <span class='text'>
                        Tambah Variasi ukuran
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
                    <th>Nama Variasi ukuran</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>";
					$tampil = mysqli_query($konek,"SELECT * FROM variasi_ukuran ORDER BY id_variasi_ukuran ASC");
					$no=1;
					while ($r=mysqli_fetch_array($tampil)){
					echo"
                        <tr>
                            <td>$no</td>
                            <td>$r[nama_variasi_ukuran]</td>
                            <td>
                                <a href='?module=variasi_ukuran&act=editvariasi_ukuran&id=$r[id_variasi_ukuran]' class='btn btn-circle btn-sm btn-warning'><i class='fa fa-fw fa-edit'></i></a>
                                <a onClick=\"return confirm('Apakah Anda Yakin Untuk Menghapus Data Ini ?')\" href='$aksi?module=variasi_ukuran&act=hapus&id=$r[id_variasi_ukuran]' class='btn btn-circle btn-sm btn-danger'><i class='fa fa-fw fa-trash'></i></a>
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
  
  case "tambahvariasi_ukuran":
    
   echo"
   	<div class='row justify-content-center'>
    <div class='col-md-8'>
        <div class='card shadow-sm mb-4 border-bottom-primary'>
            <div class='card-header bg-white py-3'>
                <div class='row'>
                    <div class='col'>
                        <h4 class='h5 align-middle m-0 font-weight-bold text-primary'>
                            Form Tambah Variasi ukuran
                        </h4>
                    </div>
                    <div class='col-auto'>
                        <a href='?module=variasi_ukuran' class='btn btn-sm btn-secondary btn-icon-split'>
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
			  <form method=POST action='$aksi?module=variasi_ukuran&act=input'>
                <div class='row form-group'>
                    <label class='col-md-4 text-md-right' for='nama'>Variasi ukuran</label>
                    <div class='col-md-6'>
                        <input type='text' id='nama' name='nama_variasi_ukuran' class='form-control' placeholder='Nama Variasi ukuran' required>
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
    
  case "editvariasi_ukuran":
    $edit=mysqli_query($konek,"SELECT * FROM variasi_ukuran WHERE id_variasi_ukuran='$_GET[id]'");
    $r=mysqli_fetch_array($edit);
	echo"
   	<div class='row justify-content-center'>
    <div class='col-md-8'>
        <div class='card shadow-sm mb-4 border-bottom-primary'>
            <div class='card-header bg-white py-3'>
                <div class='row'>
                    <div class='col'>
                        <h4 class='h5 align-middle m-0 font-weight-bold text-primary'>
                            Form Edit variasi_ukuran
                        </h4>
                    </div>
                    <div class='col-auto'>
                        <a href='?module=variasi_ukuran' class='btn btn-sm btn-secondary btn-icon-split'>
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
			  <form method=POST action=$aksi?module=variasi_ukuran&act=update>
              <input type=hidden name=id value='$r[id_variasi_ukuran]'>
                <div class='row form-group'>
                    <label class='col-md-4 text-md-right' for='nama'>Nama variasi_ukuran</label>
                    <div class='col-md-6'>
                        <input type='text' id='nama' name='nama_variasi_ukuran' class='form-control' placeholder='Nama variasi_ukuran' value='$r[nama_variasi_ukuran]' required>
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
