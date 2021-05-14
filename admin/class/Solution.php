<?php
class Solution
{
    public static function select($condition)
    {
        if ($condition == "") {
            $condition=1;
        }
        $query = "select a.*   ";
        $query.= " from solution a    ";
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
        $query = "select * from solution where solution_id=$id ";
        $result = mysqli_query($_SESSION["db_conn"], $query);
        $data = mysqli_fetch_object($result);
        return $data;
    }
    public static function save($id, $solution_title, $solution_subtitle, $solution_details, $solution_image, $solution_date, $solution_order, $solution_active, $slug)
    {
        if ($id == "") {
            $query = "insert into solution set `solution_title` = '$solution_title' , `solution_subtitle` = '$solution_subtitle', `solution_details` = '$solution_details' , `solution_image` = '$solution_image' , `solution_date` = '$solution_date' ,`solution_order` = '$solution_order', `solution_active` = '$solution_active', `solution_slug` = '$slug'  ";
        } else {
            $query = "update solution set `solution_title` = '$solution_title' ,`solution_subtitle` = '$solution_subtitle', `solution_details` = '$solution_details' , `solution_image` = '$solution_image' , `solution_date` = '$solution_date' ,`solution_order` = '$solution_order', `solution_active` = '$solution_active', `solution_slug` = '$slug'  where solution_id = $id";
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
        $query = "delete from solution where solution_id=$id ";
        mysqli_query($_SESSION["db_conn"], $query);

        if (mysqli_affected_rows($_SESSION["db_conn"])>0) {
            return true;
        } else {
            return false;
        }
    }
    public static function updateCondition($id, $condition)
    {
        $query = "update solution set $condition where solution_id=$id ";
        mysqli_query($_SESSION["db_conn"], $query);

        if (mysqli_affected_rows($_SESSION["db_conn"])>0) {
            return true;
        } else {
            return false;
        }
    }
    public static function count($condition)
    {
        $query = "select count(*) as cc from solution a where $condition";
        $result = mysqli_query($_SESSION["db_conn"], $query);
        $data = mysqli_fetch_object($result);
        return $data->cc;
    }
}
