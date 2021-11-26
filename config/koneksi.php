<?php
date_default_timezone_set("Asia/Jakarta");
error_reporting(0);
$server = "localhost";
$username = "root";
$password = "";
$database = "db_seerabeauty";

// Koneksi dan memilih database di server
$konek=mysqli_connect($server,$username,$password,$database) or die("Koneksi gagal");
?>
