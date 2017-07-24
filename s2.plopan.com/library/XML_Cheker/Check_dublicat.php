<?php

/*require_once '../phpQuery/phpQuery/phpQuery.php';
require_once '../cURL/curl.php';*/
define('FILE_NAME','test.xml');

init_console();

	$count=0;
	$domObjc = new DomDocument();
	$domObjc->load(FILE_NAME);
	$root = $domObjc->documentElement;

	foreach($root->childNodes as $zagolovki){
		if($zagolovki->nodeName == 'items'){
			foreach($zagolovki->childNodes as $item){//перебор товарів
				if($item->nodeName == 'item'){
					foreach($item->childNodes as $param){
						if($param->nodeName == 'id'){
                            $i=0;
                            //--------
                            foreach($root->childNodes as $zagolovki1){
                                if($zagolovki1->nodeName == 'items'){
                                    foreach($zagolovki1->childNodes as $item1){//перебор товарів
                                        if($item1->nodeName == 'item'){
                                            foreach($item1->childNodes as $id){
                                                if($id->nodeName == 'id'){
                                                    if($id->textContent=='') continue;
                                                    if($param->textContent===$id->textContent){
                                                        if($i>=1){
                                                            echo "$param->textContent===$id->textContent<br>";
                                                            $count++;
                                                        }
                                                        $i++;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                            //------
						}
					}
				}
			}
		}
	}

	echo "$count";
    $domObjc->save(FILE_NAME);


function init_console()
{
    # Internal Server Error fix in case no apache_setenv() function exists
    if (function_exists('apache_setenv'))
    {
        @apache_setenv('no-gzip', 1);
    }
    @ini_set('zlib.output_compression', 0);
    @ini_set('implicit_flush', 1);
    for ($i = 0; $i < ob_get_level(); $i++)
        ob_end_flush();
    ob_implicit_flush(1);
}
?>






