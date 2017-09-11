<?php

require_once '../phpQuery/phpQuery/phpQuery/phpQuery.php';
require_once '../cURL/curl.php';
define('SITE','http://marketopt.zakupka.com/');
init_console();


$resalt = SendRequest(SITE);
//echo $resalt[1];

$pq = phpQuery::newDocumentHTML($resalt[1],'windows-1251');//,'windows-1251'
$links[] = $pq->find('a[href]')->attr('href');
//var_dump($links);
phpQuery::unloadDocuments($pq);

foreach($links as $link){
    echo $link.'<br>';
}


function init_console()
{
    # Internal Server Error fix in case no apache_setenv() function exists
    if (function_exists('apache_setenv'))
    {
        @apache_setenv('no-gzip', 1);
    }
    @ini_set('zlib.output_compression', 0);
    @ini_set('implicit_flush', 1);
    for ($i = 0; $i < ob_get_level(); $i++)
        ob_end_flush();
    ob_implicit_flush(1);
}
?>






