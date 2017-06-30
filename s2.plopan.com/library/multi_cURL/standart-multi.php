<?php
/**
 * Created by PhpStorm.
 * User: Jaffa
 * Date: 30.06.2017
 * Time: 13:52
 */

init_console();
$urls = array();



for($i=0;$i<100;$i++){
    $urls[$i] = 'https://httpbin.org/get?i='.$i;
    echo "$urls[$i]<br>";
}
echo "<pre>";

$multi = curl_multi_init();
$handles = [];

foreach($urls as $url){
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.109 Safari/537.36");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); //вернуть ответ
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);  //отключение проверок для
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  // https:
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 8);//таймайут конекта
    curl_setopt($ch, CURLOPT_TIMEOUT, 11);//таймаут ожидания результата

    curl_multi_add_handle($multi,$ch);

    $handles [$url] = $ch;
}
//var_dump($handles);

$active = null;
do {
    $mrc = curl_multi_exec($multi, $active);
} while ($mrc == CURLM_CALL_MULTI_PERFORM);

while ($active && $mrc == CURLM_OK) {
    // Wait for activity on any curl-connection
    if (curl_multi_select($multi) == -1) {
        usleep(1);
    }

    // Continue to exec until curl is ready to
    // give us more data
    do {
        $mrc = curl_multi_exec($multi, $active);
    } while ($mrc == CURLM_CALL_MULTI_PERFORM);
}

foreach($handles as $channel){
    $html = curl_multi_getcontent($channel);
    var_dump($html);
    var_dump(curl_getinfo($ch, CURLINFO_HTTP_CODE));
    curl_multi_remove_handle($multi,$channel);
}

curl_multi_close($multi);


echo "</pre>";








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