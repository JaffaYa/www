<?php
	class User extends AUser {
		public $name;
		public $login;
		public $password;
		const INFO_TITLE = "Данные пользователя";
		static $countUser=0;
		public $userNumb;
		
		public function __construct ($nx = 65,$ny = 90, $lx = 65,$ly = 90, $px = 65,$py = 90){
			self::$countUser++;
			$this->userNumb=self::$countUser;
			try {	
			$this->name = chr(rand($nx,$ny)) . chr(rand($nx,$ny)) . chr(rand($nx,$ny)) . chr(rand($nx,$ny)) . chr(rand($nx,$ny));
			$this->login = chr(rand($lx,$ly)) . chr(rand($lx,$ly)) . chr(rand($lx,$ly)) . chr(rand($lx,$ly)) . chr(rand($lx,$ly));
			$this->password = chr(rand($px,$py)) . chr(rand($px,$py)) . chr(rand($px,$py)) . chr(rand($px,$py)) . chr(rand($px,$py));
			if ($px>122) throw new Exception("Ай млодець</br>");
			}catch(Exception $e){
				
			}
		}
		
		function showTitle(){
			echo '<h3>'.self::INFO_TITLE." №".$this->userNumb.':</h3>';
		}
		
		function __destruct (){
			echo "<p>Об'экт удальон.</br>";
		}
		
		function __clone(){
			self::$countUser++;
			$this->userNumb=self::$countUser;
			$this->name = "Guest";
			$this->login = "guest";
			$this->password = "qwerty";
		}
		
		public function showInfo(){
			echo "<p>Им'я = $this->name</br>";
			echo "Логин = $this->login</br>";
			echo "Пароль = $this->password</br>";
			//if($e->getMessage()) echo $e->getMessage();
			//echo gettype(Exception $e);
		}
		
		function getInfo(){
			/*$array["Им'я"] = $this->name;
			$array["Логин"] = $this->login;
			$array["Пароль"] = $this->password;
			$array["Роль"] = $this->role;
			return $array;*/
		}
	}
?>