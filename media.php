<?php
session_start();
error_reporting(0);
if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=index.php><b>LOGIN</b></a></center>";
}
else{
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Manajamen Inventori | Seera Beauty</title>

    <!-- Custom fonts for this template-->
    <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/fonts.min.css" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="assets/css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Datepicker -->
    <link href="assets/vendor/daterangepicker/daterangepicker.css" rel="stylesheet">

    <!-- DataTables -->
    <link href="assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="assets/vendor/datatables/buttons/css/buttons.bootstrap4.min.css" rel="stylesheet">
    <link href="assets/vendor/datatables/responsive/css/responsive.bootstrap4.min.css" rel="stylesheet">
    <link href="assets/vendor/gijgo/css/gijgo.min.css" rel="stylesheet">
	<!-- Select2 -->
	<link rel="stylesheet" href="assets/vendor/select2/css/select2.min.css">
    <style>
        #accordionSidebar,
        .topbar {
            z-index: 1;
        }
    </style>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-white sidebar sidebar-light accordion shadow-sm" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex text-white align-items-center bg-primary justify-content-center" href="">
               
                <div class="sidebar-brand-text mx-3">Seera Beauty</div>
            </a>
			<?php
			if ($_SESSION['leveluser']=='manager'){
			?>

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="media.php?module=home">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Penjualan
            </div>

                       <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="media.php?module=keluar&act=tambahkeluar">
                    <i class="fas fa-fw fa-upload"></i>
                    <span>Tambah Barang Keluar</span>
                </a>
            </li>
			<li class="nav-item">
                <a class="nav-link" href="media.php?module=keluar">
                    </i><i class="fas fa-fw fa-history"></i>
                    <span>Barang Keluar</span>
                </a>
            </li>
			<hr class="sidebar-divider">
			<div class="sidebar-heading">
                MANAJEMEN STOK
            </div>

                       <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="media.php?module=stok">
                    <i class="fas fa-fw fa-sticky-note"></i>
                    <span>Safety Stock</span>
                </a>
            </li>
			<li class="nav-item">
                <a class="nav-link" href="media.php?module=stok&act=hasilverifikasi">
                    </i><i class="fas fa-fw fa-history"></i>
                    <span>Data Order</span>
                </a>
            </li>
            <!-- Divider -->
            <hr class="sidebar-divider">

        
            <!-- Heading -->
            <div class="sidebar-heading">
                Management Barang
            </div>

             <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link pb-0" href="media.php?module=supplier">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Supplier</span>
                </a>
            </li>
           
             <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link pb-0" href="media.php?module=merek">
                    <i class="far fa-fw fa-copyright"></i>
                    <span>Merek</span>
                </a>
            </li>

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link pb-0" href="media.php?module=variasi_ukuran">
                    <i class="fas fa-fw fa-sort-amount-down"></i>
                    <span>Variasi Ukuran</span>
                </a>
            </li>

          
            
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed " href="#" data-toggle="collapse" data-target="#collapseMaster" aria-expanded="true" aria-controls="collapseMaster">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Barang</span>
                </a>
                <div id="collapseMaster" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-light py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Master Barang:</h6>
                        <a class="collapse-item" href="media.php?module=barang">Data Barang</a>
                        <a class="collapse-item" href="media.php?module=masuk">Barang Masuk
                </a>
            


                    </div>
                </div>
            </li>
            
            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Report
            </div>

            <li class="nav-item">
                <a class="nav-link" href="media.php?module=laporan">
                    <i class="fas fa-fw fa-print"></i>
                    <span>Cetak Laporan</span>
                </a>
            </li>

            
                <!-- Divider -->
                <hr class="sidebar-divider">

                <!-- Heading -->
                <div class="sidebar-heading">
                    Settings
                </div>

                <!-- Nav Item -->
                <li class="nav-item">
                    <a class="nav-link" href="media.php?module=user">
                        <i class="fas fa-fw fa-user-plus"></i>
                        <span>User Management</span>
                    </a>
                </li>
				<?php
				}
				else {
				?>
                
<!--ADMIN-->
			<!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="media.php?module=home">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Penjualan
            </div>

                       <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="media.php?module=keluar&act=tambahkeluar">
                    <i class="fas fa-fw fa-upload"></i>
                    <span>Tambah Barang Keluar</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="media.php?module=keluar">
                    <i class="fas fa-fw fa-upload"></i>
                    <span>Barang Keluar</span>
                </a>
            </li>
			
			
            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Report
            </div>

            <li class="nav-item">
                <a class="nav-link" href="media.php?module=laporan">
                    <i class="fas fa-fw fa-print"></i>
                    <span>Cetak Laporan</span>
                </a>
            </li>
                
			<?php
			}
			?>
                
            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-dark bg-primary topbar mb-4 static-top shadow-sm">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link bg-transparent d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars text-white"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline small text-capitalize">
                                    <?php
									include "config/koneksi.php";
									$login=mysqli_query($konek,"SELECT * FROM user WHERE id_user='$_SESSION[user_id]'");
									$r=mysqli_fetch_array($login);
									echo"$r[nama]";
									?>
                                </span>
                                <img class="img-profile rounded-circle" src="assets/img/avatar/user.png">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                
                                <a class="dropdown-item" href="" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800">Manajamen Inventori</h1>

                    <?php include "content.php";?>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-light">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Seera Beauty Management 2020</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Yakin ingin logout?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Klik "Logout" dibawah ini jika anda yakin ingin logout.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batalkan</button>
                    <a class="btn btn-primary" href="logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="assets/js/sb-admin-2.min.js"></script>

    <!-- Datepicker -->
    <script src="assets/vendor/daterangepicker/moment.min.js"></script>
    <script src="assets/vendor/daterangepicker/daterangepicker.min.js"></script>

    <!-- Page level plugins -->
    <script src="assets/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="assets/vendor/datatables/buttons/js/dataTables.buttons.min.js"></script>
    <script src="assets/vendor/datatables/buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="assets/vendor/datatables/jszip/jszip.min.js"></script>
    <script src="assets/vendor/datatables/pdfmake/pdfmake.min.js"></script>
    <script src="assets/vendor/datatables/pdfmake/vfs_fonts.js"></script>
    <script src="assets/vendor/datatables/buttons/js/buttons.html5.min.js"></script>
    <script src="assets/vendor/datatables/buttons/js/buttons.print.min.js"></script>
    <script src="assets/vendor/datatables/buttons/js/buttons.colVis.min.js"></script>
    <script src="assets/vendor/datatables/responsive/js/dataTables.responsive.min.js"></script>
    <script src="assets/vendor/datatables/responsive/js/responsive.bootstrap4.min.js"></script>

    <script src="assets/vendor/gijgo/js/gijgo.min.js"></script>
	<!-- Select2 -->
	<script src="assets/vendor/select2/js/select2.full.min.js"></script>
	<script>
  $(document).ready(function(){
    $('.select2').select2();
  });
</script>
    <script type="text/javascript">
        $(function() {
            $('.date').datepicker({
                uiLibrary: 'bootstrap4',
                format: 'yyyy-mm-dd'
            });

            var start = moment().subtract(29, 'days');
            var end = moment();

            function cb(start, end) {
                $('#tangal').val(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
            }

            $('#tanggal').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    'Hari ini': [moment(), moment()],
                    'Kemarin': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    '7 hari terakhir': [moment().subtract(6, 'days'), moment()],
                    '30 hari terakhir': [moment().subtract(29, 'days'), moment()],
                    'Bulan ini': [moment().startOf('month'), moment().endOf('month')],
                    'Bulan lalu': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                    'Tahun ini': [moment().startOf('year'), moment().endOf('year')],
                    'Tahun lalu': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')]
                }
            }, cb);

            cb(start, end);
        });

        $(document).ready(function() {
            var table = $('#dataTable').DataTable({
                buttons: ['copy', 'csv', 'print', 'excel', 'pdf'],
                dom: "<'row px-2 px-md-4 pt-2'<'col-md-3'l><'col-md-5 text-center'B><'col-md-4'f>>" +
                    "<'row'<'col-md-12'tr>>" +
                    "<'row px-2 px-md-4 py-3'<'col-md-5'i><'col-md-7'p>>",
                lengthMenu: [
                    [ 15, 25, 50, 100, -1],
                    [ 15, 25, 50, 100, "All"]
                ],
                columnDefs: [{
                    targets: -1,
                    orderable: false,
                    searchable: false
                }]
            });

            table.buttons().container().appendTo('#dataTable_wrapper .col-md-5:eq(0)');
        });
		
    </script>
    
</body>

</html>
<?php
}

?>