<?php 

function getRandomWord($len = 6) 
{
    $word = array_merge(range('a', 'z'), range(0, 9)); 
    shuffle($word);
    return substr(implode($word), 0, $len);
}

function getRandomColor() {
    return sprintf('#%06X', mt_rand(0xFF99AA, 0xFFFF00));
}

function convertTime($time)
{
    return date("g:i a", strtotime($time));
}

?>