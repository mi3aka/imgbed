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