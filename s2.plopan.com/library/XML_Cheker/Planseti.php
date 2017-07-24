<?php

require_once '../phpQuery/phpQuery/phpQuery.php';
require_once '../cURL/curl.php';
define('FILE_NAME','Watch.xml');
$count=0;

init_console();

$urls=array(
    'https://marketopt.zakupka.com/p/389271715-kupalnik-razdelnyy-dlya-zhenshchin-3-cveta-kod-1-rozovyy/',
    'https://marketopt.zakupka.com/p/389308556-yarkiy-razdelnyy-kupalnik-dlya-zhenshchin-5-cvetov-kod-2/',
    'https://marketopt.zakupka.com/p/389378822-modnyy-kupalnik-razdelnyy-mnogo-cvetov-kod-3-rozovyy/',
    'https://marketopt.zakupka.com/p/389406110-originalnyy-kupalnik-razdelnyy-kod-4-rozovyy/',
    'https://marketopt.zakupka.com/p/389904172-kupalnik-razdelnyy-dlya-zhenshchin-3-cveta-kod-1-goluboy/',
    'https://marketopt.zakupka.com/p/389904452-modnyy-kupalnik-razdelnyy-mnogo-cvetov-kod-3-krasnyy/',
    'https://marketopt.zakupka.com/p/389904501-kupalnik-razdelnyy-dlya-zhenshchin-3-cveta-kod-1-krasnyy/',
    'https://marketopt.zakupka.com/p/389908295-modnyy-kupalnik-razdelnyy-mnogo-cvetov-kod-3-zheltyy/',
    'https://marketopt.zakupka.com/p/389908407-modnyy-kupalnik-razdelnyy-mnogo-cvetov-kod-3-chernyy/',
    'https://marketopt.zakupka.com/p/389908547-modnyy-kupalnik-razdelnyy-mnogo-cvetov-kod-3-zelenyy/',
    'https://marketopt.zakupka.com/p/389909045-modnyy-kupalnik-razdelnyy-mnogo-cvetov-kod-3-belyy/',
    'https://marketopt.zakupka.com/p/389909751-originalnyy-kupalnik-razdelnyy-kod-4-fioletovyy/',
    'https://marketopt.zakupka.com/p/389911536-originalnyy-kupalnik-razdelnyy-kod-4-goluboy/',
    'https://marketopt.zakupka.com/p/389911718-originalnyy-kupalnik-razdelnyy-kod-4-oranzhevyy/',
    'https://marketopt.zakupka.com/p/389924542-yarkiy-razdelnyy-kupalnik-dlya-zhenshchin-5-cvetov-kod-2-fioletovyy/',
    'https://marketopt.zakupka.com/p/389925928-yarkiy-razdelnyy-kupalnik-dlya-zhenshchin-5-cvetov-kod-2-rozovyy/',
    'https://marketopt.zakupka.com/p/389927279-yarkiy-razdelnyy-kupalnik-dlya-zhenshchin-5-cvetov-kod-2-krasnyy/',
    'https://marketopt.zakupka.com/p/389928273-yarkiy-razdelnyy-kupalnik-dlya-zhenshchin-5-cvetov-kod-2-chernyy/',
    'https://marketopt.zakupka.com/p/403941922-kupalnik-razdelnyy-dlya-zhenshchin-kod-5-mnogo-cvetov/',
    'https://marketopt.zakupka.com/p/403945047-kupalnik-razdelnyy-dlya-zhenshchin-kod-5-mnogo-cvetov/',
    'https://marketopt.zakupka.com/p/403877691-plate-pareo-dlya-plyazhnogo-otdyha-trend-2017/',
    'https://marketopt.zakupka.com/p/403883879-plate-pareo-dlya-plyazhnogo-otdyha-trend-2017/',
    'https://marketopt.zakupka.com/p/403944884-plate-pareo-dlya-plyazhnogo-otdyha-trend-2017/',
    'https://marketopt.zakupka.com/p/403944905-plate-pareo-dlya-plyazhnogo-otdyha-trend-2017/',
    'https://marketopt.zakupka.com/p/403944933-plate-pareo-dlya-plyazhnogo-otdyha-trend-2017/'
);


