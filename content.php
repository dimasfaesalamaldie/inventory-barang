<?php
include "config/koneksi.php";
include "config/library.php";
include "config/fungsi_indotgl.php";
include "config/fungsi_rupiah.php";
// Bagian Home
if ($_GET['module']=='home'){
 echo"
 <div class='row'>
 


    <div class='col-md-4'>
        <div class='card shadow mb-4'>
            <div class='card-header bg-warning py-3'>
                <h6 class='m-0 font-weight-bold text-white text-center'>Stok Barang Akan Habis</h6>
            </div>
            <div class='table-responsive'>
                <table class='table mb-0 text-center table-striped table-sm'>
                    <thead>
                        <tr>
                            <th>Barang</th>
							             <th>V/U</th>
                            <th>Stok</th>
                            <th>Pasok</th>
                        </tr>
                    </thead>
                    <tbody>";
                    $tampil = mysqli_query($konek,"SELECT * FROM detail_barang JOIN safety_stock ON detail_barang.id_detail_barang=safety_stock.id_detail_barang 
																		JOIN variasi_ukuran ON detail_barang.id_variasi_ukuran=variasi_ukuran.id_variasi_ukuran
																		JOIN barang ON barang.id_barang=detail_barang.id_barang
																		JOIN merek ON barang.id_merek=merek.id_merek
																		WHERE safety_stock.status='Unsafe' 
																		ORDER BY barang.id_barang ASC");
					while ($k=mysqli_fetch_array($tampil)){    
                            echo"
						<tr>
              <td>$k[nama_merek] $k[nama_barang]</td>
							<td>$k[nama_variasi_ukuran]</td>
							<td>$k[stok]</td>
							<td>$k[rop]</td>
            </tr>
                            ";
					}		
					echo"
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class='col-md-4'>
        <div class='card shadow mb-4'>
            <div class='card-header bg-success py-3'>
                <h6 class='m-0 font-weight-bold text-white text-center'>5 Transaksi Terakhir Barang Masuk</h6>
            </div>
            <div class='table-responsive'>
                <table class='table mb-0 table-sm table-striped text-center'>
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Barang</th>
							<th>V/U</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>";
					$tampil = mysqli_query($konek,"SELECT * FROM barang_masuk JOIN detail_masuk ON barang_masuk.id_barang_masuk=detail_masuk.id_barang_masuk
																			  JOIN detail_barang ON detail_masuk.id_detail_barang=detail_barang.id_detail_barang
																			  JOIN barang ON detail_barang.id_barang=barang.id_barang
																			  JOIN variasi_ukuran ON detail_barang.id_variasi_ukuran=variasi_ukuran.id_variasi_ukuran
                                        JOIN merek ON merek.id_merek=merek.id_merek
																			  ORDER BY barang_masuk.tanggal_masuk DESC LIMIT 5");
					$no=1;
					while ($r=mysqli_fetch_array($tampil)){
					echo"
                            <tr>
								<td>$r[tanggal_masuk]</td>
								<td>$r[nama_merek] $r[nama_barang]</td>
								<td>$r[nama_variasi_ukuran]</td>
								<td>$r[jumlah]</td>
                            </tr>";
					}
					echo"
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class='col-md-4'>
        <div class='card shadow mb-4'>
            <div class='card-header bg-danger py-3'>
                <h6 class='m-0 font-weight-bold text-white text-center'>5 Transaksi Terakhir Barang Keluar</h6>
            </div>
            <div class='table-responsive'>
                <table class='table mb-0 table-sm table-striped text-center'>
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Barang</th>
							<th>V/U</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>";
					$tampil = mysqli_query($konek,"SELECT * FROM barang_keluar JOIN detail_keluar ON barang_keluar.id_barang_keluar=detail_keluar.id_barang_keluar
																			   JOIN detail_barang ON detail_keluar.id_detail_barang=detail_barang.id_detail_barang
																			   JOIN barang ON detail_barang.id_barang=barang.id_barang
																			   JOIN variasi_ukuran ON detail_barang.id_variasi_ukuran=variasi_ukuran.id_variasi_ukuran
                                         JOIN merek ON merek.id_merek=merek.id_merek
																			   ORDER BY barang_keluar.tanggal_keluar DESC LIMIT 5");
					$no=1;
					while ($r=mysqli_fetch_array($tampil)){
					echo"
                            <tr>
								<td>$r[tanggal_keluar]</td>
								<td>$r[nama_merek] $r[nama_barang]</td>
								<td>$r[nama_variasi_ukuran]</td>
								<td>$r[jumlah]</td>
                            </tr>";
					}
					echo"
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>";
   
  }

// Bagian barang
elseif ($_GET['module']=='barang'){
  if ($_SESSION['leveluser']=='admin' OR $_SESSION['leveluser']=='manager'){
    include "modul/mod_barang/barang.php";
  }
}

// Bagian variasi_ukuran
elseif ($_GET['module']=='variasi_ukuran'){
  if ($_SESSION['leveluser']=='admin' OR $_SESSION['leveluser']=='manager'){
    include "modul/mod_variasi_ukuran/variasi_ukuran.php";
  }
}
// Bagian masuk
elseif ($_GET['module']=='masuk'){
  if ($_SESSION['leveluser']=='admin' OR $_SESSION['leveluser']=='manager'){
    include "modul/mod_masuk/masuk.php";
  }
}
// Bagian keluar
elseif ($_GET['module']=='keluar'){
  if ($_SESSION['leveluser']=='admin' OR $_SESSION['leveluser']=='manager'){
    include "modul/mod_keluar/keluar.php";
  }
}
// Bagian merek
elseif ($_GET['module']=='merek'){
  if ($_SESSION['leveluser']=='admin' OR $_SESSION['leveluser']=='manager'){
    include "modul/mod_merek/merek.php";
  }
}
// Bagian stok
elseif ($_GET['module']=='stok'){
  if ($_SESSION['leveluser']=='admin' OR $_SESSION['leveluser']=='manager'){
    include "modul/mod_stok/stok.php";
  }
}
// Bagian supplier
elseif ($_GET['module']=='supplier'){
  if ($_SESSION['leveluser']=='admin' OR $_SESSION['leveluser']=='manager'){
    include "modul/mod_supplier/supplier.php";
  }
}
// Bagian User
elseif ($_GET['module']=='user'){
  if ($_SESSION['leveluser']=='admin' OR $_SESSION['leveluser']=='manager'){
    include "modul/mod_user/user.php";
  }
}
// Bagian User
elseif ($_GET['module']=='kasir'){
  if ($_SESSION['leveluser']=='admin' OR $_SESSION['leveluser']=='kasir'){
    include "modul/mod_kasir/kasir.php";
  }
}

// Bagian pembelian
elseif ($_GET['module']=='pembelian'){
  if ($_SESSION['leveluser']=='admin' OR $_SESSION['leveluser']=='manager'){
    include "modul/mod_pembelian/pembelian.php";
  }
}

// Bagian Tag
elseif ($_GET['module']=='laporan'){
  if ($_SESSION['leveluser']=='admin' OR $_SESSION['leveluser']=='manager'){
    include "modul/mod_laporan/laporan.php";
  }
}

// Bagian penjualan
elseif ($_GET['module']=='penjualan'){
  if ($_SESSION['leveluser']=='admin' OR $_SESSION['leveluser']=='manager'){
    include "modul/mod_penjualan/penjualan.php";
  }
}
// Apabila modul tidak ditemukan
else{
  echo "<p><b>MODUL BELUM ADA ATAU BELUM LENGKAP</b></p>";
}
?>
