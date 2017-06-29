<?php
/*
ЗАДАНИЕ 1
- Установите константу для хранения имени файла
- Проверьте, отправлялась ли форма и корректно ли отправлены данные из формы
- В случае, если форма была отправлена, отфильтруйте полученные значения
- Сформируйте строку для записи с файл
- Откройте соединение с файлом и запишите в него сформированную строку
- Выполните перезапрос текущей страницы (чтобы избавиться от данных, отправленных методом POST)
*/
$fname='';
$lname='';
define ('MY_FILE_NAME','file.txt'); //имя файла
if(!empty($_POST["fname"]))
	$fname=trim(strip_tags($_POST["fname"]));
if(!empty($_POST["lname"]))
	$lname=trim(strip_tags($_POST["lname"]));
if(!empty($_POST["email"]))
	$email=trim(strip_tags($_POST["email"]));
if ($fname!='' and $lname!=''){
		$fp = fopen(MY_FILE_NAME, "a");
		fwrite($fp, "$fname $lname _$email\n"); // Запись в файл
		fclose($fp);
}
if($_SERVER['REQUEST_METHOD']=='POST'){
	header ("Location: ".$_SERVER["PHP_SELF"]);
	exit;
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>
	<title>Работа с файлами</title>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
</head>
<body>

<h1>Заполните форму</h1>

<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">

Имя: <input type="text" name="fname" /><br />
Фамилия: <input type="text" name="lname" /><br />
Email: <input type="text" name="email" /><br />

<br />

<input type="submit" value="Отправить!" />

</form>

<?php
/*
ЗАДАНИЕ 2
- Проверьте, существует ли файл с информацией о пользователях
- Если файл существует, получите все содержимое файла в виде массива строк
- В цикле выведите все строки данного файла с порядковым номером строки
- После этого выведите размер файла в байтах.
*/
if (file_exists(MY_FILE_NAME)){
	$fileRecords=file(MY_FILE_NAME);
	echo "<ol>";
	foreach($fileRecords as $stR)  { 
		$stR = explode ('_',$stR);
		echo "<li><a href=\"".mail($stR[1],"Вы були обраним","а тепер нэ))))")."\">{$stR[0]}</a></li>";
	}
	echo "</ol>";
	echo "Размер файла ".filesize(MY_FILE_NAME)." байт.</br>";
	echo "Вы пришли с IP {$_SERVER['REMOTE_ADDR']}.</br>";
}
?>

</body>
</html>