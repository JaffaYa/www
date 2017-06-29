<?php
//  од дл¤ всех страниц - сохранение информации о посещенных страницах


/*
«јƒјЌ»≈ 1
- —оздайте в сессии либо 
	- массив дл¤ хранени¤ всех посещенных страниц и сохраните в качестве его очередного элемента путь к текущей странице. 
	- строку с уникальным разделителем и последовательно еЄ дополн¤йте

*/
$mas = array();
$lastPage = array();
if (!empty($_SESSION ['mas']))
	$mas = unserialize($_SESSION ['mas']);
$lastPage = explode ("/",$_SERVER["PHP_SELF"]);
array_push ($mas,array_pop ($lastPage));
$_SESSION ['mas'] = serialize($mas);

?>