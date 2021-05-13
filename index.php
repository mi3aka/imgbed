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
    <link rel='stylesheet' href='css/filepond-plugin-image-preview.min.css'/>
    <link rel='stylesheet' href='css/filepond.min.css'/>
    <script src="//cdn.jsdelivr.net/npm/jquery@3.4.0/dist/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/prompt.js"></script>
    <script src="js/panel.js"></script>
</head>

<body>
    <nav aria-label="breadcrumb"><!--https://getbootstrap.com/docs/4.0/components/breadcrumb/ 面包屑导航栏-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">管理面板</li>
        <li class="active ml-auto">你好,<?php echo $_SESSION['username'] ?> <a href="logout.php">注销</a></li>
    </ol>
    </nav>
    <div class="imgupload">
        <form method="POST" action="/upload.php?sent" enctype="multipart/form-data">
            <input type="file" class="filepond" name="file[]" multiple/>
            <input type="submit" value="Upload" class="btn btn-info" id="uploadbtn"/>
        </form>
    </div>
    <div class="top" id="prompt_bar"></div><!--浮动提示栏-->
    <script src='js/filepond-plugin-file-encode.min.js'></script>
    <script src='js/filepond-plugin-image-preview.min.js'></script>
    <script src="js/filepond-plugin-file-validate-type.js"></script>
    <script src='js/filepond.min.js'></script>
    <script>
        FilePond.registerPlugin(
            FilePondPluginFileEncode,
            FilePondPluginImagePreview,
            FilePondPluginFileValidateType
        );
        FilePond.create(document.querySelector('.filepond'), {
            allowMultiple: true,
            acceptedFileTypes: ['image/jpeg','image/png','image/gif'],
            maxFiles: 5,
            required: true
        });
    </script>
</body>
</html>

<?php
include "class.php";
$a = new FileList();
?>