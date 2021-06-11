<?php

/**
 * Prepare date for mysql
 * @param unknown $date
 * @return string
 */
function change_format($date)
{
    list($mon, $day, $year) = explode("/", $date);
    $new_date = $year . "-" . $mon . "-" . $day;
    return $new_date;
}

/**
 * Prepare date to display in input
 * @param unknown $date
 * @return string
 */
function change_format2($date)
{
    list($year, $mon, $day) = explode("-", $date);
    $new_date = $mon . "/" . $day . "/"  . $year; //06/24/2015
    return $new_date;
}

/**
 * return mysql datetime format
 * @param string $datetime "11 June 2015 - 06:52 PM"
 * @return string
 */
function change_timeformat($datetime)
{
    $datetime = str_replace("-", " ", $datetime);
    $datetime = DateTime::createFromFormat("j M Y H:i A", $datetime); //12 June 2015 - 03:12 PM
    if (is_object($datetime) == false) {
        return;
    }
    $date = $datetime->format("Y-m-d");
    $time = $datetime->format("H:i:s");
    $datetime = $date . " " . $time;
    return $datetime;
}


/**
 * return mysql datetime format
 * @param string $datetime "11 June 2015 - 06:52 PM"
 * @return string
 */
function reverse_change_timeformat($mysql_datetime)
{
    //$datetime = str_replace("-", " ", $datetime);
    //return $mysql_datetime;
    $datetime = DateTime::createFromFormat("Y-m-d H:i:s", $mysql_datetime); //2015-06-12 15:23:00
    if (is_object($datetime) == false) {
        return "Not a valid mysql datetime";
    }
    $date = $datetime->format("j F Y");
    $time = $datetime->format("h:i A");
    $datetime = $date . " - " . $time;
    return $datetime;
}

/**
 * change the switch on/off to tinyint
 * @param unknown $switchValue
 */
function radio_button($switchValue)
{
    if ($switchValue == "on") {
        return 1;
    }
    return 0;
}

function slugify($text, string $divider = '-')
{
    // replace non letter or digits by divider
    $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

    // transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);

    // trim
    $text = trim($text, $divider);

    // remove duplicate divider
    $text = preg_replace('~-+~', $divider, $text);

    // lowercase
    $text = strtolower($text);

    if (empty($text)) {
        return 'n-a';
    }

    return $text;
}

function random($length = 10)
{
    $chars = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $size = strlen($chars);
    $str = "";
    for ($i = 0; $i < $length; $i++) {
        $str .= $chars[rand(0, $size - 1)];
    }
    return $str;
}
