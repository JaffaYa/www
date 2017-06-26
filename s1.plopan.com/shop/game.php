<?php
	require "eshop_db.inc.php";
	require "eshop_lib.inc.php";

	if(!empty($_GET["id"])) 
		$id=(int)$_GET["id"];
	$descriptions = selectDesc($id);	
?>
<div>
<p><img src="<?=$descriptions[0]['img'];?>" alt="Тутотчки картинка">
<p><?=$descriptions[0]['description'];?>
<h1>Дополнительное описание</h1>
<p><?=$descriptions[0]['adddesc'];?>
</div>
<div>
</div>
<div align="center">
	<input type="button" value="Оформить заказ!"
                      onClick="location.href='#'">
</div>