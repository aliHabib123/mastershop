<?php

require "session_start.php";
include "config.php";
include "change_format.php";
include "resize.php";
include '../module/Application/src/Model/include_dao.php';

$userMysqlExtDAO = new UserMySqlExtDAO();

$result = false;
$msg = "Error";
extract($_POST);
$active = isset($active) ? $active : 0;
$status = (radio_button($active) == 1) ? 'active' : 'inactive';

$user = ($action == 'edit') ? $userMysqlExtDAO->load($id) : new User();
$user->companyName = $company_name;
$user->firstName = $first_name;
$user->lastName = $last_name;
$user->middleName = $middle_name;
$user->fullName = $first_name . " " . $middle_name . " " . $last_name;
$user->email = $email;
$user->mobile = $mobile;
$user->tel1 = $tel1;
$user->tel2 = $tel2;
$user->status = $status;

if($company_name == "" || $first_name == "" || $last_name == "" || $email == "" ){
    $msg = "Please fill all required fields marked with *";
} else {
    if($action == 'edit'){
        $res = $userMysqlExtDAO->update($user);
        if($res){
            $result = true;
            $msg = "User Updated successfully";
        }
    } elseif ($action == 'new'){
        $user->userType = 2;
        $res = $userMysqlExtDAO->insert($user);
        if($res){
            $result = true;
            $msg = "User inserted successfully";
        }
    }
}

echo json_encode([
    'status' => $result,
    'msg' => $msg,
]);
// header("Location: display_supplier.php?act=".$act);
// exit();
