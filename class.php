<?php
error_reporting(0);

class User
{
    public $sql;

    public function __construct()
    {
        $this->sql = new mysqli("127.0.0.1", "user", "user", "imgbed");
        if (mysqli_connect_errno()) {#检查连接
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
        }
        #var_dump($this->sql);
    }

    public function check_user_exist($username): bool
    {
        $stmt = $this->sql->prepare("SELECT `username` FROM `users` WHERE `username` = ?;");#https://www.php.net/manual/zh/mysqli.prepare.php
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        $count = $stmt->affected_rows;#返回匹配的总行数
        $stmt->close();
        if ($count === 0) {
            return false;
        }
        return true;
    }

    public function add_user($username, $password): bool
    {
        if ($this->check_user_exist($username)) {
            return false;
        }
        $password = sha1($password . "!@#$%^&*()");#混淆防止直接猜测
        $stmt = $this->sql->prepare("INSERT INTO `users` (`id`, `username`, `password`) VALUES (NULL, ?, ?);");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $stmt->close();
        return true;
    }

    public function verify_user($username, $password): bool
    {
        if (!$this->check_user_exist($username)) {
            return false;
        }
        $password = sha1($password . "!@#$%^&*()");#混淆防止直接猜测
        $stmt = $this->sql->prepare("SELECT `id`,`password` FROM `users` WHERE `username` = ?;");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($uid, $result);
        $stmt->fetch();
        $stmt->close();
        if (isset($result) && $result === $password) {
            $_SESSION['uid'] = $uid;
            return true;
        }
        return false;
    }

    public function __destruct()
    {
        $this->sql->close();
    }
}

class Image
{
    public $sql;

    public function __construct()
    {
        $this->sql = new mysqli("127.0.0.1", "user", "user", "imgbed");
        if (mysqli_connect_errno()) {#检查连接
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
        }
        #var_dump($this->sql);
    }

    public function insert($imgname)
    {
        $uid = $_SESSION['uid'];
        $stmt = $this->sql->prepare("INSERT INTO `images` (`id`, `uid`, `imgname`) VALUES (NULL, ?, ?);");#时间戳自动生成
        $stmt->bind_param("is", $uid, $imgname);
        $stmt->execute();
        $stmt->close();
    }

    public function select(): array
    {
        $uid = $_SESSION['uid'];
        $stmt = $this->sql->prepare("select group_concat(`imgname`),group_concat(`create_date`) from `images` where `uid`=?;");
        $stmt->bind_param("i", $uid);
        $stmt->execute();
        $stmt->bind_result($imgname, $create_date);
        $stmt->fetch();
        $stmt->close();
        $imgname = explode(',', $imgname);
        $create_date = explode(',', $create_date);
        return array($imgname, $create_date);
    }

    public function delete($imgname)
    {
        $uid = $_SESSION['uid'];
        $stmt = $this->sql->prepare("DELETE FROM `images` where `uid`=? and `imgname`=?;");
        $stmt->bind_param("is", $uid, $imgname);
        $stmt->execute();
        $stmt->close();
    }
}


class FileList
{
    private $filename;
    private $date;
    private $size;

    public function __construct()
    {
        $image = new Image();
        list($imgname, $create_date) = $image->select();

        $this->filename = $imgname;
        $this->date = $create_date;
        $this->size = array();

        foreach ($this->filename as $value) {
            $file = new File('uploads/' . $value);
            if ($file->check_file_exist()) {
                array_push($this->size, $file->get_file_size());
            }
        }
    }

