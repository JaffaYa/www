<?php
define("DB_HOST", "localhost");
define("DB_LOGIN", "root");
define("DB_PASSWORD", "root");
define("DB_NAME", "parser");

$conn = mysqli_connect(DB_HOST, DB_LOGIN, DB_PASSWORD) or die(mysqli_error($conn));

$sql = 'CREATE DATABASE '.DB_NAME;
mysqli_query($conn,$sql) or print_r(mysqli_error($conn));

mysqli_select_db($conn,DB_NAME) or die(mysqli_error(conn));

$sql = "
CREATE TABLE tags (
            id int(11) NOT NULL auto_increment,
            site varchar(200) NOT NULL default '',
            tag_price varchar(200) NOT NULL default '',
            tag_active varchar(200) NOT NULL default '',
            PRIMARY KEY (id)
        )";
mysqli_query($conn,$sql) or print_r(mysqli_error($conn));

$sql = "
CREATE TABLE products (
            id int(11) NOT NULL auto_increment,
            product varchar(100) NOT NULL default '',
            site_link varchar(200) NOT NULL default '',
            prod_code varchar(200) NOT NULL default '',
            price_now varchar(15) NOT NULL default '',
            price_last varchar(15) NOT NULL default '',
            active BOOLEAN NOT NULL DEFAULT FALSE,
            req_code int(5) NOT NULL default 0,
            req_text TEXT,
            PRIMARY KEY (id)
        )";
mysqli_query($conn,$sql) or print_r(mysqli_error($conn));

mysqli_close($conn);

print '<p>Структура базы данных успешно создана!</p>';
?>