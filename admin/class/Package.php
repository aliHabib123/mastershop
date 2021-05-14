<?php
class Package
{
    public static function select($condition)
    {
        if ($condition == "") {
            $condition=1;
        }
        $query = "select * from package a where $condition ";
        $result = mysqli_query($_SESSION["db_conn"], $query);
        $objects = array();
        while ($data = mysqli_fetch_object($result)) {
            array_push($objects, $data);
        }
    
        return $objects;
    }
    public static function selectById($id)
    {
        $query = "select * from package where package_id=$id ";
        $result = mysqli_query($_SESSION["db_conn"], $query);
        $data = mysqli_fetch_object($result);
        return $data;
    }
    public static function save($id, $package_title, $package_details, $package_image, $package_price, $package_rating, $company_id, $slug, $album_id=0)
    {
        if ($id == "") {
            $query = "insert into package set `package_title` = '$package_title' , `package_details` = '$package_details' ,`package_image` = '$package_image', `package_price` = '$package_price' , `package_rating` = '$package_rating' , `company_id` = '$company_id', `package_slug` = '$slug', `album_id` = '$album_id'  ";
        } else {
            $query = "update package set `package_title` = '$package_title' , `package_details` = '$package_details' ,`package_image` = '$package_image', `package_price` = '$package_price' , `package_rating` = '$package_rating' , `company_id` = '$company_id', `package_slug` = '$slug'  where package_id = $id";
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
        $query = "delete from package where package_id=$id ";
        mysqli_query($_SESSION["db_conn"], $query);

        if (mysqli_affected_rows($_SESSION["db_conn"])>0) {
            return true;
        } else {
            return false;
        }
    }
    public static function updateCondition($id, $condition)
    {
        $query = "update package set $condition where package_id=$id ";
        mysqli_query($_SESSION["db_conn"], $query);

        if (mysqli_affected_rows($_SESSION["db_conn"])>0) {
            return true;
        } else {
            return false;
        }
    }
    public static function count($condition)
    {
        $query = "select count(*) as cc from package where $condition";
        $result = mysqli_query($_SESSION["db_conn"], $query);
        $data = mysqli_fetch_object($result);
        return $data->cc;
    }
}
