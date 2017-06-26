<?php
	require_once 'phpQuery/phpQuery/phpQuery.php';
	
	$html = file_get_contents('https://sinoptik.ua/погода-вахновка');
	//echo $html;
	$pq = phpQuery::newDocument($html);
	
	$elem = $pq->find('div.main#bd2 div.max');
	$text = $elem->text();//html();
	//$href = $elem->attr('href');
	var_dump($text);
	
	//некольеко елементов
	$links = $pq->find('a');
	$i=0;
	foreach ($links as $link) {

		$pqLink = pq($link); //pq делает объект phpQuery

		$text[$i] = $pqLink->html();
		$href[$i] = $pqLink->attr('href');
	echo "<p><a href=\"{$href[$i]}\">{$text[$i]}</a></p>";
	$i++;
	}


?>