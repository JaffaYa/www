<?php
	$domObjc = new DomDocument();
	$domObjc->load('catalog.xml');
	$root = $domObjc->documentElement;
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
	foreach($root->childNodes as $book){
		if($book->nodeType == 1){
			echo '<tr>';
			foreach($book->childNodes as $entry){
				if($entry->nodeType == 1){
					echo '<td>';
						echo $entry->textContent;
					echo '</td>';
				}
			}
			echo '</tr>';
		}
	}
?>
	</table>
</body>
</html>





