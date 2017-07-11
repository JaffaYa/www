<?php
/**
 * Created by PhpStorm.
 * User: Jaffa
 * Date: 25.06.2017
 * Time: 12:54
 */
@ini_set('max_execution_time', 0);

define("FILE_NAME",'YIHUA_done.csv');

define("DB_HOST", "localhost");
define("DB_LOGIN", "root");
define("DB_PASSWORD", "root");
define("DB_NAME", "parser");

require_once 'phpQuery/phpQuery/phpQuery.php';

init_console();

$i=0;
$urls = array();
$resultat = array();

$urls_full = [];


//зчитування URL в масив
$fp = fopen(FILE_NAME, "r");
while (($data = fgetcsv($fp,1000,";")) !== FALSE) {
    if(++$i<=2)
        continue;
    $num = count($data);
    for ($c=2; $c < $num; $c++) {
        if(''!=$data[$c]){
            $urls[]= $data[$c];
            $resultat[] = array('site'=>$data[$c], 'data' => array('producte'=>$data[0],'act'=>$data[1]));
        }
    }
}
fclose($fp);

$urls_full = array_chunk($urls, 100);

foreach($urls_full as $urls){
    $handles = array();
    $multi = curl_multi_init();

//мультіпоточне виполненіє зпросів
    foreach($urls as $url){
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.109 Safari/537.36");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); //вернуть ответ
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);  //отключение проверок для
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  // https:
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 8);//таймайут конекта
        curl_setopt($ch, CURLOPT_TIMEOUT, 11);//таймаут ожидания результата

        curl_multi_add_handle($multi, $ch);

        $handles [] = array('ch' => $ch, 'url' => $url);
    }

    $active = null;
    do{
        $mrc = curl_multi_exec($multi, $active);
    }while($mrc == CURLM_CALL_MULTI_PERFORM);

    while($active && $mrc == CURLM_OK){
        // Wait for activity on any curl-connection
        if(curl_multi_select($multi) == -1){
            usleep(1);
        }

        // Continue to exec until curl is ready to
        // give us more data
        do{
            $mrc = curl_multi_exec($multi, $active);
        }while($mrc == CURLM_CALL_MULTI_PERFORM);
    }

//обробка результатів
    $conn = mysqli_connect(DB_HOST, DB_LOGIN, DB_PASSWORD, DB_NAME);
    newtime();

    foreach($handles as $item){
        $site = '';
        $product = '';
        $art = '';
        $active = 0;
        $price = 0;
        $code = 0;
        $html = curl_multi_getcontent($item['ch']);
        $code = curl_getinfo($item['ch'], CURLINFO_HTTP_CODE);

        $pq = phpQuery::newDocument($html);

        //поиск навания сайта
        $matches = null;
        $result = preg_match('~([^http://|https://].+?)/.+~im', $item['url'], $matches);
        if(!$result)
            continue;
        $site = $matches[1];
        $tags = getTags($site);
        $tags = $tags[0];


        //запісь резульататів
        foreach($resultat as $item1){
            if($item1['site'] == $item['url']){
                $site = $item1['site'];
                $product = $item1['data']['producte'];
                $art = $item1['data']['act'];
            }
        }
        //поіск цени
        if(!empty($tags['tag_price'])){
            $price = $pq->find($tags['tag_price'])->html();
        }
        //поиск наявности
        if($pq->find($tags['tag_active'])->html()){
            $active = 1;
        }

        save($product, $site, $art, $price, $active, $code, 'Тут сообщение ошибки');

        echo '<p>'.$product."<br/>\n";
        echo "<a href='$site'>".$site."</a><br/>\n";
        echo 'Артикyл - '.$art."<br />\n";
        echo 'Цена - '.$price."<br />\n";
        echo 'Наличие - '.$active."<br />\n";
        echo 'Код HTTP ответа - '.$code."<br />\n";

        phpQuery::unloadDocuments($pq);
        curl_multi_remove_handle($multi, $item['ch']);
    }
    mysqli_close($conn);

    curl_multi_close($multi);
}


function newtime(){
    $textQueri = "SELECT 
					id,price_now
				FROM products
";
    $resoult = mysqli_query($GLOBALS['conn'] ,$textQueri) or die(mysqli_error($GLOBALS['conn']));
    $resoult=db2Array($resoult);
    if(empty($resoult))
        return 'Пусто';
    foreach($resoult as $item){
        $textQueri = "UPDATE products 
					SET price_last='{$item['price_now']}'
					WHERE id={$item['id']}";
        mysqli_query($GLOBALS['conn'] ,$textQueri) or die(mysqli_error($GLOBALS['conn']));
    }
    return 'ok';
}

//запрос на теги
function getTags($site){
    $textQueri = "SELECT 
					tag_price, tag_active
				FROM tags
				WHERE site='$site'
";
    $resoult = mysqli_query($GLOBALS['conn'] ,$textQueri) or die(mysqli_error($GLOBALS['conn']));
    return db2Array($resoult);
}

function save($name,$site_link,$artc,$price,$active,$req_code,$req_text){

    $textQueri = "SELECT 
					id
				FROM products
				WHERE product='$name'
				AND site_link='$site_link'
";
    $resoult = mysqli_query($GLOBALS['conn'] ,$textQueri) or die(mysqli_error($GLOBALS['conn']));
    $resoult=db2Array($resoult);
    if(empty($resoult)){ // проверка на существование записи
        $textQueri = "INSERT INTO products (product, site_link, prod_code, price_now,active,req_code,req_text)
						VALUES('$name','$site_link','$artc','$price',$active,$req_code,'$req_text')";
        mysqli_query($GLOBALS['conn'] ,$textQueri) or die(mysqli_error($GLOBALS['conn']));
    }else{
        $textQueri = "UPDATE products 
					SET product='$name', site_link='$site_link', prod_code='$artc', price_now='$price', active=$active, req_code=$req_code, req_text='$req_text'
					WHERE id={$resoult[0]['id']}";
        //echo $textQueri;
        mysqli_query($GLOBALS['conn'] ,$textQueri) or die(mysqli_error($GLOBALS['conn']));
    }
}

//конвертируем ресурс БД в массив
function db2Array($resoult){
    $arr=array();
    while ($row = mysqli_fetch_assoc($resoult)){
        $arr[]=$row;
    }
    return $arr;
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