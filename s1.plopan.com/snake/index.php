<!DOCTYPE html>
<html>
<head>
<title>
</title>
<meta charset="utf-8">
<link href="https://fonts.googleapis.com/css?family=Gloria+Hallelujah" rel="stylesheet">
<link rel="stylesheet" href="main.css">
<?php
	require_once "record.lib-mysql.php";
	writeResoult();
?>
</head>
<body>
	<div id="map">
	<div id="wrapper"></div>
	</div>
	<div id="highscore"> 
	<?php
		readRecords ();
	?>
	<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
		<input type="text" name="name" placeholder="Введите ваше им'я"/>
		<input type="text" name="resout" value="Тут рекорд"/>
		<input type="submit" value="Отправить" onclick="window.location.reload()"/>
	</form>
	</div>  
	<script type="text/javascript" src="jester.js"></script>
	<script type="text/javascript" src="snake.js"></script>
</body>
</html>