<?php
/**
 * Created by PhpStorm.
 * User: Jaffa
 * Date: 15.06.2017
 * Time: 0:36
 */
define("AGENT", "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.86 Safari/537.36");


function SendRequest($url, $proxy = false, $post = false, $post_data = false, $user_agent = AGENT, $headers = false, $extradata = false)
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
    //curl_setopt($ch, CURLOPT_NOBODY, true); //Без HTML

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
