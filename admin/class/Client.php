<?php
class Client
{
    public static function select($condition)
    {
        if ($condition == "") {
            $condition=1;
        }
        $query = "select a.*   ";
        $query.= " , b.company_name ";
        $query.= " from client a    ";
        $query.= " LEFT OUTER JOIN company b ";
        $query.= " ON a.company_id = b.company_id ";
        $query.= "  where $condition ";
        $result = mysqli_query($_SESSION["db_conn"], $query);
        $objects = array();
        while ($data = mysqli_fetch_object($result)) {
            array_push($objects, $data);
        }
    
        return $objects;
    }
    public static function selectById($id)
    {
        $query = "select * from client where client_id=$id ";
        $result = mysqli_query($_SESSION["db_conn"], $query);
        $data = mysqli_fetch_object($result);
        return $data;
    }
    public static function save($id, $client_name, $client_photo, $client_order, $client_link, $company_id)
    {
        if ($id == "") {
            $query = "insert into client set `client_name` = '$client_name' , `client_photo` = '$client_photo' , `client_order` = '$client_order' , `client_link` = '$client_link' , `company_id` = '$company_id'  ";
        } else {
            $query = "update client set `client_name` = '$client_name' , `client_photo` = '$client_photo' , `client_order` = '$client_order' , `client_link` = '$client_link' , `company_id` = '$company_id'  where client_id = $id";
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
        $query = "delete from client where client_id=$id ";
        mysqli_query($_SESSION["db_conn"], $query);

        if (mysqli_affected_rows($_SESSION["db_conn"])>0) {
            return true;
        } else {
            return false;
        }
    }
    public static function updateCondition($id, $condition)
    {
        $query = "update client set $condition where client_id=$id ";
        mysqli_query($_SESSION["db_conn"], $query);

        if (mysqli_affected_rows($_SESSION["db_conn"])>0) {
            return true;
        } else {
            return false;
        }
    }
    public static function count($condition)
    {
        $query = "select count(*) as cc from client a where $condition";
        $result = mysqli_query($_SESSION["db_conn"], $query);
        $data = mysqli_fetch_object($result);
        return $data->cc;
    }
}
