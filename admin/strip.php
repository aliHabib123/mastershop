<?php
function strip($string, $length, $append = ' . . .')
{
    $string=str_replace('&nbsp;', ' ', $string);
    $string=trim($string);
    $string=strip_tags($string);

    return strlen($string) > $length ? substr($string, 0, strpos($string, ' ', $length)) . $append  : $string;
}
