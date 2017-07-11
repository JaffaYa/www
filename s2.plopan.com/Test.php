<?php
/**
 * Created by PhpStorm.
 * User: Jaffa
 * Date: 03.07.2017
 * Time: 16:34
 */
$alive_proxy = [];
$i = 0;

init_console();

$conn = mysqli_connect("localhost", "root", "root", "proxy");
$textQueri = "SELECT
				ip,
				port
				FROM proxy
				WHERE type = 'SOCKS5'";
                //ORDER BY id
                //LIMIT $offset, $limit";//country_code='RU' AND
$proxys = mysqli_query($conn, $textQueri) or die(mysqli_error($conn));
mysqli_close($conn);

$proxys = db2Array($proxys);

echo "Всього проксяків ".count($proxys)."<br>";

$proxy_full = array_chunk($proxys, 500);
echo "<table border='1px'><thead><tr><td>№</td><td>Проксяк</td><td>Ответ</td></tr></thead>";
foreach($proxy_full as $proxys){
    $multi = curl_multi_init();
    $handles = [];

    foreach($proxys as $proxy){
        $ch = curl_init('https://www.google.com');//'https://httpbin.org/get'
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.109 Safari/537.36");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); //вернуть ответ
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);  //отключение проверок для
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  // https:
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 8);//таймайут конекта
        curl_setopt($ch, CURLOPT_TIMEOUT, 11);//таймаут ожидания результата
        //curl_setopt($ch, CURLOPT_VERBOSE, 1);
        //curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_NOBODY, true); //Без HTML

        curl_setopt($ch, CURLOPT_PROXY, $proxy['ip'].':'.$proxy['port']);
        curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);//Либо CURLPROXY_HTTP (по умолчанию), либо CURLPROXY_SOCKS4, CURLPROXY_SOCKS5, CURLPROXY_SOCKS4A или CURLPROXY_SOCKS5_HOSTNAME

        curl_multi_add_handle($multi, $ch);

        $handles [] = array($ch, $proxy['ip'].':'.$proxy['port']);
    }
//var_dump($handles);

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

    foreach($handles as $channel){
        $i++;
        $http_code = 0;
        $http_code = curl_getinfo($channel[0], CURLINFO_HTTP_CODE);
        if($http_code == 200){
            $alive_proxy[] = $channel[1];
        }
        echo "<tr><td>$i</td><td>".$channel[1]."</td><td>".$http_code."</td></tr>";
        curl_multi_remove_handle($multi, $channel[0]);
    }

    curl_multi_close($multi);
}
echo "</table>";

echo "<p>".count($alive_proxy)." живих проксяків.<br>";
foreach($alive_proxy as $proxy1){
    echo "$proxy1<br>";
    $html1 = SendRequest('https://www.twitch.tv/play4soul',$proxy1);
    echo $html1[0]."<br>";//,$html1[1];
}






function SendRequest($url, $proxy = false, $post = false, $post_data = false, $user_agent = "Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.109 Safari/537.36", $headers = false, $extradata = false)
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
        //curl_setopt($ch, CURLOPT_NOBODY, true); //Без HTML
    }


    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); //следовать редиректу


    if($headers == true AND is_array($headers)){
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    }


    //if($proxy){
        curl_setopt($ch, CURLOPT_PROXY, $proxy);
        curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);//Либо CURLPROXY_HTTP (по умолчанию), либо CURLPROXY_SOCKS4, CURLPROXY_SOCKS5, CURLPROXY_SOCKS4A или CURLPROXY_SOCKS5_HOSTNAME
    //}

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