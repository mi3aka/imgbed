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
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css'>
        <link href="//cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="css/login_and_reg.css" rel="stylesheet">
        <style>
            .reg {
                margin-top: 2px;
            }
        </style>
    </head>

    <body class="text-center">
    <form class="input-form" action="test.php" method="POST">
        <h1 class="h3 font-weight-normal">注册</h1>
        <div class="reg">
            <input type="text" name="username" class="form-control" placeholder="请输入用户名" required autofocus>
        </div>
        <div class="reg">
            <input type="password" name="password" class="form-control" placeholder="请输入密码" required><!--https://getbootstrap.com/docs/4.0/components/forms/ -->
        </div>
        <div class="reg">
            <input type="password" name="confirm" class="form-control" placeholder="请再次确认密码" required>
        </div>
        <div class="reg">
            <select class="form-control" id="exampleFormControlSelect1" name="question">
                <option>您初中班主任的名字是?</option>
                <option>您的宠物的名字是?</option>
                <option>您最熟悉的童年好友的名字是?</option>
                <option>对您影响最大的人的名字是?</option>
            </select>
        </div>
        <div class="reg">
            <input type="text" name="answer" class="form-control" placeholder="请选择密保问题并填入答案" required>
        </div>
        <div class="reg">
            <button class="btn btn-lg btn-primary btn-block" type="submit">提交</button><!--https://getbootstrap.com/docs/4.0/components/buttons/ -->
        </div>
        <p class="mt-5 text-muted">已有账号? <a href="login.php">立即登录</a></p>
    </form>
    </body>
    <div class="top" id="prompt_bar"></div><!--提示栏-->

    <script src="//cdn.jsdelivr.net/npm/jquery@3.4.0/dist/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/prompt.js"></script>
    </html>


<?php
var_dump($_POST);
var_dump($_REQUEST);
?>