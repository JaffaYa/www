<?php
	// запуск сессии
	session_start();
	// подключение библиотек
	require "eshop_db.inc.php";
	require "eshop_lib.inc.php";
?>
<html>
<head>
	<title>Каталог товаров</title>
</head>
<body>
<table border="1" cellpadding="5" cellspacing="0" width="1000px" align="center">
<tr>
	<th>Игра</th>
	<th>Количество</th>
	<th>Цена</th>
</tr>
<?php
$goods = selectAll();
foreach ($goods as $item) {
?>
	<tr>
		<td><img src="<?=$item["img"]?>" alt="<?=$item["img"]?>"  width="30px" height="30px"><a href="game.php?id=<?=$item["id"]?>"><?=$item["name"]?></a></td>
		<td><?=$item["quantity"]?></td>
		<td><?=$item["price"]?></td>
	</tr>
<?php
}
?>
</table>
</body>
</html>