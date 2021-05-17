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
            <li class="breadcrumb-item active">Imgbed</li>
            <li class="active ml-auto"><a href="index.php"><button type="button" class="btn btn-sm btn-outline-primary"><svg t="1621249099133" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="1201" width="18" height="18"><path d="M64.00000001 128m64 0l640 0q64 0 64 64l0 64q0 64-64 64l-640 0q-64 0-64-64l0-64q0-64 64-64Z" p-id="1202"></path><path d="M64.00000001 416m64 0l640 0q64 0 64 64l0 64q0 64-64 64l-640 0q-64 0-64-64l0-64q0-64 64-64Z" p-id="1203"></path><path d="M64.00000001 704m64 0l640 0q64 0 64 64l0 64q0 64-64 64l-640 0q-64 0-64-64l0-64q0-64 64-64Z" p-id="1204"></path></svg> 简洁模式</button></a></li>
            <li class="active ml-auto"><a href="gallery.php"><button type="button" class="btn btn-sm btn-outline-success"><svg t="1621249386008" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="1221" width="18" height="18"><path d="M1017.25430378 571.3591466L544.74898534 788.16956703c-5.89158752 2.35663501-11.78317502 4.71327001-18.85308002 4.71327s-12.96149253-1.17831749-18.85308004-4.71327L33.35918933 571.3591466c-17.67476253-8.24822251-30.63625506-27.10130255-30.63625506-49.48933509 0-29.45793756 22.38803254-54.2026051 49.48933509-54.20260512 7.06990501 0 12.96149253 1.17831749 18.85308004 4.71327003l453.6522384 207.3838804 453.6522384-207.3838804c5.89158752-2.35663501 11.78317502-4.71327001 18.85308005-4.71327003 27.10130255 0 49.48933509 24.74466755 49.48933508 54.20260512 1.17831749 22.38803254-11.78317502 41.24111259-29.45793755 49.48933509z m0-234.48518296L544.74898534 553.68438409c-5.89158752 2.35663501-11.78317502 4.71327001-18.85308002 4.71326999s-12.96149253-1.17831749-18.85308004-4.71326999L33.35918933 336.87396364c-17.67476253-8.24822251-30.63625506-27.10130255-30.63625506-49.48933511s12.96149253-42.41943008 30.63625506-49.48933508l472.50531844-215.63210293c5.89158752-2.35663501 11.78317502-4.71327001 18.85308003-4.71327001s12.96149253 1.17831749 18.85308004 4.71327001L1017.25430378 236.71697595c17.67476253 8.24822251 30.63625506 27.10130255 30.63625506 49.48933508 0 23.56635005-12.96149253 42.41943008-30.63625506 50.66765261zM52.21226936 702.15238938c7.06990501 0 12.96149253 1.17831749 18.85308004 4.71326998L525.89590532 914.24953979l453.6522384-207.38388043c5.89158752-2.35663501 11.78317502-4.71327001 18.85308002-4.71326998 27.10130255 0 49.48933509 24.74466755 49.4893351 54.20260508 0 22.38803254-12.96149253 42.41943008-30.63625506 49.48933511L544.74898534 1021.4764325c-5.89158752 2.35663501-11.78317502 4.71327001-18.85308002 4.71327s-12.96149253-1.17831749-18.85308004-4.71327L33.35918933 805.84432957c-17.67476253-8.24822251-30.63625506-27.10130255-30.63625506-49.48933511 0-30.63625506 22.38803254-54.2026051 49.48933509-54.20260508z" p-id="1222"></path></svg> 画廊模式</button></a></li>
            <li class="active ml-auto">你好,<?php echo $_SESSION['username'] ?> <a href="logout.php">注销</a></li>
        </ol>
    </nav>
    <div class="container">
        <form method="POST" action="/upload.php?sent" enctype="multipart/form-data">
            <input type="file" class="filepond" name="file[]" multiple/>
            <input type="submit" value="Upload" class="btn btn-primary btn-block"/>
        </form>
    </div>
    <br>
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
            acceptedFileTypes: ['image/jpeg', 'image/png', 'image/gif'],
            maxFiles: 10,
            required: true
        });
    </script>
    </body>
    </html>

<?php
include "class.php";
$a = new FileList();
?>