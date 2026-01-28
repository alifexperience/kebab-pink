<?php
require_once "../../koneksi/koneksi.php";
require_once "../../middleware/auth.php";

$id = $_GET['id'];

mysqli_query($koneksi, "DELETE FROM bahan WHERE id_bahan='$id'");

header("Location: index.php");
exit;
