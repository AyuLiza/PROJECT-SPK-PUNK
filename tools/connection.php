<?php
$conn = mysqli_connect("localhost", "root", "", "db_smart");
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error() . " (errno: " . mysqli_connect_errno() . ")");
}
