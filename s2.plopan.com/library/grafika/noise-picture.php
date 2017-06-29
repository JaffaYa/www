<?php
	/*
	ЗАДАНИЕ 1
	- Запустите сессию
	- Создайте переменную nChars(количество выводимых на картинке символов)
		и присвойте ей произвольное значение(рекомендуемое: 5)
	- Сгенерируйте случайную строку длиной nChars символов
	- Создайте сессионную переменную randStr и присвойте ей сгенерированную строку
	*/
	session_start();
	//$nChars = 5;
	$_SESSION ['randStr'] = chr(rand(65,90)) . chr(rand(65,90)) . chr(rand(65,90)) . chr(rand(65,90)) . chr(rand(65,90));
	
	/*
	ЗАДАНИЕ 2
	- Создайте изображение на основе файла "images/noise.jpg"
	- Создайте цвет для рисования
	- Включите сглаживание
	- Задайте начальные координаты x и y для отрисовки строки(рекомендуемые: 20 и 30)
	- Используя цикл for отрисуйте строку посимвольно
	- Для каждого символа используйте случайные значение размера и угла наклона
	- Отдайте полученный результат как jpeg-изображение с 10% сжатием
	*/
	$img = imageCreateFromJPEG("images/noise.jpg");
	imageAntiAlias($img,true);
	$silver = imageColorAllocate($img,100,100,100);
	$x=20; $y=30;
	
	for($i=0;$i<5;$i++){
		$size = rand(18,30);
		$angle = -45 + rand (0,90);
		imageTtfText($img,$size,$angle,$x,$y,$silver,"fonts/georgia.ttf",$_SESSION ['randStr']{$i});
		$x+=40;
	}
	
	
	header("Content-Type: image/jpg");
	imageJPEG($img);//,"",90
?>
