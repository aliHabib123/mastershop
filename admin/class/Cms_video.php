<?php
class Cms_video
{
    public static function select($condition)
    {
        if ($condition == "") {
            $condition = 1;
        }
        $query = "select * from cms_video where $condition ";
        $result = mysqli_query($_SESSION['db_conn'], $query);
        $objects = array();
        while ($data = mysqli_fetch_object($result)) {
            array_push($objects, $data);
        }
        
        return $objects;
    }
    public static function selectById($id)
    {
        $query = "select * from cms_video where cms_video_id=$id ";
        $result = mysqli_query($_SESSION['db_conn'], $query);
        $data = mysqli_fetch_object($result);
        return $data;
    }
    public static function save($id, $cms_video_title, $cms_video_youtube_url, $cms_video_details)
    {
        if ($id == "") {
            $query = "insert into cms_video set `cms_video_title` = '$cms_video_title' , `cms_video_youtube_url` = '$cms_video_youtube_url' , `cms_video_details` = '$cms_video_details'  ";
        } else {
            $query = "update cms_video set `cms_video_title` = '$cms_video_title' , `cms_video_youtube_url` = '$cms_video_youtube_url' , `cms_video_details` = '$cms_video_details'  where cms_video_id = $id";
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
        $query = "delete from cms_video where cms_video_id=$id ";
        mysqli_query($_SESSION['db_conn'], $query);
        
        if (mysqli_affected_rows($_SESSION['db_conn']) > 0) {
            return true;
        } else {
            return false;
        }
    }
    public static function updateCondition($id, $condition)
    {
        $query = "update cms_video set $condition where cms_video_id=$id ";
        mysqli_query($_SESSION['db_conn'], $query);
        
        if (mysqli_affected_rows($_SESSION['db_conn']) > 0) {
            return true;
        } else {
            return false;
        }
    }
    public static function count($condition)
    {
        $query = "select count(*) as cc from cms_video where $condition";
        $result = mysqli_query($_SESSION['db_conn'], $query);
        $data = mysqli_fetch_object($result);
        return $data->cc;
    }
}
