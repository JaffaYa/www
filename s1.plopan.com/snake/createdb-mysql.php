<?php
// Создание структуры Базы Данных гостевой книги

define("DB_HOST", "localhost");
define("DB_LOGIN", "root");
define("DB_PASSWORD", "root");

mysql_connect(DB_HOST, DB_LOGIN, DB_PASSWORD) or die(mysql_error());

$sql = 'CREATE DATABASE snake';
mysql_query($sql) or die(mysql_error());

mysql_select_db('snake') or die(mysql_error());

$sql = "
CREATE TABLE records (
	id int(11) NOT NULL auto_increment,
	name varchar(50) NOT NULL default '',
	rec int(11) NOT NULL,
	PRIMARY KEY (id)
)";
mysql_query($sql) or die(mysql_error());

mysql_close();

print '<p>Структура базы данных успешно создана!</p>';
?>