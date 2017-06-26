<?php
// конект
$conn = mysqli_connect("localhost","root","root","gbook");

// запрос виборка
function selectGame($game){
	$textQueri = "SELECT * FROM games
					WHERE name='$game'";
	$resoult = mysqli_query($GLOBALS['conn'] ,$textQueri) or die(mysqli_error($GLOBALS['conn']));
	return db2Array($resoult);
}

// запрос добавление
function save($name,$price,$quantity,$img){
	$textQueri = "INSERT INTO games (name, price, quantity, img)
						VALUES('$name', $price, $quantity, '{$img}')";
	mysqli_query($GLOBALS['conn'] ,$textQueri) or die(mysqli_error($GLOBALS['conn']));
}

// запрос удаление
$textQueri = "DELETE FROM msgs WHERE id = $id";
	mysqli_query($GLOBALS['conn'] ,$textQueri) or die(mysqli_error($GLOBALS['conn']));

// запрос обновление-изменение
function updateDesc($idgame,$img,$description,$adddesc){
	$textQueri = "UPDATE description 
					SET img='$img', description='$description', adddesc='$adddesc'
					WHERE idgame=$idgame";
	mysqli_query($GLOBALS['conn'] ,$textQueri) or die(mysqli_error($GLOBALS['conn']));
}

//дізконект
mysqli_close($conn);

//конвертируем ресурс БД в массив
function db2Array($resoult){
	$arr=array();
	while ($row = mysqli_fetch_assoc($resoult)){
		$arr[]=$row;
	}	
	return $arr;
}
?>