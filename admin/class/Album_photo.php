<?php
class Album_photo
{
    public static function select($condition)
    {
        if ($condition == "") {
            $condition=1;
        }
        $query = "select a.*   ";
        $query.= " , b.album_title ";
        $query.= " from album_photo a    ";
        $query.= " LEFT OUTER JOIN album b ";
        $query.= " ON a.album_id = b.album_id ";
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
        $query = "select * from album_photo where album_photo_id=$id ";
        $result = mysqli_query($_SESSION["db_conn"], $query);
        $data = mysqli_fetch_object($result);
        return $data;
    }
    public static function save($id, $album_photo_name, $album_photo_order, $album_id)
    {
        if ($id == "") {
            $query = "insert into album_photo set `album_photo_name` = '$album_photo_name' , `album_photo_order` = '$album_photo_order' , `album_id` = '$album_id'  ";
        } else {
            $query = "update album_photo set `album_photo_name` = '$album_photo_name' , `album_photo_order` = '$album_photo_order' , `album_id` = '$album_id'  where album_photo_id = $id";
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
        $query = "delete from album_photo where album_photo_id=$id ";
        mysqli_query($_SESSION["db_conn"], $query);

        if (mysqli_affected_rows($_SESSION["db_conn"])>0) {
            return true;
        } else {
            return false;
        }
    }
    public static function updateCondition($id, $condition)
    {
        $query = "update album_photo set $condition where album_photo_id=$id ";
        mysqli_query($_SESSION["db_conn"], $query);

        if (mysqli_affected_rows($_SESSION["db_conn"])>0) {
            return true;
        } else {
            return false;
        }
    }
    public static function count($condition)
    {
        $query = "select count(*) as cc from album_photo a where $condition";
        $result = mysqli_query($_SESSION["db_conn"], $query);
        $data = mysqli_fetch_object($result);
        return $data->cc;
    }
}
