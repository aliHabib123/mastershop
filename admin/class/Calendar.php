<?php
class Calendar
{
    public static function select($condition)
    {
        if ($condition == "") {
            $condition=1;
        }
        $query = "select a.*   ";
        $query.= " , b.company_name ";
        $query.= " from calendar a    ";
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
        $query = "select * from calendar where calendar_id=$id ";
        $result = mysqli_query($_SESSION["db_conn"], $query);
        $data = mysqli_fetch_object($result);
        return $data;
    }
    public static function save($id, $calendar_title, $start_date, $end_date, $calendar_link, $is_active, $company_id)
    {
        if ($id == "") {
            $query = "insert into calendar set `calendar_title` = '$calendar_title' , `start_date` = '$start_date' , `end_date` = '$end_date' , `calendar_link` = '$calendar_link' , `is_active` = '$is_active' , `company_id` = '$company_id'  ";
        } else {
            $query = "update calendar set `calendar_title` = '$calendar_title' , `start_date` = '$start_date' , `end_date` = '$end_date' , `calendar_link` = '$calendar_link' , `is_active` = '$is_active' , `company_id` = '$company_id'  where calendar_id = $id";
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
        $query = "delete from calendar where calendar_id=$id ";
        mysqli_query($_SESSION["db_conn"], $query);

        if (mysqli_affected_rows($_SESSION["db_conn"])>0) {
            return true;
        } else {
            return false;
        }
    }
    public static function updateCondition($id, $condition)
    {
        $query = "update calendar set $condition where calendar_id=$id ";
        mysqli_query($_SESSION["db_conn"], $query);

        if (mysqli_affected_rows($_SESSION["db_conn"])>0) {
            return true;
        } else {
            return false;
        }
    }
    public static function count($condition)
    {
        $query = "select count(*) as cc from calendar a where $condition";
        $result = mysqli_query($_SESSION["db_conn"], $query);
        $data = mysqli_fetch_object($result);
        return $data->cc;
    }
}
