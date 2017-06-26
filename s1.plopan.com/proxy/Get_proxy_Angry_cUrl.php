<?php
/*
$conn = mysqli_connect("localhost", "root", "root", "proxy");
$textQueri = "SELECT 
				ip,
				port,
				id,
				country
				FROM proxy
				WHERE type = 'HTTP'
                ORDER BY id
                LIMIT $offset, $limit";//country_code='RU' AND
$resoult = mysqli_query($conn, $textQueri) or die(mysqli_error($conn));
mysqli_close($conn);

$arr=array();
while ($row = mysqli_fetch_assoc($resoult)){
    $arr[]=$row;
}*/
$arr_proxy = array();
$proxy_list = file('proxy/proxylist25.txt');
foreach($proxy_list  as $item){
    $proxya = explode(':',$item);
    $arr_proxy [] = $proxya[0].':'.$proxya[1];
}

define('AC_DIR', dirname(__FILE__));

# Including classes
require_once( AC_DIR . DIRECTORY_SEPARATOR .'AngryCurl'. DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'RollingCurl.class.php');
require_once( AC_DIR . DIRECTORY_SEPARATOR .'AngryCurl'. DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'AngryCurl.class.php');

# Initializing AngryCurl instance with callback function named 'callback_function'
$AC = new AngryCurl('callback_function');

# Initializing so called 'web-console mode' with direct cosnole-like output
$AC->init_console();

# Importing proxy and useragent lists, setting regexp, proxy type and target url for proxy check
# You may import proxy from an array as simple as $AC->load_proxy_list($proxy array);
$AC->load_proxy_list(
    //AC_DIR . DIRECTORY_SEPARATOR .'AngryCurl'. DIRECTORY_SEPARATOR . 'import' . DIRECTORY_SEPARATOR . 'proxy_list.txt',
    $arr_proxy,
    # optional: number of threads
    200,
    # optional: proxy type
    'http',
    # optional: target url to check
    'http://google.com',
    # optional: target regexp to check
    'title>G[o]{2}gle'
);
$AC->load_useragent_list( AC_DIR . DIRECTORY_SEPARATOR .'AngryCurl'. DIRECTORY_SEPARATOR . 'import' . DIRECTORY_SEPARATOR . 'useragent_list.txt');

# Basic request usage (for extended - see demo folder)

$AC->get('https://www.twitch.tv/mst9xatv');
$AC->get('https://www.twitch.tv/mst9xatv');
$AC->get('https://www.twitch.tv/mst9xatv');
$AC->get('https://www.twitch.tv/mst9xatv');
$AC->get('https://www.twitch.tv/mst9xatv');
$AC->get('https://www.twitch.tv/mst9xatv');


# Starting with number of threads = 200
$AC->execute(200);

# You may pring debug information, if console_mode is NOT on ( $AC->init_console(); )
//AngryCurl::print_debug();

# Destroying
unset($AC);

# Callback function example
function callback_function($response, $info, $request)
{
    if($info['http_code']!==200)
    {
        AngryCurl::add_debug_msg(
            "->\t" .
            $request->options[CURLOPT_PROXY] .
            "\tFAILED\t" .
            $info['http_code'] .
            "\t" .
            $info['total_time'] .
            "\t" .
            $info['url']
        );
    }else
    {
        AngryCurl::add_debug_msg(
            "->\t" .
            $request->options[CURLOPT_PROXY] .
            "\tOK\t" .
            $info['http_code'] .
            "\t" .
            $info['total_time'] .
            "\t" .
            $info['url']
        );

    }

    return;
}


