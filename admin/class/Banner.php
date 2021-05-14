<?php

class Banner
{
    public static function select($condition)
    {
        if ($condition == "") {
            $condition=1;
        }
        $query = "select a.*   ";
        $query.= " , b.section_name ";
        $query.= " from banner a    ";
        $query.= " LEFT OUTER JOIN section b ";
        $query.= " ON a.section_id = b.section_id ";
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
        $query = "select * from banner where banner_id=$id ";
        $result = mysqli_query($_SESSION["db_conn"], $query);
        $data = mysqli_fetch_object($result);
        return $data;
    }
    public static function save($id, $banner_caption, $banner_image, $banner_active, $section_id, $company_id, $service_id)
    {
        if ($id == "") {
            $query = "insert into banner set `banner_caption` = '$banner_caption' , `banner_image` = '$banner_image' , `banner_active` = '$banner_active' , `section_id` = '$section_id', `company_id` = '$company_id', `service_id` = '$service_id'  ";
        } else {
            $query = "update banner set `banner_caption` = '$banner_caption' , `banner_image` = '$banner_image' , `banner_active` = '$banner_active' , `section_id` = '$section_id' , `company_id` = '$company_id', `service_id` = '$service_id'  where banner_id = $id";
        }
        //exit($query);
        mysqli_query($_SESSION["db_conn"], $query);

        if (mysqli_affected_rows($_SESSION["db_conn"])>0) {
            return true;
        } else {
            return false;
        }
    }
    public static function delete($id)
    {
        $query = "delete from banner where banner_id=$id ";
        mysqli_query($_SESSION["db_conn"], $query);

        if (mysqli_affected_rows($_SESSION["db_conn"])>0) {
            return true;
        } else {
            return false;
        }
    }
    public static function updateCondition($id, $condition)
    {
        $query = "update banner set $condition where banner_id=$id ";
        mysqli_query($_SESSION["db_conn"], $query);

        if (mysqli_affected_rows($_SESSION["db_conn"])>0) {
            return true;
        } else {
            return false;
        }
    }
    public static function count($condition)
    {
        $query = "select count(*) as cc from banner where $condition";
        $result = mysqli_query($_SESSION["db_conn"], $query);
        $data = mysqli_fetch_object($result);
        return $data->cc;
    }
}
