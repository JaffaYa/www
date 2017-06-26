<?php
    
	// Описать функцию/метод Web-сервиса
	function getStock($num){
		$stock = array(
						'1'=>100,
						'2'=>200,
						'3'=>300,
						'4'=>400,
		);
		if(array_key_exists($num,$stock))
			return $stock[$num];
		else
			return 0;
	}
	// Отключить кэширование WSDL-документа
	ini_set("soap.wsdl_cashe_enabled","0");
	// Создать SOAP-сервер
	$server = new SoapServer('http://s2.plopan.com/soap/stock.wsdl'); 
	//$server = new SoapServer('stock.wsdl'); 
	// Добавить функцию/класс к серверу
	$server->addFunction("getStock");
	// Запустить сервера
	$server->handle();
?>