<?php

require_once '../phpQuery/phpQuery/phpQuery.php';
require_once '../cURL/curl.php';

init_console();

	$count=0;
	$domObjc = new DomDocument();
	$domObjc->load('fe697b261c1ec6.xml');
	$root = $domObjc->documentElement;
	foreach($root->childNodes as $items){
		if($items->nodeName == 'items'){
			foreach($items->childNodes as $item){
				if($item->nodeName == 'item'){
					foreach($item->childNodes as $param){
						if($param->nodeName == 'url'){
                            $result=0;
                            $matches='';
                            $price='';
                            $oldprice='';
                            $avilabiliti='';
                            $result = preg_match('~[^http://|https://].+~im', $param->textContent, $matches);
                            if(!$result)
                                continue;
							echo "<a href=\"{$param->textContent}\" target=\"_blank\">{$param->textContent}</a><br>";
							//echo "<a href=\"https://marketopt.zakupka.com/p/345327717-koshelek-premium-klassa-pierre-cardin-chernyy-franciya/\" target=\"_blank\">https://marketopt.zakupka.com/p/345327717-koshelek-premium-klassa-pierre-cardin-chernyy-franciya/</a><br>";
							$count++;
                            $resalt = SendRequest($param->textContent);
                            //$resalt = SendRequest('https://marketopt.zakupka.com/p/345327717-koshelek-premium-klassa-pierre-cardin-chernyy-franciya/');
                            //var_dump(htmlspecialchars($resalt[1], ENT_QUOTES));exit;
                            echo $resalt[0].'<br>';
                            $pq = phpQuery::newDocument($resalt[1]);//,'utf-8','windows-1251'
                            $price = $pq->find('meta[itemprop="price"]')->attr('content');
                            //$oldprice = $pq->find('[itemprop="offers"] .old_price')->html();
                            //var_dump($pq->find('.b-product__box .b-availability_status_not-available')->html());exit;//.b-sect__block_product .b-product__availability .b-availability_status_not-available
                            if($avilabiliti=$pq->find('.b-product__box .b-availability_status_not-available')->html()){
                                $avilabiliti = 0;
                            }
                            phpQuery::unloadDocuments($pq);
                            /*echo 'Цена - '.$price.'<br>';
                            //echo 'Стара цена - '.$oldprice.'<br>';
                            echo 'Наявность - '.$avilabiliti.'<br>';*/
						}
                       if($param->nodeName == 'priceRUAH'){
						    if($price or $resalt[0]=='404' ){
                                echo '<p>Цена з хмл - '.$param->textContent.' -> '.$price.'<br>';
                                $param->textContent = $price;
                            }else{
                                echo '<p>Цена з хмл - '.$param->textContent.' -> <div style="background: mediumvioletred;">000</div><br>';
                            }
                        }
                        /*if($param->nodeName == 'oldprice'){
                            echo 'Стара цена з хмл - '.$param->textContent.'<br>';
                        }*/
                        if($param->nodeName == 'stock'){
                            if($avilabiliti!==''){
                                echo 'Наявность з хмл - '.$param->textContent.' -> <div style="background: yellow;">'.$avilabiliti.'</div></p><hr>';
                                $param->textContent = $avilabiliti;
                            }
                            //if($count==10)break(3);
                        }
					}
				}
			}
		}
	}
	echo "$count";
    $domObjc->save('test.xml');


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






