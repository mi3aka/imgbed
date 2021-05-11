<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    die();
}

if (!isset($_POST['filename'])) {
    die();
}

include "class.php";

ini_set("open_basedir", getcwd() . ":/etc:/tmp");
$filename = (string)$_POST['filename'];
$file = new File($_SESSION['sandbox'] . $filename);

if ($file->check_file_exist()) {
    Header("Content-type: application/octet-stream");
    Header("Content-Disposition: attachment; filename=" . basename($filename));
    echo $file->get_file_contents();
}

