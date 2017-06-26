<?php

include_once "curl.php";


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

init_console();

$offset = 0;//29197
$limit = 1000;
$i=0;

while(1){
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

    $resoult = db2Array($resoult);

    if(count($resoult) == 0){
        break;
    }

    foreach($resoult as $item){
        $i++;
        echo $item['ip'].':'.$item['port']." Testing...№ $i<br/>";
        $html = SendRequest('http://google.com/', $item);
        echo $html[0].'<br/>';
        echo $html[1].'<br/>';
    }
    $offset+=1000;
    if($html[0] == 200)break;
}



