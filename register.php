<?php
session_start();
if (isset($_SESSION['login'])) {
    header("Location: index.php");
    die();
}
?>

<!DOCTYPE html>
<html>
<meta charset="utf-8">
<title>注册</title>

<head>
    <link href="//cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/login_and_reg.css" rel="stylesheet">
</head>

<body class="text-center">
    <form class="input-form" action="register.php" method="POST">
        <h1 class="h3 font-weight-normal">注册</h1>

        <input type="text" name="username" class="form-control" placeholder="Username" required autofocus>
        <input type="password" name="password" class="form-control" placeholder="Password" required><!--https://getbootstrap.com/docs/4.0/components/forms/ -->

        <button class="btn btn-lg btn-primary btn-block" type="submit">提交</button><!--https://getbootstrap.com/docs/4.0/components/buttons/ -->
    </form>
</body>
<div class="top" id="prompt_bar"></div><!--提示栏-->

<script src="//cdn.jsdelivr.net/npm/jquery@3.4.0/dist/jquery.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/prompt.js"></script>
</html>


<?php
include "class.php";

if (isset($_POST["username"]) && isset($_POST["password"])) {
    $u = new User();
    $username = (string) $_POST["username"];
    $password = (string) $_POST["password"];
    if (strlen($username) < 20 && strlen($username) > 5 && strlen($password) > 5) {
        if ($u->add_user($username, $password)) {
            echo("<script>window.location.href='login.php?register';</script>");#注册成功,重定向到登录页面
            die();
        } else {
            echo "<script>prompt_func('此用户名已被使用','warning');</script>";
            die();
        }
    }
    echo "<script>prompt_func('用户名长度必须大于3小于20,密码长度必须大于5','warning');</script>";
}
?>