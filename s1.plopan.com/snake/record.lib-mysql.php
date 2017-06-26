<?php
function readRecords (){// зчитування рекордів
	// зчитування рекордів
	if (!($records = my_readFile())) 
		return;
	if (mysqli_num_rows($records)>0){
		//вивод результата
		echo "<table>";
		while ($row = mysqli_fetch_assoc($records)){
			echo "<tr>";
			echo "<td>".$row['name']."</td>";
			echo "<td>".$row['rec']."</td>";
			echo "</tr>";
		}
		echo "</table>";
	}else
		echo 'Необнаружено ни 1 рекорда!';
}


function writeResoult(){// запісь рекорда
	$records = array();
	$name = '';	
	$resout = 0;
	$delId = '';

	// зчитування рекордa методом пост
	if(!empty($_POST["name"])) 
		$name=substr(trim(strip_tags($_POST["name"])),0,100);// защіта от дурака
	if(!empty($_POST["resout"])) 
		$resout=(int)$_POST["resout"];
	
	if($name!=''){
		$conn = mysqli_connect("localhost","root","root","snake");
		$textQueri = "INSERT INTO records (name, rec)
		VALUES('$name', '$resout')";
		mysqli_query($conn ,$textQueri);
		echo mysqli_error($conn);
		mysqli_close($conn);
	}
	
	$records = my_readFile();
	while (mysqli_num_rows($records)>5){
		$conn = mysqli_connect("localhost","root","root","snake");
		$textQueri = "	SELECT * 
						FROM records 
						ORDER BY rec 
						LIMIT 1";
		$records = mysqli_query($conn ,$textQueri);
		while ($row = mysqli_fetch_assoc($records)){
			$delId = $row['id'];
		}
		$textQueri = "DELETE FROM records WHERE id = $delId";
		mysqli_query($conn ,$textQueri);
		echo mysqli_error($conn);
		mysqli_close($conn);
	}
	
	if($_SERVER['REQUEST_METHOD']=='POST'){
		header ("Location: ".$_SERVER["PHP_SELF"]);
		exit;
	}
}

function my_readFile(){// зчитування файла, вертає двовимірний масів рекордів або false
	$conn = mysqli_connect("localhost","root","root","snake");
	$textQueri = "SELECT * FROM records ORDER BY rec DESC";
	$resoult = mysqli_query($conn ,$textQueri);
	echo mysqli_error($conn);
	mysqli_close($conn);
	return $resoult;
}

?>