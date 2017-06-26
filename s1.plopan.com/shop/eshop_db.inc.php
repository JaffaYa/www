<?php
	define("DB_HOST", "localhost");
	define("DB_LOGIN", "root");
	define("DB_PASSWORD", "root");
	define("DB_NAME", "shop");
	define("IMG_LOGO", "logo/");
	define("IMG", "img/");
	define("ORDERS_LOG", "orders.log"); //им¤ файла с личными данными пользователей
	
	$conn = mysqli_connect (DB_HOST,DB_LOGIN,DB_PASSWORD,DB_NAME) or die("ќшибка при соединении с базой данных: ".mysqli_error($conn));
?>