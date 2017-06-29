<?php
	class SuperUser extends User implements ISuperUser {
		public $role;
		static $countSUser=0;
		public $suserNumb=0;
		
		
		public function __construct ($i, $nx = 65,$ny = 90, $lx = 65,$ly = 90, $px = 65,$py = 90, $role){
			self::$countSUser++;
			$this->suserNumb=self::$countSUser;
			self::$countUser--;
			parent::__construct($nx,$ny,$lx,$ly,$px,$py);
			$this->role = $role;
		}
		
		function showTitle(){
			echo "<h3>Данные админа №".$this->suserNumb.':</h3>';
		}
		
		function showInfo(){
			parent:: showInfo();
			echo "Роль = ".$this->role.'</br>';
		}
		
		function getInfo(){
			$array = array();
			foreach ($this as $k=>$v) {
				$array[$k] = $v;
			}
			return $array;
		}
	}
?>