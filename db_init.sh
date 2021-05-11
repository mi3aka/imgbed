#!/bin/bash
service mysql start
mysql --user=root --password="root" -e "CREATE database imgbed;use imgbed;CREATE TABLE users(id int PRIMARY KEY AUTO_INCREMENT,username varchar(100),password varchar(100));CREATE TABLE images(id int PRIMARY KEY AUTO_INCREMENT,uid int(11),imgname varchar(100),create_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP);"
mysql --user=root --password="root" -e "CREATE USER 'user'@'localhost' IDENTIFIED BY 'user';GRANT ALL PRIVILEGES ON imgbed.* TO 'user'@'localhost';"