    public function __destruct()
    {
        $table = '<div class="container"><div class="table-responsive"><table id="table" class="table table-bordered table-hover sm-font">';#https://getbootstrap.com/docs/4.0/content/tables/
        $table .= '<thead><th scope="col" class="text-center"><div class="btn-group" role="group" aria-label="Basic example">
  <button type="button" class="btn btn-sm btn-outline-primary" id="url" data-toggle="collapse" data-target=".url">URL</button>
  <button type="button" class="btn btn-sm btn-outline-success" id="html" data-toggle="collapse" data-target=".html">HTML</button>
  <button type="button" class="btn btn-sm btn-outline-info" id="markdown" data-toggle="collapse" data-target=".markdown">Markdown</button>
</div></th><th scope="col" class="text-center">日期</th><th scope="col" class="text-center">大小</th><th scope="col" class="text-center">操作</th></thead>';
        $table .= '<tbody>';
        for ($i = 0; $i < count($this->filename); $i++) {
            if ($this->filename[$i]) {
                $url = 'http://0.0.0.0/' . 'uploads/' . $this->filename[$i];
                $table .= '<tr>';
                $table .= '<td class="text-center">' . '<div class="tab-pane fade in active show url collapse">' . htmlentities($url) . '</div>' . '<div class="tab-pane fade in html collapse"><pre>&lt;img src="' . htmlentities($url) . '"&gt;</pre></div>' . '<div class="tab-pane fade in markdown collapse">![](' . htmlentities($url) . ')</div>' . '</td>';
                $table .= '<td class="text-center">' . htmlentities($this->date[$i]) . '</td>';
                $table .= '<td class="text-center">' . htmlentities($this->size[$i]) . '</td>';
                $table .= '<td class="text-center" filename="' . htmlentities($this->filename[$i]) . '"><a href="#" class="download">下载</a> / <a href="' . htmlentities($url) . '" target="_blank" class="preview">预览</a> / <a href="#" class="delete">删除</a></td>';
                $table .= '</tr>';
            }
        }
        $table .= '</tbody></table></div>';
        $table .= '<script>document.getElementById("markdown").addEventListener("click", function () {
            let url = document.getElementsByClassName("url")
            for (let i = 0; i < url.length; i++) {
                url[i].classList.remove("active")
                url[i].classList.remove("show")
            }
            let html = document.getElementsByClassName("html")
            for (let i = 0; i < url.length; i++) {
                html[i].classList.remove("active")
                html[i].classList.remove("show")
            }
            let markdown = document.getElementsByClassName("markdown")
            for (let i = 0; i < markdown.length; i++) {
                markdown[i].classList.remove("active")
                markdown[i].classList.remove("show")
            }
            for (let i = 0; i < markdown.length; i++) {
                markdown[i].classList.add("active")
            }
        })
        document.getElementById("url").addEventListener("click", function () {
            let markdown = document.getElementsByClassName("markdown")
            for (let i = 0; i < markdown.length; i++) {
                markdown[i].classList.remove("active")
                markdown[i].classList.remove("show")
            }
            let html = document.getElementsByClassName("html")
            for (let i = 0; i < html.length; i++) {
                html[i].classList.remove("active")
                html[i].classList.remove("show")
            }
            let url = document.getElementsByClassName("url")
            for (let i = 0; i < url.length; i++) {
                url[i].classList.remove("active")
                url[i].classList.remove("show")
            }
            for (let i = 0; i < url.length; i++) {
                url[i].classList.add("active")
            }
        })
        document.getElementById("html").addEventListener("click", function () {
            let markdown = document.getElementsByClassName("markdown")
            for (let i = 0; i < markdown.length; i++) {
                markdown[i].classList.remove("active")
                markdown[i].classList.remove("show")
            }
            let url = document.getElementsByClassName("url")
            for (let i = 0; i < url.length; i++) {
                url[i].classList.remove("active")
                url[i].classList.remove("show")
            }
            let html = document.getElementsByClassName("html")
            for (let i = 0; i < url.length; i++) {
                html[i].classList.remove("active")
                html[i].classList.remove("show")
            }
            for (let i = 0; i < html.length; i++) {
                html[i].classList.add("active")
            }
        })</script>';
        echo $table;
    }
}

class File
{
    public $filename;

    public function __construct($filename)
    {
        $this->filename = $filename;
    }

    public function check_file_exist(): bool
    {
        if (file_exists($this->filename) && !is_dir($this->filename)) {
            return true;
        } else {
            return false;
        }
    }

    public function get_file_size(): string
    {
        $size = filesize($this->filename);
        $units = array('B', 'KB', 'MB', 'GB');
        for ($i = 0; $size >= 1024; $i++) {
            $size /= 1024;
        }
        return round($size, 1) . ' ' . $units[$i];#浮点数四舍五入,保留1位小数
    }

    public function delete_file()
    {
        unlink($this->filename);
    }

    public function get_file_contents()
    {
        return file_get_contents($this->filename);
    }
}

