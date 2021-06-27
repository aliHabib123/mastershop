<?php

use Application\Controller\MailController;

require "session_start.php";
include "config.php";
include "change_format.php";
include "resize.php";
include '../module/Application/src/Model/include_dao.php';

$optionMySqlExtDAO = new OptionsMySqlExtDAO;

$result = false;
$msg = "Error";
extract($_POST);

$option =  $optionMySqlExtDAO->load($id);

if ($value == "") {
    $msg = "Please fill all required fields marked with *";
} else {
    $res = $optionMySqlExtDAO->updateValue($id, $option->type, $value);
    if ($res) {
        $result = true;
        $msg = "Option Updated successfully";
    }
}

echo json_encode([
    'status' => $result,
    'msg' => $msg,
]);
