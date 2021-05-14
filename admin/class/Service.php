<?php
class Service
{
    public static function select($condition)
    {
        if ($condition == "") {
            $condition=1;
        }
        $query = "select * from service where $condition ";
        $result = mysqli_query($_SESSION["db_conn"], $query);
        $objects = array();
        while ($data = mysqli_fetch_object($result)) {
            array_push($objects, $data);
        }
    
        return $objects;
    }
    public static function selectById($id)
    {
        $query = "select * from service where service_id=$id ";
        $result = mysqli_query($_SESSION["db_conn"], $query);
        $data = mysqli_fetch_object($result);
        return $data;
    }
    public static function save($id, $service_title, $service_details, $service_image, $service_order, $company_id, $slug)
    {
        if ($id == "") {
            $query = "insert into service set `service_title` = '$service_title' , `service_details` = '$service_details' , `service_image` = '$service_image', `service_order` = '$service_order' , `company_id` = '$company_id', `service_slug` = '$slug'  ";
        } else {
            $query = "update service set `service_title` = '$service_title' , `service_details` = '$service_details' , `service_image` = '$service_image' , `service_order` = '$service_order' ,`company_id` = '$company_id', `service_slug` = '$slug'  where service_id = $id";
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
        $query = "delete from service where service_id=$id ";
        mysqli_query($_SESSION["db_conn"], $query);

        if (mysqli_affected_rows($_SESSION["db_conn"])>0) {
            return true;
        } else {
            return false;
        }
    }
    public static function updateCondition($id, $condition)
    {
        $query = "update service set $condition where service_id=$id ";
        mysqli_query($_SESSION["db_conn"], $query);

        if (mysqli_affected_rows($_SESSION["db_conn"])>0) {
            return true;
        } else {
            return false;
        }
    }
    public static function count($condition)
    {
        $query = "select count(*) as cc from service where $condition";
        $result = mysqli_query($_SESSION["db_conn"], $query);
        $data = mysqli_fetch_object($result);
        return $data->cc;
    }
}
