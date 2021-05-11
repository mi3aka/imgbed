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
    $file->delete_file();
    Header("Content-type: application/json");
    $response = array("success" => true, "error" => "");
} else {
    Header("Content-type: application/json");
    $response = array("success" => false, "error" => "文件不存在");
}
echo json_encode($response);

