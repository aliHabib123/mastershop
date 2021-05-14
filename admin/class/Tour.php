<?php
class Tour
{
    public static function select($condition)
    {
        if ($condition == "") {
            $condition=1;
        }
        $query = "select * from tour a where $condition ";
        $result = mysqli_query($_SESSION["db_conn"], $query);

        $objects = array();
        while ($data = mysqli_fetch_object($result)) {
            array_push($objects, $data);
        }
    
        return $objects;
    }
    public static function selectById($id)
    {
        $query = "select * from tour where tour_id=$id ";
        $result = mysqli_query($_SESSION["db_conn"], $query);
        $data = mysqli_fetch_object($result);
        return $data;
    }
    public static function save($id, $tour_title, $tour_details, $tour_image, $tour_price, $company_id, $is_active, $is_calendar, $tour_type, $tour_start_date, $tour_end_date, $slug)
    {
        if ($id == "") {
            $query = "insert into tour set `tour_title` = '$tour_title' , `tour_details` = '$tour_details' , `tour_image` = '$tour_image' , `tour_price` = '$tour_price' ,  `tour_type` = '$tour_type', `company_id` = '$company_id', `is_acitve` = '$is_active', `is_calendar` = '$is_calendar' , `tour_start_date` = '$tour_start_date' , `tour_end_date` = '$tour_end_date', `tour_slug` = '$slug'  ";
        } else {
            $query = "update tour set `tour_title` = '$tour_title' , `tour_details` = '$tour_details' , `tour_image` = '$tour_image' , `tour_price` = '$tour_price'  `tour_type` = '$tour_type', `company_id` = '$company_id', `is_acitve` = '$is_active', `is_calendar` = '$is_calendar', , `tour_slug` = '$slug'   where tour_id = $id";
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
        $query = "delete from tour where tour_id=$id ";
        mysqli_query($_SESSION["db_conn"], $query);

        if (mysqli_affected_rows($_SESSION["db_conn"])>0) {
            return true;
        } else {
            return false;
        }
    }
    public static function updateCondition($id, $condition)
    {
        $query = "update tour set $condition where tour_id=$id ";
        mysqli_query($_SESSION["db_conn"], $query);

        if (mysqli_affected_rows($_SESSION["db_conn"])>0) {
            return true;
        } else {
            return false;
        }
    }
    public static function count($condition)
    {
        $query = "select count(*) as cc from tour where $condition";
        $result = mysqli_query($_SESSION["db_conn"], $query);
        $data = mysqli_fetch_object($result);
        return $data->cc;
    }
}
