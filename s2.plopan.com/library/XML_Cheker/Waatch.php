<?php

require_once '../phpQuery/phpQuery/phpQuery.php';
require_once '../cURL/curl.php';
define('FILE_NAME','Watch.xml');

init_console();

$urls=array(
    'http://marketopt.zakupka.com/p/192134764-detskie-chasy-s-gps-trekerom-smart-baby-watch-q60-blue/',
    'http://marketopt.zakupka.com/p/192134888-detskie-chasy-s-gps-trekerom-smart-baby-watch-q60-yellow/',
    'http://marketopt.zakupka.com/p/249053801-detskie-chasy-s-gps-trekerom-smart-baby-watch-q90s-goluboy/',
    'http://marketopt.zakupka.com/p/249053816-detskie-chasy-s-gps-trekerom-smart-baby-watch-q90s-oranzhevyy/',
    'http://marketopt.zakupka.com/p/249053822-detskie-chasy-s-gps-trekerom-smart-baby-watch-q90s-rozovyy/',
    'http://marketopt.zakupka.com/p/249055108-detskie-chasy-s-gps-trekerom-smart-baby-watch-tw6-rozovye/',
    'http://marketopt.zakupka.com/p/249053850-detskie-chasy-s-gps-trekerom-smart-baby-watch-tw6-sinie/',
    'http://marketopt.zakupka.com/p/192134836-detskie-chasy-s-gps-trekerom-smart-baby-watch-q60-pink/',
    'http://marketopt.zakupka.com/p/249053703-detskie-chasy-smart-baby-watch-tw3-1-3-lcd-blue-s-gps-trekerom/',
    'http://marketopt.zakupka.com/p/249053724-detskie-chasy-smart-baby-watch-tw3-1-3-lcd-pink-s-gps-trekerom/',
    'http://marketopt.zakupka.com/p/249053752-detskie-umnye-chasy-smart-baby-watch-tw3-1-3-lcd-yellow-s-gps-trekerom/',
    'http://marketopt.zakupka.com/p/249053866-smart-chasy-smart-watch-dbt-fw12-ips-1-3-heart-rate-black/',
    'http://marketopt.zakupka.com/p/249053885-smart-chasy-smart-watch-dbt-fw13-ips-1-3-heart-rate-black/',
    'http://marketopt.zakupka.com/p/249053899-smart-chasy-smart-watch-dbt-fw13-ips-1-3-heart-rate-silver-white/',
    'http://marketopt.zakupka.com/p/249053906-smart-chasy-smart-watch-dbt-fw8-ips-1-54-heart-rate-black/',
    'http://marketopt.zakupka.com/p/249055166-umnye-chasy-smart-watch-a1-chernyy/',
    'http://marketopt.zakupka.com/p/249055223-smart-watch-makibes-e07-bluetooth-4-0-ip67-cveta/',
    'http://marketopt.zakupka.com/p/249055236-smart-watch-oukitel-a28/',
    'http://marketopt.zakupka.com/p/249055271-smartwatch-makibes-k88h-black/',
    'http://marketopt.zakupka.com/p/249055292-smart-chasy-smartwatch-kw18-brown/',
    'http://marketopt.zakupka.com/p/249055453-chasy-smartwatch-u80-sport-black/',
    'http://marketopt.zakupka.com/p/271240034-k88h-umnye-bluetooth-chasy-s-pulsometrom-stainless-steel-band/',
    'http://marketopt.zakupka.com/p/374304205-detskie-smart-chasy-s-trekerom-smart-y21-sinie-fonarik/',
    'http://marketopt.zakupka.com/p/374306380-detskie-smart-chasy-s-trekerom-smart-y21-rozovye-fonarik/',
    'https://marketopt.zakupka.com/p/378482246-q80-umnye-detskie-chasy-smart-chasy-s-gps-trekerom-i-cvetnym-ekranom-golubye/',
    'https://marketopt.zakupka.com/p/378482329-q80-umnye-detskie-chasy-smart-chasy-s-gps-trekerom-i-cvetnym-ekranom-rozovye/',
    'https://marketopt.zakupka.com/p/385001583-chasy-smart-braslet-smart-watch-tw64-black/',
    'https://marketopt.zakupka.com/p/385011383-chasy-smart-braslet-smart-watch-tw64-orange/',
    'https://marketopt.zakupka.com/p/385083196-smart-q18-black/',
    'https://marketopt.zakupka.com/p/385259161-vodonepronicaemyy-braslet-w2/',
    'https://marketopt.zakupka.com/p/385379857-umnye-chasy-smart-watch-m26-s-bluetooth-white/',
    'https://marketopt.zakupka.com/p/385395270-umnye-chasy-smart-watch-m26-s-bluetooth-blue/',
    'https://marketopt.zakupka.com/p/386756140-umnye-chasy-smart-dz09-black/',
    'https://marketopt.zakupka.com/p/388658881-umnye-chasy-smart-watch-m26-s-bluetooth-black/',
    'https://marketopt.zakupka.com/p/390020442-chasy-smart-braslet-smart-watch-tw64-goluboy-vodonepronicaemyy/',
    'https://marketopt.zakupka.com/p/390167519-vodonepronicaemyy-smart-braslet-w2-oranzhevyy-vstroennyy-3d-sensor/',
    'https://marketopt.zakupka.com/p/390170186-vodonepronicaemyy-smart-braslet-w2-goluboy-vstroennyy-3d-sensor/',
    'https://marketopt.zakupka.com/p/390170711-vodonepronicaemyy-smart-braslet-w2-zelenyy-vstroennyy-3d-sensor/',
    'https://marketopt.zakupka.com/p/418863624-vodonepronicaemyy-monitor-serdechnogo-ritma-ck11s-i-krovyanogo-davleniya-smart-band-chernyy/',
    'https://marketopt.zakupka.com/p/419404841-umnye-chasy-smart-watch-a1-sinie-sim-karta-kamera/',
    'https://marketopt.zakupka.com/p/419405103-umnye-chasy-smart-watch-a1-krasnye-sim-karta-kamera/',
    'https://marketopt.zakupka.com/p/419405191-umnye-chasy-smart-watch-a1-krasnye-sim-karta-kamera/',
    'https://marketopt.zakupka.com/p/418873934-smart-braslet-floveme-a09-c-pulsometrom-i-vozmozhnostyu-izmereniya-krovyanogo-davleniya/',
    'https://marketopt.zakupka.com/p/192134246-detskie-chasy-smart-baby-watch-q50-blue-s-gps-trekerom-instrukciya-na-russkom/',
    'https://marketopt.zakupka.com/p/192134276-detskie-chasy-smart-baby-watch-q50-green-s-gps-trekerom-instrukciya-na-russkom/',
    'https://marketopt.zakupka.com/p/192134350-detskie-umnye-chasy-smart-baby-watch-q50-red-s-gps-trekerom-instrukciya-na-russkom/',
    'https://marketopt.zakupka.com/p/192135134-chasy-smartwatch-u80-sport-white/',
    'https://marketopt.zakupka.com/p/248888818-detskie-umnye-chasy-smart-baby-watch-tw2-0-96-oled-s-gps-trekerom/',
    'https://marketopt.zakupka.com/p/249054683-smart-chasy-smart-watch-dbt-hw1-heart-rate-black/',
    'https://marketopt.zakupka.com/p/374346065-detskie-smart-chasy-s-trekerom-smart-q100-sinie/',
    'https://marketopt.zakupka.com/p/374347297-detskie-smart-chasy-s-trekerom-smart-q100-rozovyy-krasnyy/',
    'https://marketopt.zakupka.com/p/374347367-detskie-smart-chasy-s-trekerom-smart-q100-zheltyy/',
    'https://marketopt.zakupka.com/p/420261032-smart-braslet-v7-chernyy-funkciya-bluetooth-garnitury/',
    'https://marketopt.zakupka.com/p/249053857-smart-chasy-smart-watch-v360-gps-black/',
    'https://marketopt.zakupka.com/p/249055299-umnye-chasy-smartwatch-makibes-k88h-gold/',
    'https://marketopt.zakupka.com/p/249055313-umnye-chasy-smartwatch-makibes-k88h-silver/',
    'https://marketopt.zakupka.com/p/192134918-smart-braslet-e02-bluetooth-smart-band-black/',
    'https://marketopt.zakupka.com/p/405975640-umnye-chasy-smart-v8-black-sim-karta-pamyati/'
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
    $count=0;
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
    $cid =  $dom->createElement("categoryId",'28');
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






