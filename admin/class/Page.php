<?php
class Page
{
    public static function select($condition)
    {
        if ($condition == "") {
            $condition=1;
        }
        $query = "select * from page a where $condition ";
        $result = mysqli_query($_SESSION["db_conn"], $query);
        $objects = array();
        while ($data = mysqli_fetch_object($result)) {
            array_push($objects, $data);
        }
    
        return $objects;
    }
    public static function selectById($id)
    {
        $query = "select * from page where page_id=$id ";
        $result = mysqli_query($_SESSION["db_conn"], $query);
        $data = mysqli_fetch_object($result);
        return $data;
    }
    public static function save($id, $page_title, $page_subtitle, $page_details, $page_image, $page_active, $page_link, $section_id, $company_id, $slug, $page_file, $type=null, $display_order=0, $album_id)
    {
        if ($id == "") {
            $query = "insert into page set `page_title` = '$page_title' , `page_subtitle` = '$page_subtitle' , `page_details` = '$page_details' , `page_image` = '$page_image' , `page_active` = '$page_active' , `page_link` = '$page_link' , `company_id` = '$company_id', `page_slug` = '$slug', `page_file` = '$page_file', `page_type` = '$type', `display_order` = '$display_order', `album_id` = '$album_id'  ";
        } else {
            $query = "update page set `page_title` = '$page_title' , `page_subtitle` = '$page_subtitle' , `page_details` = '$page_details' , `page_image` = '$page_image' , `page_active` = '$page_active' , `page_link` = '$page_link' , `company_id` = '$company_id', `page_slug` = '$slug', `page_file` = '$page_file', `display_order` = '$display_order'where page_id = $id";
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
        $query = "delete from page where page_id=$id ";
        mysqli_query($_SESSION["db_conn"], $query);

        if (mysqli_affected_rows($_SESSION["db_conn"])>0) {
            return true;
        } else {
            return false;
        }
    }
    public static function updateCondition($id, $condition)
    {
        $query = "update page set $condition where page_id=$id ";
        mysqli_query($_SESSION["db_conn"], $query);

        if (mysqli_affected_rows($_SESSION["db_conn"])>0) {
            return true;
        } else {
            return false;
        }
    }
    public static function count($condition)
    {
        $query = "select count(*) as cc from page where $condition";
        $result = mysqli_query($_SESSION["db_conn"], $query);
        $data = mysqli_fetch_object($result);
        return $data->cc;
    }
}
