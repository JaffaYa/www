<?php
/**
 * Created by PhpStorm.
 * User: Jaffa
 * Date: 25.06.2017
 * Time: 19:19
 */

$new = htmlspecialchars("<a href='test'>Test</a>", ENT_QUOTES);
echo $new;