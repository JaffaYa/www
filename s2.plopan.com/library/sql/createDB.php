<?php
define("DB_HOST", "localhost");
define("DB_LOGIN", "root");
define("DB_PASSWORD", "root");
define("DB_NAME", "MyDataBase");

$conn = mysqli_connect(DB_HOST, DB_LOGIN, DB_PASSWORD);
echo mysqli_error($conn);

$sql = 'CREATE DATABASE '.DB_NAME;
//mysqli_query($conn,$sql) or die(mysqli_error($conn));

mysqli_select_db($conn,DB_NAME) or die(mysqli_error(conn));

$sql = "
CREATE TABLE view (
	id int(11) NOT NULL auto_increment,
	name TEXT,
	deleted BOOLEAN NOT NULL DEFAULT FALSE,
	PRIMARY KEY (id)
)";//name varchar(50) NOT NULL default '',	email varchar(50) NOT NULL default '',
mysqli_query($conn,$sql) or die(mysqli_error($conn));

mysqli_close($conn);

print '<p>Структура базы данных успешно создана!</p>';
?>