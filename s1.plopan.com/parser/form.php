<html>
<head>
    <title>Форма добавления парсера</title>
</head>
<body>
<?php
define("DB_HOST", "localhost");
define("DB_LOGIN", "root");
define("DB_PASSWORD", "root");
define("DB_NAME", "parser");

$site = '';
$price = '';
$active = '';


if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $conn = mysqli_connect(DB_HOST, DB_LOGIN, DB_PASSWORD, DB_NAME);

    if(!empty($_POST["site"])){
        $site = trim($_POST["site"]);
        $matches = null;
        if(preg_match('~([^http://|https://].+?)/.+~im', $site, $matches))
            $site = $matches[1];
    }
    if(!empty($_POST["price"])){
        $price = trim($_POST["price"]);
    }
    if(!empty($_POST["active"])){
        $active = trim($_POST["active"]);
    }
    $textQueri = "INSERT INTO tags (site, tag_price, tag_active)
						VALUES('$site', '$price', '$active')";
    mysqli_query($GLOBALS['conn'] ,$textQueri) or die(mysqli_error($GLOBALS['conn']));
    //echo $textQueri;
    mysqli_close($conn);
    header("Location: {$_SERVER['PHP_SELF']}");
    exit;
}

?>
<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
    <p>Ссылка на сайт в формате <b>http://www.aks.ua/item/view/283821/yihua-payalnaya-stanciya-yihua-8858.html</b> <br><textarea type="text" name="site" cols="100"
                                                                  rows="10"></textarea>
    <p>Теги цены в формате <b>span.price__value</b> <br><textarea type="text" name="price" cols="100" rows="10"></textarea>
    <p>Тег активен товар в формате <b>.availability:contains("есть в наличии")</b> <br><textarea type="text" name="active" cols="100" rows="10"></textarea>
    <p><input type="submit" value="Виконати">
</form>
</body>
</html>