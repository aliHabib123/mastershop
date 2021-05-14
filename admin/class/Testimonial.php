<?php
class Testimonial
{
    public static function select($condition)
    {
        if ($condition == "") {
            $condition=1;
        }
        $query = "select * from testimonial where $condition ";
        $result = mysqli_query($_SESSION["db_conn"], $query);
        $objects = array();
        while ($data = mysqli_fetch_object($result)) {
            array_push($objects, $data);
        }
    
        return $objects;
    }
    public static function selectById($id)
    {
        $query = "select * from testimonial where testimonial_id=$id ";
        $result = mysqli_query($_SESSION["db_conn"], $query);
        $data = mysqli_fetch_object($result);
        return $data;
    }
    public static function save($id, $testimonial_name, $testimonial_gender, $testimonial_message, $testimonial_date_published, $company_id)
    {
        if ($id == "") {
            $query = "insert into testimonial set `testimonial_name` = '$testimonial_name' , `testimonial_gender` = '$testimonial_gender' , `testimonial_message` = '$testimonial_message' , `testimonial_date_published` = '$testimonial_date_published' , `company_id` = '$company_id'  ";
        } else {
            $query = "update testimonial set `testimonial_name` = '$testimonial_name' , `testimonial_gender` = '$testimonial_gender' , `testimonial_message` = '$testimonial_message' , `testimonial_date_published` = '$testimonial_date_published' , `company_id` = '$company_id'  where testimonial_id = $id";
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
        $query = "delete from testimonial where testimonial_id=$id ";
        mysqli_query($_SESSION["db_conn"], $query);

        if (mysqli_affected_rows($_SESSION["db_conn"])>0) {
            return true;
        } else {
            return false;
        }
    }
    public static function updateCondition($id, $condition)
    {
        $query = "update testimonial set $condition where testimonial_id=$id ";
        mysqli_query($_SESSION["db_conn"], $query);

        if (mysqli_affected_rows($_SESSION["db_conn"])>0) {
            return true;
        } else {
            return false;
        }
    }
    public static function count($condition)
    {
        $query = "select count(*) as cc from testimonial where $condition";
        $result = mysqli_query($_SESSION["db_conn"], $query);
        $data = mysqli_fetch_object($result);
        return $data->cc;
    }
}
