<?php

include_once "curl.php";

$start='';
if(!empty($_GET["start"]))
    $start=$_GET["start"];
if($start==='start'){
    file_put_contents("cookies/cookie.txt", '');
    $conn = mysqli_connect("localhost", "root", "root", "proxy");

    $offset = 0;//29197
    $limit = 1000;
    $i = 0;

    while(1){
        //$html = SendRequest("https://nordvpn.com/wp-admin/admin-ajax.php?searchParameters%5B0%5D%5Bname%5D=proxy-country&searchParameters%5B0%5D%5Bvalue%5D=&searchParameters%5B1%5D%5Bname%5D=proxy-ports&searchParameters%5B1%5D%5Bvalue%5D=&offset=$offset&limit=$limit&action=getProxies");

        $html = json_decode($html[1]);

        if(count($html) == 0){
            break;
        }

        do{
            $i++;
            $nameOfFile = "proxy/proxylist{$i}.txt";
        }while(file_exists($nameOfFile));

        $fp = fopen($nameOfFile, "w");

        foreach($html as $item){
            $textQueri = "INSERT INTO proxy (country, country_code, ip, port, type)
	          VALUES('$item->country','$item->country_code','$item->ip','$item->port','$item->type')";
            mysqli_query($conn, $textQueri);// or die(mysqli_error($conn) . "<br>offset=$offset<br>limit=$limit");
            if(mysqli_error($conn))
                echo "<p>".mysqli_error($conn)."<br>offset=$offset<br>limit=$limit";
            fwrite($fp, "{$item->ip}:{$item->port}:{$item->type}\r\n");
        }
        fclose($fp);
        $offset += 1000;
        echo "<br>offset=$offset<br>limit=$limit";
    }
    mysqli_close($conn);
}else{
    ?>
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="get">
        <input type="hidden" name="start" value="start"/>
        <input type="submit" value="Start looking for proxy">
    </form>
    <?php
}

