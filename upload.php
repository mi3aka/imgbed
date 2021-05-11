<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    die();
}

include "class.php";

if (isset($_FILES["file"])) {
    $file_name = $_FILES['file']['name'];
    $file_type = $_FILES['file']['type'];
    $file_extension = substr($file_name, strrpos($file_name, '.') + 1);#获得上传文件的扩展名
    if ((($file_extension == "jpg" || $file_extension == "jpeg") && ($file_type == "image/jpeg")) || (($file_extension == "png") && ($file_type == "image/png")) || (($file_extension == "gif") && ($file_type == "image/gif"))) {
        $file_name = sha1(date('YmdGHs') . substr(microtime(true), 11, 4) . $_SESSION['username']) . '.' . $file_extension;
        $path = 'uploads/' . $file_name;
        move_uploaded_file($_FILES["file"]["tmp_name"], $path);
        $image = new Image();
        $image->insert($file_name);#在数据库中保存文件名
        $response = array("success" => true, "error" => "");
    } else {
        $response = array("success" => false, "error" => "只允许上传后缀为.jpg|.jpeg|.png|.gif的图片文件!");
    }
    Header("Content-type: application/json");
    echo json_encode($response);
}
