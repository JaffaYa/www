<?php

//Код проверки для дальнейшего парсинга страницы
return $doc->find('div')->hasClass('post-outer');


//ID сущности
$nid = str_replace('http://musclefit.info/', '', $page_url);
return $nid;


//PHP код для поля Заголовок 
return $doc->find('h1.entry-title')->text();

//PHP код для поля Текст основного поля body
$doc->find('br')->remove();
$doc->find('center')->remove();
$doc->find('p[style^=border-left: 2px]')->remove();
$doc->find('script')->remove();

//удаление ссылок
foreach ($doc->find('.post_content a') as $a) {
  $text = pq($a)->text();
  pq($a)->parent()->append($text);
  pq($a)->remove();
}

//ищем контент
$alltext = $doc->find('.post_content)')->html();

//удаляем все ссылки, но оставляем текст
$alltext = preg_replace("#<a href=[^>]*>(.*?)<\/a>#is", "\$1", $alltext);

//обрезаем конец сраницы
$alltext = strstr ($alltext, '<h3>Смотрите также', true);

// удаляем первую фотографию 
$matches;
preg_match("/<img[^>]+\>/i", $alltext, $matches);
$alltext = str_replace($matches[0], '', $alltext);

$type='full_html';//'PHP code'//'Plain text'//'Filtered HTML'//'full_html'

$matches1;
preg_match("/<table[^>]*\>/i", $alltext, $matches1);
If ($matches1)
  $type='php_code';

return  array(
  'value' => $alltext,
  'format' => $type
);

//PHP код для поля Image
$file = $doc->find('img.size-full')->attr('src');
return array(
  'file' => $file,
);

//PHP код для поля Язык
return 'ru';
















?>