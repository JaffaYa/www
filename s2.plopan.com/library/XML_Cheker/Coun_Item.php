<?php

//require_once '../phpQuery/phpQuery/phpQuery/phpQuery.php';
//require_once '../cURL/curl.php';
define('FILE_NAME','hotline.xml');

init_console();

$count=0;
$domObjc = new DomDocument();
$domObjc->load(FILE_NAME);
$root = $domObjc->documentElement;
foreach($root->childNodes as $items){
    if($items->nodeName == 'items'){
        foreach($items->childNodes as $item){
            if($item->nodeName == 'item'){
                $count++;
            }
        }
    }
}
echo "$count товаров.";


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






