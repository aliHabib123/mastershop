<?php
class Company
{
    public static function select($condition)
    {
        if ($condition == "") {
            $condition=1;
        }
        $query = "select a.* ";
        $query.= " from company a    ";
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
        $query = "select * from company where company_id=$id ";
        $result = mysqli_query($_SESSION["db_conn"], $query);
        $data = mysqli_fetch_object($result);
        return $data;
    }
    public static function save($id, $company_name, $company_details, $company_logo, $company_color, $company_image)
    {
        if ($id == "") {
            $query = "insert into company set `company_name` = '$company_name' , `company_details` = '$company_details' , `company_logo` = '$company_logo' , `company_color` = '$company_color' , `company_image` = '$company_image'  ";
        } else {
            $query = "update company set `company_name` = '$company_name' , `company_details` = '$company_details' , `company_logo` = '$company_logo' , `company_color` = '$company_color' , `company_image` = '$company_image'  where company_id = $id";
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
        $query = "delete from company where company_id=$id ";
        mysqli_query($_SESSION["db_conn"], $query);

        if (mysqli_affected_rows($_SESSION["db_conn"])>0) {
            return true;
        } else {
            return false;
        }
    }
    public static function updateCondition($id, $condition)
    {
        $query = "update company set $condition where company_id=$id ";
        mysqli_query($_SESSION["db_conn"], $query);

        if (mysqli_affected_rows($_SESSION["db_conn"])>0) {
            return true;
        } else {
            return false;
        }
    }
    public static function count($condition)
    {
        $query = "select count(*) as cc from company a where $condition";
        $result = mysqli_query($_SESSION["db_conn"], $query);
        $data = mysqli_fetch_object($result);
        return $data->cc;
    }
}
