<?php
class Event
{
    public static function select($condition)
    {
        if ($condition == "") {
            $condition=1;
        }
        $query = "select * from event where $condition ";
        $result = mysqli_query($_SESSION["db_conn"], $query);
        $objects = array();
        while ($data = mysqli_fetch_object($result)) {
            array_push($objects, $data);
        }
    
        return $objects;
    }
    public static function selectById($id)
    {
        $query = "select * from event where event_id=$id ";
        $result = mysqli_query($_SESSION["db_conn"], $query);
        $data = mysqli_fetch_object($result);
        return $data;
    }
    public static function save($id, $event_title, $event_details, $event_datetime, $event_image, $album_id, $company_id, $is_active, $is_calendar, $slug)
    {
        if ($id == "") {
            $query = "insert into event set `event_title` = '$event_title' , `event_details` = '$event_details' , `event_datetime` = '$event_datetime' , `event_image` = '$event_image' ,`album_id` = '$album_id', `company_id` = '$company_id', `is_active` = '$is_active', `is_calendar` = '$is_calendar', `event_slug` = '$slug'  ";
        } else {
            $query = "update event set `event_title` = '$event_title' , `event_details` = '$event_details' , `event_datetime` = '$event_datetime' , `event_image` = '$event_image' ,`album_id` = '$album_id', `company_id` = '$company_id', `is_active` = '$is_active', `is_calendar` = '$is_calendar', `event_slug` = '$slug'  where event_id = $id";
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
        $query = "delete from event where event_id=$id ";
        mysqli_query($_SESSION["db_conn"], $query);

        if (mysqli_affected_rows($_SESSION["db_conn"])>0) {
            return true;
        } else {
            return false;
        }
    }
    public static function updateCondition($id, $condition)
    {
        $query = "update event set $condition where event_id=$id ";
        mysqli_query($_SESSION["db_conn"], $query);

        if (mysqli_affected_rows($_SESSION["db_conn"])>0) {
            return true;
        } else {
            return false;
        }
    }
    public static function count($condition)
    {
        $query = "select count(*) as cc from event where $condition";
        $result = mysqli_query($_SESSION["db_conn"], $query);
        $data = mysqli_fetch_object($result);
        return $data->cc;
    }
}
