## 表结构

```
CREATE database imgbed
CREATE TABLE users(
    id int PRIMARY KEY AUTO_INCREMENT,
    username varchar(100),
    password varchar(100)
);
CREATE TABLE images(
    id int PRIMARY KEY AUTO_INCREMENT,
    uid int(11),#与users.id相对应
    imgname varchar(100),
    create_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

`users`保存用户名以及hash后的密码,`images`保存hash后的文件名以及创建日期或修改日期,同时将`uid`与`users`中的`id`相对应,用于确认图片的上传者