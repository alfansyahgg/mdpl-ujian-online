<?php
$servername = "localhost";
$database = "db_exam";
$username = "root";
$password = "";
$baseURL = "http://localhost/mdpl-exam/";
$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

?>