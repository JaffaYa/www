<?php
	// Сокетное соединение
	// Создание сокета (host+порт)
	/*
	echo exec('whoami')."<br>";
	echo gethostbyaddr('127.0.0.1')."<br>";
	echo gethostbyname('s2.plopan.com')."<br>";
	print_r (gethostbynamel('s2.plopan.com'));
	echo "<br>";
	echo getservbyname ('http','tcp')."<br>";
	echo getservbyport ('80','tcp')."<br>";
	*/
	
	$s = fsockopen ("localhost",80,$e1,$e2,30);
	
	// Создание POST-строки
	$str = "name=John&age=25";
	
	// Посылка HTTP-запроса
	$out = "POST /socket/dummy.php HTTP/1.1\r\n";
	$out .= "Host: localhost\r\n";
	$out .= "Contetn-Type: application/x-www-form-urlencodeds\r\n";
	$out .= "Contetn-Lenght: ".strlen($str)."\r\n\r\n";
	$out .= $str."\r\n\r\n";
	fputs($s,$str);
	//echo $str; exit;
	
	// Получение и вывод ответа
	while(!feof($s)){
		echo fgets($s)."</br>";
	}

	// Закрытие соединения
	fclose($s);
	
?>