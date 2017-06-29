<?php
//конект
$conn = mysqli_connect("localhost","root","root","gbook");

//виборка
function myBasket(){
	$textQueri = "SELECT 
					author, title, pubyear, price,
					basket.id,goodsid,customer,quantity
				FROM catalog,basket
				WHERE customer='".session_id()."'
                AND catalog.id = basket.goodsid";
	$resoult = mysqli_query($GLOBALS['conn'] ,$textQueri) or die(mysqli_error($GLOBALS['conn']));
	return db2Array($resoult);
}

//добавленіє
function save($name,$price,$quantity,$img){
	$textQueri = "INSERT INTO games (name, price, quantity, img)
						VALUES('$name', $price, $quantity, '{$img}')";
	mysqli_query($GLOBALS['conn'] ,$textQueri) or die(mysqli_error($GLOBALS['conn']));
}

//обновленіє
function update($name,$price,$quantity,$img,$id){
	$textQueri = "UPDATE games 
					SET name='$name', price=$price, quantity=$quantity, img='$img'
					WHERE id=$id";
	mysqli_query($GLOBALS['conn'] ,$textQueri) or die(mysqli_error($GLOBALS['conn']));
}

//удаленіє
$textQueri = "DELETE FROM msgs WHERE id = $id";
mysqli_query($conn ,$textQueri);

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