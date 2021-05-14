<?php
class Cms_general
{
    public static function select($condition)
    {
        if ($condition == "") {
            $condition = 1;
        }
        $query = "select * from cms_general where $condition ";
        $result = mysqli_query($_SESSION['db_conn'], $query);
        $objects = array();
        while ($data = mysqli_fetch_object($result)) {
            array_push($objects, $data);
        }
        
        return $objects;
    }
    public static function selectById($id)
    {
        $query = "select * from cms_general where general_id=$id ";
        $result = mysqli_query($_SESSION['db_conn'], $query);
        $data = mysqli_fetch_object($result);
        return $data;
    }
    public static function save($id, $site_title, $recordpage, $email)
    {
        if ($id == "") {
            $query = "insert into cms_general set `site_title` = '$site_title' , `record/page` = '$recordpage' , `email` = '$email'  ";
        } else {
            $query = "update cms_general set `site_title` = '$site_title' , `record/page` = '$recordpage' , `email` = '$email'  where general_id = $id";
        }
        mysqli_query($_SESSION['db_conn'], $query);
        
        if (mysqli_affected_rows($_SESSION['db_conn']) > 0) {
            return true;
        } else {
            return false;
        }
    }
    public static function delete($id)
    {
        $query = "delete from cms_general where general_id=$id ";
        mysqli_query($_SESSION['db_conn'], $query);
        
        if (mysqli_affected_rows($_SESSION['db_conn']) > 0) {
            return true;
        } else {
            return false;
        }
    }
    public static function updateCondition($id, $condition)
    {
        $query = "update cms_general set $condition where general_id=$id ";
        mysqli_query($_SESSION['db_conn'], $query);
        
        if (mysqli_affected_rows($_SESSION['db_conn']) > 0) {
            return true;
        } else {
            return false;
        }
    }
    public static function count($condition)
    {
        $query = "select count(*) as cc from cms_general where $condition";
        $result = mysqli_query($_SESSION['db_conn'], $query);
        $data = mysqli_fetch_object($result);
        return $data->cc;
    }
}
