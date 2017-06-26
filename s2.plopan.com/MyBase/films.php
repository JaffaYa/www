<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>View</title>
    <link href="https://fonts.googleapis.com/css?family=Bree+Serif" rel="stylesheet">
    <link rel="stylesheet" href="main.css">
</head>
<body>
<div style="">
    <table style=" font-family:'Bree Serif', cursive;
                   font-size:40px;
                   margin: 0 auto;
                   border:5px groove #CCC;
                   padding: 18px;
                   vertical-align: middle;
                   position: absolute;
                   top: 50%;
                   left: 50%;
                   height: 30%;
                   width: 50%;
                   margin: -15% 0 0 -25%;
    ">
        <tr>
            <td>
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
            <form action="<?=$_SERVER['PHP_SELF']?>" method="post"">
                <textarea type="text" name="name" cols="100" rows="10"><?=$name[0]['name'];?></textarea>
                <input type="hidden" name="id" value="<?=$name[0]['id'];?>"/>
                <p><input type="submit" value="Зберегти"></p>
            </form>
            <?php
            exit;
        }
        ?>
        <form action="<?=$_SERVER['PHP_SELF']?>" method="post"">
        <textarea type="text" name="name" cols="100" rows="10"></textarea>
        <p><input type="submit" value="Зберегти"></p>
        </form>
        <?php
        exit;
    }
    $conn = mysqli_connect("localhost", "root", "root", "MyDataBase");
    $film = randFilm();
    $rand = rand(0,count($film)-1);
    echo $film[$rand]['name'];
    mysqli_close($conn);
    ?>
    <form action="<?=$_SERVER['PHP_SELF']?>" method="get"">
        <button>Рандом</button>
        <button name="view"  value="<?=$film[$rand]['id'];?>">Змінити</button>
        <button name="delete" value="<?=$film[$rand]['id'];?>">Удалити</button>
        <button  name="view">Додати</button>
        <!--<p><input type="submit" value="Зберегти"></p>-->
    </form>
    <?php
}
?>
            </td>
        </tr>
    </table>
</div>
</body>
</html>