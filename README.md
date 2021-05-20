## 上传路径

将图片统一保存在`uploads`下,根据数据库中用户与图片的映射来判断该图片属于哪一位用户

## 表结构

```
CREATE database imgbed
CREATE TABLE users(
    id int PRIMARY KEY AUTO_INCREMENT,
    username varchar(100),
    password varchar(100),
    posi int(1),#记录所选择的密保问题
    answer varchar(100)
);
CREATE TABLE images(
    id int PRIMARY KEY AUTO_INCREMENT,
    uid int(11),#与users.id相对应
    imgname varchar(100),
    create_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

`users`保存用户名以及hash后的密码,`images`保存hash后的文件名以及创建日期或修改日期,同时将`uid`与`users`中的`id`相对应,用于确认图片的上传者

## Todo

* [x] 多图上传,拖拽上传,上传预览
* [x] 画廊功能
* [x] 界面美化
* [x] 登陆验证