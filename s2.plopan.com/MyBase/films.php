<!DOCTYPE HTML>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Посмотреть</title>
    <link href="https://fonts.googleapis.com/css?family=Bree+Serif" rel="stylesheet">
    <style>
        body {
            background-color: rgba(<? $start_bg_color = rand(150,205);
                                      echo $start_bg_color.','.($start_bg_color+rand(-50,50)).','.($start_bg_color+rand(-50,50)).',.'.rand(5,9); ?>);
            -background-clip: content-box;
            text-align:center;
        }
        .main {

            font-family: 'Bree Serif', cursive;
            font-size: 40px;
            text-align: center;
            padding: 0 20px;


            min-width: 700px;
            max-width: 1300px;
            display: inline-block;
            vertical-align: middle;

            /*
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            /*
            margin: auto;
            position: absolute;
            top: 0;
            left:0;
            bottom:0;
            right: 0;
            display: inline-block;
            */

            border: 24px solid rgba(<?=rand(0,255).','.rand(0,255).','.rand(0,255).',0.'.rand(1,7); ?>);
            border-radius: 150px;
            /*background-clip: padding-box;*/


            color: rgb(<?=rand(0,155).','.rand(0,155).','.rand(0,155); ?>);
            background: rgba(<?$main_bg_color=rand(120,255).','.rand(120,255).','.rand(120,255);
                                echo $main_bg_color.',1.'.rand(1,9); ?>);/*тут можна полностю не прзрачний*/
        }
        .form {
            margin-top: 20px;
            display: inline-block;
        }
        .text {
            font-family: 'Bree Serif', cursive;
            font-size: 40px;
            background: rgb(<?=$main_bg_color;?>);
            border-radius: 20px;
            border:0;
            outline: none;
            overflow: visible;
            width: 70%;
            height: 300px;
        }

        .conttent {
            margin: 30px 0;
            display: inline-block;
        }
        input[type="submit"], button
        {
            transition-duration:0.75s;
            transition-property:opacity;
            background: rgba(<?=rand(100,255).','.rand(100,255).','.rand(100,255).',.'.rand(4,8); ?>);
            color: rgb(<?=rand(0,155).','.rand(0,155).','.rand(0,155); ?>);
            border: 5px solid rgba(<?=rand(0,255).','.rand(0,255).','.rand(0,255).',.'.rand(2,5); ?>);
            font-size:25px;
            border-radius: 150px;
            padding: 8px 15px;
            opacity: 0.5;
            outline: none;
        }
        input[type="submit"]:hover , button:hover{
            opacity: 1.0;
        }
        #form {
            position: fixed;
            top: 1%; /* Положение от нижнего края */
            right: 1%;
        }
    </style>
</head>
<body>
<div style="width:1px;height:700px;
            display: inline-block;
            vertical-align: middle;"></div>
<?php
function db2Array($resoult){
    $arr=array();
    while ($row = mysqli_fetch_assoc($resoult)){
        $arr[]=$row;
    }
    return $arr;
}

function addFilm($name){
    $textQueri = "INSERT INTO view (name)
						VALUES('$name')";
    mysqli_query($GLOBALS['conn'] ,$textQueri) or die(mysqli_error($GLOBALS['conn']));
}
function updateFilm ($name,$id){
    $textQueri = "UPDATE view 
					SET name='$name'
					WHERE id=$id";
    mysqli_query($GLOBALS['conn'] ,$textQueri) or die(mysqli_error($GLOBALS['conn']));
}
function loadFilm($id){
    $textQueri = "SELECT 
                    id,
					name
				FROM view
				WHERE id='".$id."'
                AND deleted = FALSE";
    $resoult = mysqli_query($GLOBALS['conn'] ,$textQueri) or die(mysqli_error($GLOBALS['conn']));
    return db2Array($resoult);
}
function randFilm(){
    $textQueri = "SELECT 
                    id,
					name
				FROM view
				WHERE deleted = FALSE
";
    $resoult = mysqli_query($GLOBALS['conn'] ,$textQueri) or die(mysqli_error($GLOBALS['conn']));
    return db2Array($resoult);
}
function deleteFilm ($id){
    $textQueri = "UPDATE view 
					SET deleted = TRUE
					WHERE id=$id";
    mysqli_query($GLOBALS['conn'] ,$textQueri) or die(mysqli_error($GLOBALS['conn']));
}


if($_SERVER['REQUEST_METHOD']=='POST'){
    if(!empty($_POST["name"]))
        $name=trim(strip_tags($_POST["name"]));
    $conn = mysqli_connect("localhost", "root", "root", "MyDataBase");
    if(isset($_POST["id"])){
        updateFilm ($name,$_POST["id"]);
    }else{
       addFilm($name);
    }
    mysqli_close($conn);
    header("Location: {$_SERVER['PHP_SELF']}");
}elseif($_SERVER['REQUEST_METHOD']=='GET'){
    if(isset($_GET["delete"])){
        $conn = mysqli_connect("localhost", "root", "root", "MyDataBase");
        deleteFilm ($_GET["delete"]);
        mysqli_close($conn);
        header("Location: {$_SERVER['PHP_SELF']}");
    }
    if(isset($_GET["view"])){
        if(""!=$_GET["view"]){
            $conn = mysqli_connect("localhost", "root", "root", "MyDataBase");
            $name = loadFilm($_GET["view"]*1);
            //var_dump($name);
            mysqli_close($conn);
            ?>
            <div class="main">
            <form action="<?=$_SERVER['PHP_SELF']?>" method="post" class="form">
                <textarea type="text" name="name" class="text"><?=$name[0]['name'];?></textarea>
                <input type="hidden" name="id" value="<?=$name[0]['id'];?>"/><br>
                <input type="submit" value="Зберегти">
            </form>
            <?php
            exit;
        }
        ?>
        <div class="main">
        <form action="<?=$_SERVER['PHP_SELF']?>" method="post" class="form">
        <textarea type="text" name="name" cols="61" rows="5" class="text"></textarea><br>
        <input type="submit" value="Зберегти">
        </form>
        <?php
        exit;
    }
    ?>
    <form action="<?=$_SERVER['PHP_SELF']?>" method="get" id="form">
        <button  name="view">+</button>
    </form>
    <div class="main">
    <?php
    $conn = mysqli_connect("localhost", "root", "root", "MyDataBase");
    $film = randFilm();
    $rand = rand(0,count($film)-1);
    echo "<div class='conttent'>".$film[$rand]['name'];
    mysqli_close($conn);
    ?>
        <br/><form action="<?=$_SERVER['PHP_SELF']?>" method="get" class="form">
            <button name="view"  value="<?=$film[$rand]['id'];?>">Змінити</button>
            <button name="delete" value="<?=$film[$rand]['id'];?>">Удалити</button>
        </form>
    </div>
    <?php
}
?>
</div>
</body>
</html>