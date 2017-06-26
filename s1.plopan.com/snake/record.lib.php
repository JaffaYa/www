<?php
define ('MY_FILE_NAME','ReckordList.rec');  // Ім'я фала по замовчуванню

function readRecords ($nameOfFile = MY_FILE_NAME, $counOutPut = 5){// зчитування рекордів, можна вказати своє ім'я файла, та кількість значень рекордів які будуть виводитись в результаті
	$ii=1;// лічильник для кількості значень рекордів які будуть виводитись в результаті
	
	// зчитування рекордів
	if (!($records = my_readFile($nameOfFile))) 
		return;
	if (is_array($records) and count($records)>0){
		
		$records = sorting($records);// сортіровка масіва
		
		//вивод результата
		echo "<table>";
		foreach($records as $stR)  {
		echo "<tr>";
					echo "<td>";
						echo $stR[0];
					echo "</td>";
					echo "<td>";
						echo $stR[1];
					echo "</td>";
		echo "</tr>";
		if (++$ii>$counOutPut)
			break;
		}
		echo "</table>";
	}else
		echo 'Необнаружено ни 1 рекорда!';
}

function sorting($records){// сортування масива
	for ($x = 0; $x < (count($records)); $x++) {
		for ($y = 0; $y < (count($records)); $y++) {
			if ($records[$x][1] > $records[$y][1]) {
				$hold = $records[$x];
				$records[$x] = $records[$y];
				$records[$y] = $hold;
			}
		}
	}
	return $records;
}

function writeResoult($nameOfFile = MY_FILE_NAME, $counInPut = 5){// запісь рекорда, можна вказати своє ім'я файла та кількість значень рекордів які будуть перезаписуватись в файл
	$records = array();
	$record1 = array();
	$name = '';	
	$resout = 0;
	$jj=1;// лічильник для кількості значень рекордів які будуть перезаписуватись в файл

	// зчитування рекордa методом пост
	if(!empty($_POST["name"])) 
		$name=substr(trim(strip_tags($_POST["name"])),0,100);// защіта от дурака
	if(!empty($_POST["resout"])) 
		$resout=(int)$_POST["resout"];
		
	// зчитування рекордів
	if (!($records = my_readFile($nameOfFile))) 
		return;
	if (is_array($records) and count($records)>0)	
		$records = sorting($records);// сортіровка масіва
	
	// запісь рекордів в файл
	if ($name!=''){
		$fp = fopen($nameOfFile, "w");
			foreach($records as $stR)  {
				fwrite($fp, "{$stR[0]}_{$stR[1]}\n"); // Запись в файл попередніх рекордів 
				if (++$jj>$counInPut)
					break;
			}
			fwrite($fp, "{$name}_{$resout}\n",20); // Запись в файл поточного рекорда
		fclose($fp);
	}
	if($_SERVER['REQUEST_METHOD']=='POST'){
	header ("Location: ".$_SERVER["PHP_SELF"]);
	exit;
	}
}

function my_readFile($fileName){// зчитування файла, вертає двовимірний масів рекордів або false
	$records = array();
	$record1 = array();
	
	if ($fileRecords=file($fileName)){
		foreach($fileRecords as $k=>$stR)  { 
			$record = explode("_", $stR);
			if (isset($record[0])){
				array_push ($records, $record1 = array($record[0],(int)$record[1]));
			}
		}
		return $records;
	}else {
		echo 'Неудалось прочитать файл.';
		return false;
	} 
}

?>