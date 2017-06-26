<?php	
	function __autoload($name){
		include "$name.class.php";
	}
	
	$users = array();
	for ($i=0;$i<3;$i++){
		$users[$i] = new User(65,90,97,122);
	}
	$users[] = clone $users[0];
	$users[9] = new SuperUser(9,65,90,97,122,123,255,'admin');
	
	foreach($users as $user){
		$user->showTitle();
		$user->showInfo();
		checkObject($user);
		//print_r($user->getInfo());
	}
	echo "<hr>Обычных юзеров - ".User::$countUser.".</br>Админов - ".SuperUser::$countSUser.".</br>";
	
	function checkObject($object){
		if($object instanceOf SuperUser){
			echo "Данный пользователь обладает правами администратора.";
		}elseif($object instanceOf User){
			echo "Данный пользователь является обычным пользователем.";
		}else{
			echo "Данный пользователь - неизвестный пользователь.";
		}
	}
?>