$dom = new DomDocument("1.0","UTF-8");
$dom->formatOutput = true;
$dom->preserveWhiteSpace = false;
$root = $dom->createElement("items");
$dom->appendChild($root);
/*
if (!file_exists(FILE_NAME)){
    $root = $dom->createElement("items");
    $dom->appendChild($root);
}else{
    $dom->load(FILE_NAME);
    $root = $dom->documentElement;
}
*/

foreach($urls as $url){
    $result=0;
    $matches='';
    $id='';
    $oldprice='';
    $vender='';
    $name='';
    $price='';
    //$url='http://marketopt.zakupka.com/p/192134764-detskie-chasy-s-gps-trekerom-smart-baby-watch-q60-blue/';
    $avilabiliti='';
    $param=array();
    $pr=[];
    $it='';
    $idd='';
    $cid='';
    $v='';
    $n='';
    $u='';
    $im=array();
    $img=array();
    $p='';
    $s='';

    echo "<a href=$url target=\"_blank\">$url</a><br>";
    $count++;
    $resalt = SendRequest($url);
    echo $resalt[0].'<br><br>';

    $pq = phpQuery::newDocumentHTML($resalt[1],'windows-1251');//,'utf-8','windows-1251'
    $id = $pq->find('meta[property="product:retailer_item_id"]')->attr('content');
    $vender = $pq->find('.i-js-spoiler:first')->text();
    $name = $pq->find('h1[itemprop="name"')->attr('content');
    for($i=0;$pq->find('img[data-source]:eq('.$i.')')->attr('data-source');$i++){
        $img[$i]=$pq->find('img[data-source]:eq('.$i.')')->attr('data-source');
        $img[$i]='http:'.$img[$i];
    }
    $price = $pq->find('meta[itemprop="price"]')->attr('content');
    $avilabiliti=$pq->find('.b-sect__block_product .b-availability:first')->text();
    for($i=1;$pq->find('div.b-info-table__table  .b-info-table__value .i-js-spoiler:eq('.$i.')')->text()!=='';$i++){
        $param[$i]['name']=$pq->find('div.b-info-table__table  .b-info-table__name .b-info-table__title:eq('.$i.')')->text();
        $param[$i]['value']=$pq->find('div.b-info-table__table  .b-info-table__value .i-js-spoiler:eq('.$i.')')->text();
    }
    phpQuery::unloadDocuments($pq);

    echo 'ID - '.$id.'<br>';
    echo 'Категория <categoryId>20</categoryId><br>';
    echo 'Производитель - '.$vender.'<br>';
    echo 'Имя - '.$name.'<br>';
    echo "Url - $url<br>";
    foreach($img as $item){
        echo $item.'<br>';
    }
    echo 'Цена '.$price.'<br>';
    echo 'Наявность: '.$avilabiliti.'<br>';
    foreach($param as $item){
        echo $item['name'].' - '.$item['value'].'<br>';
    }
    echo '<hr>';
    $it =  $dom->createElement("item");
    $idd =  $dom->createElement("id",$id);
    $cid =  $dom->createElement("categoryId",'30');
    $v =  $dom->createElement("vendor",$vender);
    $n =  $dom->createElement("name",$name);
    $u =  $dom->createElement("url",$url);
    foreach($img as $item){
        $im[] =  $dom->createElement("image",$item);
    }
    $p =  $dom->createElement("priceRUAH",$price );
    $s =  $dom->createElement("stock",$avilabiliti);
    for($i=1;$i<=(count($param));$i++){
        $atr='';
        $pr[$i] = $dom->createElement("param",$param[$i]['value']);
        $atr = $dom->createAttribute('name');
        $atr->value = $param[$i]['name'];
        $pr[$i]-> appendChild($atr);
    }

    $it->appendChild($idd);
    $it->appendChild($cid);
    $it->appendChild($v);
    $it->appendChild($n);
    $it->appendChild($u);
    foreach($im as $item){
        $it->appendChild($item);
    }

    $it->appendChild($p);
    $it->appendChild($s);
    foreach($pr as $item){
        $it->appendChild($item);
    }
    $root->appendChild($it);
    //if($count==1)break(1);
}
echo "$count";
$dom->save(FILE_NAME);


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






