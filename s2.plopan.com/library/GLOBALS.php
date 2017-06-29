<?php
	$r='kkkk';
	echo "<pre>";
	echo 'Масив гобалс ',print_r ($GLOBALS),'<br>'	;
	echo 'Масив сервер ',print_r ($_SERVER),'<br>';
	echo 'Масив ЕНВ ',print_r ($_ENV),'<br>';
	echo 'Все функции ',print_r(get_defined_functions()),'<br>';
	echo "</pre>";
	
	echo 'Поверед бай '.PHP_VERSION.' на '.PHP_OS.'</br>';
?>