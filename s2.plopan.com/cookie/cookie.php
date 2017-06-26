<?php
//установка печеньки сесииони
setcookie("i");
setcookie("time");
//проверка печеньки
if (isset($_COOKIE["i"]))
	$i = (int) $_COOKIE["i"];
if (isset($_COOKIE["time"]))
	$date = $_COOKIE["time"];
//установка печеньки сесииони з значением, если 3 параметром передать время то буде ном кука
setcookie("i",$i);
setcookie("time",date('d-m-Y H:i:s'));
?>
