<html>
<head>
	<title>Форма добавления товара в каталог</title>
</head>
<body>
<?php
// подключение библиотек
require "eshop_db.inc.php";
require "eshop_lib.inc.php";
$checked='';
$name = '';
$price = '';
$quantity = '';
$id = '';
$nameImg = '';
$imgDesc1 = '';
$description = '';
$adddesc = '';
	
if($_SERVER['REQUEST_METHOD']=='POST'){
		
	if(!empty($_POST["name"])) 
		$name=trim(strip_tags($_POST["name"]));
	if(!empty($_POST["price"])) 
		$price=(int)$_POST["price"];
	if(!empty($_POST["quantity"])) 
		$quantity=(int)$_POST["quantity"];
	if(!empty($_POST["type"]))
		$type=$_POST["type"];
	if(!empty($_POST["game"])){
		$game=$_POST["game"];
		if($game!='Виберіть ігру'){
			$checked='checked';
			$resoult = selectGame($game);
			print_r($resoult);
			$id = $resoult[0]['id'];
			$nameImg = $resoult[0]['img'];
			$name = $resoult[0]['name'];
			$price = $resoult[0]['price'];
			$quantity = $resoult[0]['quantity'];
			$descriptions = selectDesc($id);
			$description = $descriptions[0]['description'];
			$adddesc = $descriptions[0]['adddesc'];
			$imgDesc1 = $descriptions[0]['img'];
		}
	}
	echo "Что-то не задано Имя=$name, Цена=$price, Количество=$quantity, game=$game </br>";
	if($name!='' and $price!='' and $quantity!=''){
		if($game=='Виберіть ігру' and $type=="Создать новую запись"){
			$img = upload_img(IMG_LOGO,'img');
			save($name,$price,$quantity,$img);
			$id=mysqli_insert_id($conn); 
			echo "Что-то не задано Имя=$name, Цена=$price, Количество=$quantity, img=$img, game=$game Создалась нова запись</br>";
		}elseif($type=="Обновить существующую"){
			if(!empty($_POST["id"])) 
				$id=(int)$_POST["id"];
			if(!empty($_POST["nameImg"])) 
				$nameImg=$_POST["nameImg"];
			if ($_FILES['img']['error'] == UPLOAD_ERR_OK)
				$img = upload_img(IMG_LOGO,'img',$nameImg);
			update($name,$price,$quantity,$img,$id);
			echo "Что-то не задано Имя=$name, Цена=$price, Количество=$quantity, img=$img, game=$game id=$id nameImg=$nameImg Запись обновилась.</br>";
			$checked='';$name = '';$price = '';$quantity = '';$id = '';$nameImg = '';
		}
	}
	if(!empty($_POST["description"]))
		$description=$_POST["description"];
	if(!empty($_POST["adddesc"]))
		$adddesc=$_POST["adddesc"];
	if($description!='' and $adddesc!=''){
		if($game=='Виберіть ігру' and $type=="Создать новую запись"){
			$imgDesc = upload_img(IMG,'imgDesc');
			saveDesc($id,$imgDesc,$description,$adddesc);
			echo "Что-то не задано Опис=$description, Додатковий опис=$adddesc, imgDesc=$imgDesc, game=$game Создалась нова запись</br>";
		}elseif($type=="Обновить существующую"){
			if(!empty($_POST["id"])) 
				$id=(int)$_POST["id"];
			if(!empty($_POST["nameImg1"])) 
				$imgDesc1=$_POST["imgDesc1"];
			if ($_FILES['imgDesc']['error'] == UPLOAD_ERR_OK)
				$imgDesc = upload_img(IMG,'imgDesc',$imgDesc1);
			updateDesc($id,$imgDesc,$description,$adddesc);
			echo "Что-то не задано Опис=$description, Додатковий опис=$adddesc, imgDesc=$imgDesc, game=$game, id=$id nameImg=$imgDesc1 Запись обновилась.</br>";
			$checked='';$name = '';$price = '';$quantity = '';$id = '';$nameImg = '';
		}
	}
	
	header("Location: {$_SERVER['PHP_SELF']}");
}
?>
	<form action="<?=$_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
		<p>Виберіть назву ігри: 
		<select name="game">
			<option>Виберіть ігру</option>
			<?php
			$goods = selectAll();
			foreach ($goods as $item) {
			echo "<option value=\"{$item["name"]}\">{$item["name"]}</option>";
			}
			?>
		</select></p>
		<input type="hidden" name="id" value="<?=$id?>"/>
		<input type="hidden" name="nameImg" value="<?=$nameImg?>"/>
		<input type="hidden" name="imgDesc1" value="<?=$nameImg?>"/>
		<p><input type="radio" name="type" value="Создать новую запись" checked>Создать новую запись
		<input type="radio" name="type" value="Обновить существующую" <?=$checked?>>Обновить существующую</p>
		<p>Назва ігри: <input type="text" name="name" size="50" value="<?=$name?>">
		<p>Цена: <input type="text" name="price" size="6" value="<?=$price?>"> руб.
		<p>Количество: <input type="text" name="quantity" size="4" value="<?=$quantity?>">
		<p>Картінка лого: <input type="file" name="img">
		<p>Картінка опису: <input type="file" name="imgDesc">
		<p>Опис: <br><textarea type="text" name="description" cols="100" rows="10"><?=$description?></textarea>
		<p>Додатковий опис: <br><textarea type="text" name="adddesc" cols="100" rows="10"><?=$adddesc?></textarea>
		<p><input type="submit" value="Виконати">
	</form>
</body>
</html>