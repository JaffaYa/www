<?php
	$xmg = imageCreateTrueColor(500,300);
	$d=0;
	$q=255;
	for($x=0;$x<=500;$x++){
		for($y=0;$y<=300;$y++){
			$d++;
			$r=rand($d,$q);
			$g=rand($d,$q);
			$b=rand($d,$q);	
			//echo $r." ".$g." ".$b."<br>";
			imageSetPixel($xmg,$x,$y,imageColorAllocate($xmg,$r,$g,$b));	
			if($d==255)
				$d=0;
		}
	}
	
	header("Content-Type: image/png");
	imagePNG($xmg);
?>