<?php
function steamkey()
{
    $key = '';
    for ($i = 0; $i < 3; $i++, $key .= "-") {
        for ($j = 0; $j < 5; $j++) {
            $key .= chr(rand(65, 90));
        }
    }
    return substr($key, 0, strlen($key) - 1);
}

echo steamkey() . '<br>';
?>