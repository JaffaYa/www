<?php
define("USER_LOG","users.xml");
if($_SERVER["REQUEST_METHOD"]=="POST"){
	$name = $_POST["name"];
	$email = $_POST["email"];
	$msg = $_POST["msg"];
	$ip = $_SERVER["REMOTE_ADDR"];
	$dt = time();

	$dom = new DomDocument("1.0","UTF-8");
	$dom->formatOutput = true;
	$dom->preserveWhiteSpace = false;
	if (!file_exists(USER_LOG)){
		$root = $dom->createElement("users");
		$dom->appendChild($root);
	}else{
		$dom->load(USER_LOG);
		$root = $dom->documentElement;
	}
	$u =  $dom->createElement("user");
	$n =  $dom->createElement("name",$name);
	$e =  $dom->createElement("email",$email );
	$m =  $dom->createElement("msg",$msg );
	$i =  $dom->createElement("ip",$ip );
	$d =  $dom->createElement("datetime",$dt);

	$u->appendChild($n);
	$u->appendChild($e);
	$u->appendChild($m);
	$u->appendChild($i);
	$u->appendChild($d);
	$root->appendChild($u);
	$dom->save(USER_LOG);
	header("Location: gbook.php");exit;
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>
	<title>Гостевая книга</title>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
</head>
<body>

<h1>Гостевая книга</h1>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

Ваше имя:<br />
<input type="text" name="name" /><br />
Ваш E-mail:<br />
<input type="text" name="email" /><br />
Сообщение:<br />
<textarea name="msg" cols="50" rows="5"></textarea><br />
<br />
<input type="submit" value="Добавить!" />

</form>

<?php
if(file_exists(USER_LOG)){
	$sxml = simplexml_load_file (USER_LOG);
	//echo $sxml->user[0]->name;
	//var_dump ($sxml);
	$users = (array)$sxml;
	if(is_array($users["user"]))
		$users = array_reverse($users["user"]);
	else
		$users = (array)$users["user"]; // если только одна запись
	foreach($users as $user){
		echo "<p><a href=\"mailto:$user->email\">".$user->name."</a> от ".date("d-m-Y H:m:s",(int)$user->datetime)." с ip {$user->ip}<p>".
		nl2br($user->msg)
		."<hr>";
	} 
}
?>

</body>
</html>