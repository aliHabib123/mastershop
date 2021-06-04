<?php

require "session_start.php";
include "config.php";
include "change_format.php";
include "resize.php";
include '../module/Application/src/Model/include_dao.php';

$itemTagMappingMySqlExtDAO = new ItemTagMappingMySqlExtDAO();

extract($_POST);
$todays_deals = radio_button($todays_deals);
$latest_arrivals = radio_button($latest_arrivals);
$picked_for_you = radio_button($picked_for_you);
$daily_deals = radio_button($daily_deals);
$best_offers = radio_button($best_offers);

$tags = [
    '1' => $todays_deals, //todays-deals
    '2' => $latest_arrivals, //latest-arrivals
    '3' => $picked_for_you, //picked-for-you
    '4' => $daily_deals, //daily-deals
    '5' => $best_offers, //best-offers
    '6' => $spotlight, //best-offers
];
$itemTagMappingMySqlExtDAO->deleteByItemId($id);
foreach ($tags as $key => $val) {
    if ($val) {
        $obj = new ItemTagMapping();
        $obj->itemId = $id;
        $obj->tagId = $key;
        $insert = $itemTagMappingMySqlExtDAO->insert($obj);
        if ($insert) {
            $num++;
        }
    }
}


if ($num > 0) {
    $act = 3;
} else {
    $act = 4;
}

header("Location: display_product.php?act=" . $act);
exit();
