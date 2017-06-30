//ініціалізація
$pq = phpQuery::newDocument($html);

$price = $pq->find($tags['tag_price'])->html();
$price = $pq->find($tags['tag_price'])->test();