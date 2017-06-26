<?php
// Создание структуры Базы Данных гостевой книги
	define("DB_HOST", "localhost");
	define("DB_LOGIN", "root");
	define("DB_PASSWORD", "root");
	define("DB_NAME", "shop");

$conn = mysqli_connect(DB_HOST, DB_LOGIN, DB_PASSWORD) or die(mysql_error());

$sql = 'CREATE DATABASE ' . DB_NAME;
mysqli_query($conn,$sql) or die(mysql_error());

mysqli_select_db($conn,DB_NAME) or die(mysql_error());

$sql = "
CREATE TABLE games (
	id int(11) NOT NULL auto_increment,
	name varchar(50) NOT NULL default '',
	price int(11) NOT NULL default 0,
	quantity int(4) NOT NULL default 0,
	img varchar(50) NOT NULL default '',
	PRIMARY KEY (id)
)";
mysqli_query($conn,$sql) or die(mysql_error());
$sql = "
CREATE TABLE description (
	id int(11) NOT NULL auto_increment,
	idgame int(11) NOT NULL default 0,
	img varchar(50) NOT NULL default '',
	description varchar(1000) NOT NULL default '',
	adddesc varchar(1000) NOT NULL default '',
	PRIMARY KEY (id)
)";
mysqli_query($conn,$sql) or die(mysql_error());

mysqli_close($conn);

print '<p>Структура базы данных успешно создана!</p>';
?>
