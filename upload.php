<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    die();
}

include "class.php";

if (isset($_FILES["file"])) {
    $filename = $_FILES['file']['name'];
    $filetype = $_FILES['file']['type'];
    $fileext = substr($filename, strrpos($filename, '.') + 1);#获得上传文件的扩展名
    if ((($fileext == "jpg" || $fileext == "jpeg") && ($filetype == "image/jpeg")) || (($fileext == "png") && ($filetype == "image/png")) || (($fileext == "gif") && ($filetype == "image/gif"))) {
        $filename = date('YmdGHs') . substr(microtime(true), 11, 4);
        $path = $_SESSION['sandbox'] . $filename . '.' . $fileext;
        move_uploaded_file($_FILES["file"]["tmp_name"], $path);
        $response = array("success" => true, "error" => "");
    } else {
        $response = array("success" => false, "error" => "只允许上传后缀为.jpg|.jpeg|.png|.gif的图片文件!");
    }
    Header("Content-type: application/json");
    echo json_encode($response);
}
