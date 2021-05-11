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
<title>登录</title>

<head>
    <link href="//cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/login_and_reg.css" rel="stylesheet">
</head>

<body class="text-center">
    <form class="input-form" action="login.php" method="POST">
        <h1 class="h3 font-weight-normal">登录</h1>

        <input type="text" name="username" class="form-control" placeholder="Username" required autofocus>
        <input type="password" name="password" class="form-control" placeholder="Password" required><!--https://getbootstrap.com/docs/4.0/components/forms/ -->

        <button class="btn btn-lg btn-primary btn-block" type="submit">提交</button><!--https://getbootstrap.com/docs/4.0/components/buttons/ -->
        <p class="mt-5 text-muted">还没有账号? <a href="register.php">立即注册</a></p><!--https://getbootstrap.com/docs/4.0/utilities/colors/ -->
    </form>
    <div class="top" id="prompt_bar"></div><!--浮动提示栏-->
</body>

<script src="//cdn.jsdelivr.net/npm/jquery@3.4.0/dist/jquery.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/prompt.js"></script>
</html>


<?php
include "class.php";

if (isset($_GET['register'])) {
    echo "<script>prompt_func('注册成功', 'info');</script>";
}

if (isset($_POST["username"]) && isset($_POST["password"])) {
    $user = new User();
    $username = (string) $_POST["username"];
    $password = (string) $_POST["password"];
    if ($user->verify_user($username, $password)) {
        $_SESSION['login'] = true;
        $_SESSION['username'] = htmlentities($username);
        $sandbox = "uploads/" . md5($_SESSION['username'] . "!@#$%") . "/";#保证不同用户位于不同的图床,防止跨图床访问
        if (!is_dir($sandbox)) {
            mkdir($sandbox);
        }
        file_put_contents($sandbox."index.html",'<script language="javascript">window.location.href="../../index.php";</script>');#自动跳转
        $_SESSION['sandbox'] = $sandbox;
        echo("<script>window.location.href='index.php';</script>");
        die();
    }
    echo "<script>prompt_func('账号或密码错误', 'warning');</script>";
}
?>
