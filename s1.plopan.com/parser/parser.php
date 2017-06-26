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

$fp = fopen(FILE_NAME, "r");
$conn = mysqli_connect(DB_HOST, DB_LOGIN, DB_PASSWORD, DB_NAME);
newtime();
while (($data = fgetcsv($fp,1000,";")) !== FALSE) { //перебор всех строк
    $name='';
    $artc='';
    if(++$i<=2)
        continue;
    $num = count($data);
    $name = $data[0];
    $artc = $data[1];
    echo "<p> ".($num-2)." ccылок в строке: <br /></p>\n";
    for ($c=2; $c < $num; $c++) { // перебор всех ячеек
        $site='';
        $full_site='';
        $price='0';
        $active=0;

        //поиск навания сайта
        $matches = null;
        $result = preg_match('~([^http://|https://].+?)/.+~im', $data[$c], $matches);
        if(!$result)
            continue;
        $site = $matches[1];
        $full_site = $data[$c];

        $tags = getTags($site);
        $tags = $tags[0]; // одна строчка в архиве
        $resalt = SendRequest($full_site);

        $pq = phpQuery::newDocument($resalt[1]);

        //$pq->find()->html()->remove();

        //поиск цены
      /*  $matches = '';
        $returnValue = preg_match('~[^>].*'.$tags['tag_price'].'(.*)<~imU', $resalt[1], $matches);
        if(''!=$matches[1]){
            $price = (int)preg_replace('~&thinsp;~im', '', $matches[1]);
        }*/
        if(!empty($tags['tag_price'])){
            $price = $pq->find($tags['tag_price'])->html();//
           // $price = strip_tags($price);
            //$price = addcslashes($price,',');
           // var_dump($price);
        }

        //поиск наявности
        if($pq->find($tags['tag_active'])->html())
           $active=1;
        //var_dump($active);


        //$resalt[1]=htmlspecialchars($resalt[1], ENT_QUOTES);

        save($name,$data[$c],$artc,$price,$active,$resalt[0],'Тут сообщение ошибки');

        echo '<p>'.$name . "<br />\n";
        echo "<a href='{$data[$c]}'>".$data[$c] . "</a><br />\n";
        echo 'Артикyл - '.$artc . "<br />\n";
        echo 'Цена - '.$price. "<br />\n";
        echo 'Наличие - '.$active. "<br />\n";
        echo 'Код HTTP ответа - '.$resalt[0]. "<br />\n";
        //echo 'Результат запроса - '.$resalt[1]. "<br />\n";
        phpQuery::unloadDocuments($pq);
    }
    //exit;
}
mysqli_close($conn);
fclose($fp);

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

function SendRequest($url, $proxy = false, $post = false, $post_data = false, $user_agent = 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.86 Safari/537.36', $headers = false, $extradata = false)
{

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); //вернуть ответ

    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);  //отключение проверок для
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  // https:

    if($extradata){
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_HEADER, 1);
    }

    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); //следовать редиректу


    if($headers == true AND is_array($headers)){
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    }


    if($proxy){
        curl_setopt($ch, CURLOPT_PROXY, $proxy['ip'].':'.$proxy['port']);
        //curl_setopt($ch, CURLOPT_PROXYTYPE, CURL);//Либо CURLPROXY_HTTP (по умолчанию), либо CURLPROXY_SOCKS4, CURLPROXY_SOCKS5, CURLPROXY_SOCKS4A или CURLPROXY_SOCKS5_HOSTNAME
    }

    if($post){
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    }

    curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookies/cookie.txt');
    curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookies/cookie.txt');
    //curl_setopt($ch,CURLOPT_COOKIESESSION, true); //только не сесионные куки

    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 8);//таймайут конекта
    curl_setopt($ch, CURLOPT_TIMEOUT, 11);//таймаут ожидания результата


    $response = curl_exec($ch);
    $http = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    return array($http, $response);
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