<?php
class Award
{
    public static function select($condition)
    {
        if ($condition == "") {
            $condition=1;
        }
        $query = "select a.*   ";
        $query.= " , b.company_name ";
        $query.= " from award a    ";
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
        $query = "select * from award where award_id=$id ";
        $result = mysqli_query($_SESSION["db_conn"], $query);
        $data = mysqli_fetch_object($result);
        return $data;
    }
    public static function save($id, $award_title, $award_details, $award_date, $award_order, $award_image, $company_id)
    {
        if ($id == "") {
            $query = "insert into award set `award_title` = '$award_title' , `award_details` = '$award_details' , `award_date` = '$award_date' , `award_order` = '$award_order' , `award_image` = '$award_image' , `company_id` = '$company_id'  ";
        } else {
            $query = "update award set `award_title` = '$award_title' , `award_details` = '$award_details' , `award_date` = '$award_date' , `award_order` = '$award_order' , `award_image` = '$award_image' , `company_id` = '$company_id'  where award_id = $id";
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
        $query = "delete from award where award_id=$id ";
        mysqli_query($_SESSION["db_conn"], $query);

        if (mysqli_affected_rows($_SESSION["db_conn"])>0) {
            return true;
        } else {
            return false;
        }
    }
    public static function updateCondition($id, $condition)
    {
        $query = "update award set $condition where award_id=$id ";
        mysqli_query($_SESSION["db_conn"], $query);

        if (mysqli_affected_rows($_SESSION["db_conn"])>0) {
            return true;
        } else {
            return false;
        }
    }
    public static function count($condition)
    {
        $query = "select count(*) as cc from award a where $condition";
        $result = mysqli_query($_SESSION["db_conn"], $query);
        $data = mysqli_fetch_object($result);
        return $data->cc;
    }
}
