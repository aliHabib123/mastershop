<?php
class Partner
{
    public static function select($condition)
    {
        if ($condition == "") {
            $condition=1;
        }
        $query = "select * from partner where $condition ";
        $result = mysqli_query($_SESSION["db_conn"], $query);
        $objects = array();

        while ($data = mysqli_fetch_object($result)) {
            array_push($objects, $data);
        }
        return $objects;
    }
    public static function selectById($id)
    {
        $query = "select * from partner where partner_id=$id ";
        $result = mysqli_query($_SESSION["db_conn"], $query);
        $data = mysqli_fetch_object($result);
        return $data;
    }
    public static function save($id, $partner_firstname, $partner_lastname, $partner_username, $partner_password, $partner_image, $partner_link, $company_id, $is_trusted)
    {
        if ($id == "") {
            $query = "insert into partner set `partner_firstname` = '$partner_firstname' , `partner_lastname` = '$partner_lastname' , `partner_username` = '$partner_username' , `partner_password` = '$partner_password' , `partner_image` = '$partner_image' , `partner_link` = '$partner_link' , `company_id` = '$company_id' , `is_trusted` = '$is_trusted' ";
        } else {
            $query = "update partner set `partner_firstname` = '$partner_firstname' , `partner_lastname` = '$partner_lastname' , `partner_username` = '$partner_username' , `partner_password` = '$partner_password' , `partner_image` = '$partner_image' , `partner_link` = '$partner_link' , `company_id` = '$company_id', `is_trusted` = '$is_trusted'  where partner_id = $id";
        }
        mysqli_query($_SESSION["db_conn"], $query);
        if (mysqli_affected_rows($_SESSION["db_conn"])>0) {
            return true;
        } else {
            return false;
        }
    }
    public static function delete($id)
    {
        $query = "delete from partner where partner_id=$id ";
        mysqli_query($_SESSION["db_conn"], $query);

        if (mysqli_affected_rows($_SESSION["db_conn"])>0) {
            return true;
        } else {
            return false;
        }
    }
    public static function updateCondition($id, $condition)
    {
        $query = "update partner set $condition where partner_id=$id ";
        mysqli_query($_SESSION["db_conn"], $query);

        if (mysqli_affected_rows($_SESSION["db_conn"])>0) {
            return true;
        } else {
            return false;
        }
    }
    public static function count($condition)
    {
        $query = "select count(*) as cc from partner where $condition";
        $result = mysqli_query($_SESSION["db_conn"], $query);
        $data = mysqli_fetch_object($result);
        return $data->cc;
    }
}
