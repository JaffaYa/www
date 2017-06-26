<?php
	//Создание объекта XML
	$xml = new DomDocument();
	//Загрузка XML документа
	$xml->load('catalog.xml');
	//Создание объекта XSL
	$xsl = new DomDocument();
	//Загрузка XSL документа
	$xsl->load('catalog.xsl');
	//Создание XSLT парсера
	$proc = new XSLTProcessor();
	//Загрузка XSL объекта
	$proc->importStylesheet($xsl);
	//Парсинг
	$html = $proc->transformToXml($xml);
	echo $html;
?>