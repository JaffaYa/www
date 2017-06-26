<?php
//$img = imageCreate(500,300);
$img = imageCreateTrueColor(500,300);
//$img = imageCreateFromPNG("test.png");

imageAntiAlias($img,true);
$red = imageColorAllocate($img,255,0,0);
$grean = imageColorAllocate($img,0,255,0);
$blue = imageColorAllocate($img,0,0,255);
$white = imageColorAllocate($img,0xFF,0xFF,0xFF);
$black = imageColorAllocate($img,0,0,0);
$silver = imageColorAllocate($img,192,192,192);
$orange = imageColorAllocate($img,255,150,0);

imageFilledRectangle($img,0,0,500,300,$silver);
imageLine($img,20,20,280,80,$grean); //лінія
imageRectangle($img,20,20,80,280,imageColorAllocate($img,255,255,0)); //квадрат
$points = array(0,0,100,201,300,220);
imagePolygon($img,$points,3,$blue);	// мгногогранік
//imageFilledPolygon($img,$points,3,$blue);
imageEllipse($img,303,150,150,120,$black);	//еліпс
//imageFilledEllipse($img,303,150,150,120,$black);
//imageArc($img,250,100,250,120,0,40,$blue);	//часть еліпса
//imageFilledArc($img,250,100,250,250,0,45,$blue,IMG_ARC_PIE);	//часть еліпса
//imageFilledArc($img,250,100,250,250,0,45,$blue,IMG_ARC_CHORD);	//часть еліпса
imageFilledArc($img,250,100,250,250,0,45,$blue,IMG_ARC_NOFILL | IMG_ARC_EDGED);	//часть еліпса

imageString($img,5,150,150,"Hellow!",$orange);	//текст
imageTtfText($img,50,45,300,300,$orange,"fonts/georgia.ttf","Say hello!");	//текст
imageTtfText($img,50,30,50,180,imageColorAllocate($img,252, 65, 192),"fonts/bellb.ttf","Ping!");	

imageSetPixel($img,1,1,$black);

header("Content-Type: image/png");
imagePNG($img);
?>