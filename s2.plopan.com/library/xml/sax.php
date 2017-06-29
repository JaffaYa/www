<?php
	function onStart($xml,$tag,$attributes){
		if ('BOOK'!=$tag and 'CATALOG'!=$tag){
			echo "<td align=\"center\">";
		}
		if ('BOOK'==$tag){
			echo "<tr>";
		}
	}
	function onEnd($xml,$tag){
		if ('BOOK'!=$tag and 'CATALOG'!=$tag){
			echo "</td>";
		}
		if ('BOOK'==$tag){
			echo "</tr>";
		}
	}
	function onText($xml,$data){
		//echo "<p>Крутяк текст $data \n\r";
		echo $data;
	}
	
	$parser = xml_parser_create("UTF-8");
	xml_set_element_handler($parser,"onStart","onEnd");
	xml_set_character_data_handler($parser,"onText"); 
?>
<html>
	<head>
		<title>Каталог</title>
	</head>
	<body>
	<h1>Каталог книг</h1>
	<table border="1" width="100%">
		<tr>
			<th>Автор</th>
			<th>Название</th>
			<th>Год издания</th>
			<th>Цена, руб</th>
		</tr>
	<?php
		/*$handle=fopen('catalog.xml','r');
			while ($string=fgets($handle)){
				//echo "<p>".addslashes($string);
				xml_parse($parser,$string);
			}
		fclose($handle);*/
		xml_parse($parser,file_get_contents('catalog.xml'));
	?>
	</table>
	</body>
</html>