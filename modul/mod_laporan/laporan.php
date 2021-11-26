<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{

$aksi="modul/mod_laporan/aksi_laporan.php";
switch($_GET[act]){
  // Tampil User
  default:
  
echo"
   	<div class='row left-content-center'>
    <div class='col-md-6'>
        <div class='card shadow-sm mb-4 border-bottom-primary'>
            <div class='card-header bg-white py-3'>
                <div class='row'>
                    <div class='col'>
                        <h4 class='h5 align-middle m-0 font-weight-bold text-primary'>
                            Laporan Barang Masuk
                        </h4>
                    </div>
                </div>
            </div>
            <div class='card-body pb-2'>
			  <form method=POST action='modul/mod_laporan/cetakbarangmasuk.php' target='_blank'>
				<div class='row form-group'>
                    <label class='col-md-4 text-md-right' for='nama'>Dari Tanggal</label>
                    <div class='col-md-6'>
                        <input type='date'nama' name='dari' class='form-control' required>
                    </div>
                </div>
				<div class='row form-group'>
                    <label class='col-md-4 text-md-right' for='nama'>Sampai Tanggal</label>
                    <div class='col-md-6'>
                        <input type='date' id='nama' name='sampai' class='form-control' required>
                    </div>
                </div>
                <div class='row form-group justify-content-end'>
                    <div class='col-md-8'>
                        <button type='submit' class='btn btn-primary btn-icon-split'>
                            <span class='icon'><i class='fa fa-save'></i></span>
                            <span class='text'>Proses</span>
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
                            Laporan Barang Keluar
                        </h4>
                    </div>
                </div>
            </div>
            <div class='card-body pb-2'>
			  <form method=POST action='modul/mod_laporan/cetakbarangkeluar.php' target='_blank'>
				<div class='row form-group'>
                    <label class='col-md-4 text-md-right' for='nama'>Dari Tanggal</label>
                    <div class='col-md-6'>
                        <input type='date'nama' name='dari' class='form-control' required>
                    </div>
                </div>
				<div class='row form-group'>
                    <label class='col-md-4 text-md-right' for='nama'>Sampai Tanggal</label>
                    <div class='col-md-6'>
                        <input type='date' id='nama' name='sampai' class='form-control' required>
                    </div>
                </div>
                <div class='row form-group justify-content-end'>
                    <div class='col-md-8'>
                        <button type='submit' class='btn btn-primary btn-icon-split'>
                            <span class='icon'><i class='fa fa-save'></i></span>
                            <span class='text'>Proses</span>
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
      ";
    break;
  
  case "tambahlaporan":
    
   echo"
   	<div class='row justify-content-center'>
    <div class='col-md-8'>
        <div class='card shadow-sm mb-4 border-bottom-primary'>
            <div class='card-header bg-white py-3'>
                <div class='row'>
                    <div class='col'>
                        <h4 class='h5 align-middle m-0 font-weight-bold text-primary'>
                            Form Tambah laporan
                        </h4>
                    </div>
                    <div class='col-auto'>
                        <a href='?module=laporan' class='btn btn-sm btn-secondary btn-icon-split'>
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
			  <form method=POST action='$aksi?module=laporan&act=input'>
                <div class='row form-group'>
                    <label class='col-md-4 text-md-right' for='nama'>Nama laporan</label>
                    <div class='col-md-6'>
                        <input type='text' id='nama' name='nama_laporan' class='form-control' placeholder='Nama laporan' required>
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
    
  case "editlaporan":
    $edit=mysqli_query($konek,"SELECT * FROM laporan WHERE id_laporan='$_GET[id]'");
    $r=mysqli_fetch_array($edit);
	echo"
   	<div class='row justify-content-center'>
    <div class='col-md-8'>
        <div class='card shadow-sm mb-4 border-bottom-primary'>
            <div class='card-header bg-white py-3'>
                <div class='row'>
                    <div class='col'>
                        <h4 class='h5 align-middle m-0 font-weight-bold text-primary'>
                            Form Edit laporan
                        </h4>
                    </div>
                    <div class='col-auto'>
                        <a href='?module=laporan' class='btn btn-sm btn-secondary btn-icon-split'>
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
			  <form method=POST action=$aksi?module=laporan&act=update>
              <input type=hidden name=id value='$r[id_laporan]'>
                <div class='row form-group'>
                    <label class='col-md-4 text-md-right' for='nama'>Nama laporan</label>
                    <div class='col-md-6'>
                        <input type='text' id='nama' name='nama_laporan' class='form-control' placeholder='Nama laporan' value='$r[nama_laporan]' required>
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
