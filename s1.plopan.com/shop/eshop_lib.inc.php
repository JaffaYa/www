<?php
//сохраняет товар в таблицу каталога
function save($name,$price,$quantity,$img){
	$textQueri = "INSERT INTO games (name, price, quantity, img)
						VALUES('$name', $price, $quantity, '{$img}')";
	mysqli_query($GLOBALS['conn'] ,$textQueri) or die(mysqli_error($GLOBALS['conn']));
}
//сохраняет товар в таблицу описания
function saveDesc($idgame,$img,$description,$adddesc){
	$textQueri = "INSERT INTO description (idgame, img, description, adddesc)
						VALUES($idgame, '$img', '$description', '$adddesc')";
	mysqli_query($GLOBALS['conn'] ,$textQueri) or die(mysqli_error($GLOBALS['conn']));
}
//Обновляет товар в таблицу каталога
function update($name,$price,$quantity,$img,$id){
	$textQueri = "UPDATE games 
					SET name='$name', price=$price, quantity=$quantity, img='$img'
					WHERE id=$id";
	mysqli_query($GLOBALS['conn'] ,$textQueri) or die(mysqli_error($GLOBALS['conn']));
}
//Обновляет товар в таблицу описания
function updateDesc($idgame,$img,$description,$adddesc){
	$textQueri = "UPDATE description 
					SET img='$img', description='$description', adddesc='$adddesc'
					WHERE idgame=$idgame";
	mysqli_query($GLOBALS['conn'] ,$textQueri) or die(mysqli_error($GLOBALS['conn']));
}
//конвертируем ресурс БД в массив
function db2Array($resoult){
	$arr=array();
	while ($row = mysqli_fetch_assoc($resoult)){
		$arr[]=$row;
	}	
	return $arr;
}
//возвращение всого содержимого каталога товаров
function selectAll(){
	$textQueri = "SELECT * FROM games";
	$resoult = mysqli_query($GLOBALS['conn'] ,$textQueri) or die(mysqli_error($GLOBALS['conn']));
	return db2Array($resoult);
}
//возвращает стим ключ в текстовом формате
function streamKey($customer,$goodsid,$quantity,$datetime){
	return chr(rand(65,90)) . chr(rand(65,90)) . chr(rand(65,90)) . chr(rand(65,90)) . chr(rand(65,90))."-".chr(rand(65,90)) . chr(rand(65,90)) . chr(rand(65,90)) . chr(rand(65,90)) . chr(rand(65,90))."-".chr(rand(65,90)) . chr(rand(65,90)) . chr(rand(65,90)) . chr(rand(65,90)) . chr(rand(65,90));
}
//загрузка картінки
function upload_img($way, $img, $nameImg=''){
	if ($_FILES[$img]['error'] == UPLOAD_ERR_OK) {
		$tmp_name = $_FILES[$img]["tmp_name"];
		// basename() может предотвратить атаку на файловую систему;
		if($nameImg==''){
			$img = basename($_FILES[$img]["name"]);
		}else{
			$img = basename($nameImg);
			echo "<p> $tmp_name $img";
		}
		while (file_exists($way.$img) and $nameImg==''){
			$imgArr = explode ('.',$img);
			$imgArr[0] .= rand(0,9);
			$img = $imgArr[0].'.'.$imgArr[1];
		}
		$img = $way.$img;
		move_uploaded_file($tmp_name, $img);
		if ($imgArr1 = explode ("'",$img)){//екранирование
			$i=0;
			while ($imgArr1[$i+1] != NULL){
				$img = $imgArr1[$i]."\'".$imgArr1[$i+1];
				$i++;
			} 
		}
	}
	return $img;
}
//возвращение параметры игры
function selectGame($game){
	$textQueri = "SELECT * FROM games
					WHERE name='$game'";
	$resoult = mysqli_query($GLOBALS['conn'] ,$textQueri) or die(mysqli_error($GLOBALS['conn']));
	return db2Array($resoult);
}
//возвращение описания игры
function selectDesc($id){
	$textQueri = "SELECT * FROM description
					WHERE idgame=$id";
	$resoult = mysqli_query($GLOBALS['conn'] ,$textQueri) or die(mysqli_error($GLOBALS['conn']));
	return db2Array($resoult);
}
?>