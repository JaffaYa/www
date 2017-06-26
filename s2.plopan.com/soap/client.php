<?php
	// Создать SOAP-клиента
	//$client = new SoapClient('http://s2.plopan.com/soap/stock.wsdl');	
	$client = new SoapClient('http://api.msinnovations.com/soap/wsdl.php');	
	// Послать SOAP-запрос c получением результат
	var_dump($client->sendSmsIn('0987273656','+38','Hi'));
	//echo $client->getStock("4");	
?>