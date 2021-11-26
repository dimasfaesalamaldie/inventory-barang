<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{

$aksi="modul/mod_user/aksi_user.php";
switch($_GET[act]){
  // Tampil User
  default:
  echo"
  
<div class='card shadow-sm mb-4 border-bottom-primary'>
    <div class='card-header bg-white py-3'>
        <div class='row'>
            <div class='col'>
                <h4 class='h5 align-middle m-0 font-weight-bold text-primary'>
                    Data User
                </h4>
            </div>";
			if ($_SESSION['leveluser']=='manager'){
			echo"
            <div class='col-auto'>
                <a href='?module=user&act=tambahuser' class='btn btn-sm btn-primary btn-icon-split'>
                    <span class='icon'>
                        <i class='fa fa-user-plus'></i>
                    </span>
                    <span class='text'>
                        Tambah User
                    </span>
                </a>
            </div>";
			}
			echo"
        </div>
    </div>
    <div class='table-responsive'>
        <table class='table table-striped dt-responsive nowrap' id='dataTable'>
            <thead>
                <tr>
                    <th width='30'>No.</th>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>No. telp</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>";
					if ($_SESSION['leveluser']=='manager'){
					$tampil = mysqli_query($konek,"SELECT * FROM user ORDER BY id_user ASC");
					}
					else {
					$tampil = mysqli_query($konek,"SELECT * FROM user WHERE id_user='$_SESSION[user_id]'");
					}
					$no=1;
					while ($user=mysqli_fetch_array($tampil)){
					echo"
                        <tr>
                            <td>$no</td>
                            <td>$user[nama]</td>
                            <td>$user[username]</td>
                            <td>$user[email]</td>
                            <td>$user[no_telp]</td>
                            <td>$user[role]</td>
                            <td>
                                <a href='?module=user&act=edituser&id=$user[id_user]' class='btn btn-circle btn-sm btn-warning'><i class='fa fa-fw fa-edit'></i></a>";
								if ($_SESSION['leveluser']=='manager'){
								echo"
                                <a onClick=\"return confirm('Apakah Anda Yakin Untuk Menghapus Data Ini ?')\" href='$aksi?module=user&act=hapus&id=$user[id_user]' class='btn btn-circle btn-sm btn-danger'><i class='fa fa-fw fa-trash'></i></a>";
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
</div>
      ";
    break;
  
  case "tambahuser":
    
   echo"
   	<div class='row justify-content-center'>
    <div class='col-md-8'>
        <div class='card shadow-sm mb-4 border-bottom-primary'>
            <div class='card-header bg-white py-3'>
                <div class='row'>
                    <div class='col'>
                        <h4 class='h5 align-middle m-0 font-weight-bold text-primary'>
                            Form Tambah User
                        </h4>
                    </div>
                    <div class='col-auto'>
                        <a href='?module=user' class='btn btn-sm btn-secondary btn-icon-split'>
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
			  <form method=POST action='$aksi?module=user&act=input'>
                <div class='row form-group'>
                    <label class='col-md-4 text-md-right' for='username'>Username</label>
                    <div class='col-md-6'>
                        <input type='text' id='username' name='username' class='form-control' placeholder='Username' required>
                    </div>
                </div>
                <div class='row form-group'>
                    <label class='col-md-4 text-md-right' for='password'>Password</label>
                    <div class='col-md-6'>
                        <input type='password' id='password' name='password' class='form-control' placeholder='Password' required>
                    </div>
                </div>
                <hr>
                <div class='row form-group'>
                    <label class='col-md-4 text-md-right' for='nama'>Nama</label>
                    <div class='col-md-6'>
                        <input type='text' id='nama' name='nama' class='form-control' placeholder='Nama' required>
                    </div>
                </div>
                <div class='row form-group'>
                    <label class='col-md-4 text-md-right' for='email'>Email</label>
                    <div class='col-md-6'>
                        <input type='email' id='email' name='email' class='form-control' placeholder='Email' required>
                    </div>
                </div>
                <div class='row form-group'>
                    <label class='col-md-4 text-md-right' for='no_telp'>Nomor Telepon</label>
                    <div class='col-md-6'>
                        <input type='number' id='no_telp' name='no_telp' class='form-control' placeholder='Nomor Telepon' required>
                    </div>
                </div>
                <div class='row form-group'>
                    <label class='col-md-4 text-md-right' for='role'>Role</label>
                    <div class='col-md-6'>
                        <div class='custom-control custom-radio'>
                            <input value='manager' type='radio' id='manager' name='role' class='custom-control-input'>
                            <label class='custom-control-label' for='manager'>Manager</label>
                        </div>
                        <div class='custom-control custom-radio'>
                            <input value='admin' type='radio' id='admin' name='role' class='custom-control-input'>
                            <label class='custom-control-label' for='admin'>Admin</label>
                        </div>
                    </div>
                </div>
                <br>
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
    
  case "edituser":
    $edit=mysqli_query($konek,"SELECT * FROM user WHERE id_user='$_GET[id]'");
    $r=mysqli_fetch_array($edit);
	echo"
   	<div class='row justify-content-center'>
    <div class='col-md-8'>
        <div class='card shadow-sm mb-4 border-bottom-primary'>
            <div class='card-header bg-white py-3'>
                <div class='row'>
                    <div class='col'>
                        <h4 class='h5 align-middle m-0 font-weight-bold text-primary'>
                            Form Edit User
                        </h4>
                    </div>
                    <div class='col-auto'>
                        <a href='?module=user' class='btn btn-sm btn-secondary btn-icon-split'>
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
			  <form method=POST action=$aksi?module=user&act=update>
              <input type=hidden name=id value='$r[id_user]'>
                <div class='row form-group'>
                    <label class='col-md-4 text-md-right' for='username'>Username</label>
                    <div class='col-md-6'>
                        <input type='text' id='username' name='username' class='form-control' placeholder='Username' value='$r[username]' required>
                    </div>
                </div>
                <div class='row form-group'>
                    <label class='col-md-4 text-md-right' for='password'>Password</label>
                    <div class='col-md-6'>
                        <input type='password' id='password' name='password' class='form-control' placeholder='Password'>
						<span class='text-danger small'>Kosongkan Jika Password Tidak Diganti</span>
                    </div>
					
                </div>
                <hr>
                <div class='row form-group'>
                    <label class='col-md-4 text-md-right' for='nama'>Nama</label>
                    <div class='col-md-6'>
                        <input type='text' id='nama' name='nama' class='form-control' placeholder='Nama' value='$r[nama]' required>
                    </div>
                </div>
                <div class='row form-group'>
                    <label class='col-md-4 text-md-right' for='email'>Email</label>
                    <div class='col-md-6'>
                        <input type='email' id='email' name='email' class='form-control' placeholder='Email' value='$r[email]' required>
                    </div>
                </div>
                <div class='row form-group'>
                    <label class='col-md-4 text-md-right' for='no_telp'>Nomor Telepon</label>
                    <div class='col-md-6'>
                        <input type='number' id='no_telp' name='no_telp' class='form-control' placeholder='Nomor Telepon' value='$r[no_telp]' required>
                    </div>
                </div>
				<div class='row form-group'>
                    <label class='col-md-4 text-md-right' for='role'>Role</label>
                    <div class='col-md-6'>";
					if ($r[role]=='manager'){
					echo"
                        <div class='custom-control custom-radio'>
                            <input value='manager' type='radio' id='manager' name='role' class='custom-control-input' checked>
                            <label class='custom-control-label' for='manager'>Manager</label>
                        </div>
                        <div class='custom-control custom-radio'>
                            <input value='admin' type='radio' id='admin' name='role' class='custom-control-input'>
                            <label class='custom-control-label' for='admin'>Admin</label>
                        </div>";
					}
					else {
					echo"
                        <div class='custom-control custom-radio'>
                            <input value='manager' type='radio' id='manager' name='role' class='custom-control-input' >
                            <label class='custom-control-label' for='manager'>Manager</label>
                        </div>
                        <div class='custom-control custom-radio'>
                            <input value='admin' type='radio' id='admin' name='role' class='custom-control-input' checked>
                            <label class='custom-control-label' for='admin'>Admin</label>
                        </div>";
					}
					echo"
                    </div>
                </div>
                <br>
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
