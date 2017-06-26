<?php
if($_SERVER['REQUEST_METHOD']=='GET'){
	$Sum = 0;
	if(!empty($_GET["sum"])) 
		$Sum = $_GET["sum"]*1;
	For ($i=0,$Suma=0; $Sum>=$i;$i++){
		$mas[] = ($Suma += $i).'</br>';
	}
}
?>
<h2>Підрахунок суми від 0 до х</h2>
<form action="<?$_SERVER['PHP_SELF']?>" method="get">
    <input type="text" name="sum"/>
    <input type="submit" value="Сума"/>
 </form>
 <?php
	if ($Suma>0) {
		echo "Сyмa = ".$mas[count($mas)-1];
		foreach ($mas as $mass){
			echo $mass;
		}
	} 

 ?>
