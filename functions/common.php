<?php 

function getRandomWord($len = 6) 
{
    $word = array_merge(range('a', 'z'), range(0, 9)); 
    shuffle($word);
    return substr(implode($word), 0, $len);
}

?>