<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    die();
}
?>

<!DOCTYPE html>
<html>
<meta charset="utf-8">
<title>图片管理</title>

<head>
    <link href="//cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/panel.css" rel="stylesheet">
    <script src="//cdn.jsdelivr.net/npm/jquery@3.4.0/dist/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/prompt.js"></script>
    <script src="js/panel.js"></script>
</head>

<body>
    <nav aria-label="breadcrumb"><!--https://getbootstrap.com/docs/4.0/components/breadcrumb/ 面包屑导航栏-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">管理面板</li>
        <li class="breadcrumb-item active"><label for="imgupload" class="imglable">上传图片</label></li><!--for属性规定label与哪个表单元素绑定-->
        <li class="active ml-auto">你好,<?php echo $_SESSION['username'] ?> <a href="logout.php">注销</a></li>
    </ol>
    </nav>
    <input type="file" multiple id="imgupload" class="upload">
    <div class="top" id="prompt_bar"></div><!--浮动提示栏-->
</body>
</html>

<?php
include "class.php";
$a = new FileList();
?>