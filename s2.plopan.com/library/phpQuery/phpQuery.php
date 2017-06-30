<?php//ініціалізація
require_once 'phpQuery/phpQuery/phpQuery.php';

$doc = phpQuery::newDocument($html);

//help.php
$price = $doc->find($tags['tag_price'])->html();
$price = $doc->find($tags['tag_price'])->test();

// розгрузка памяті
phpQuery::unloadDocuments($doc);

?>