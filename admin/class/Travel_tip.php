<?php
class Travel_tip
{
    public static function select($condition)
    {
        if ($condition == "") {
            $condition=1;
        }
        $query = "select a.*   ";
        $query.= " from travel_tip a    ";
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
        $query = "select * from travel_tip where travel_tip_id=$id ";
        $result = mysqli_query($_SESSION["db_conn"], $query);
        $data = mysqli_fetch_object($result);
        return $data;
    }
    public static function save($id, $travel_tip_title, $travel_tip_details, $travel_tip_image, $travel_tip_date, $travel_tip_active, $travel_tip_order, $company_id=3, $slug)
    {
        if ($id == "") {
            $query = "insert into travel_tip set `travel_tip_title` = '$travel_tip_title' , `travel_tip_details` = '$travel_tip_details' , `travel_tip_image` = '$travel_tip_image' , `travel_tip_date` = '$travel_tip_date' , `travel_tip_active` = '$travel_tip_active', `travel_tip_order` = '$travel_tip_order',`company_id`='$company_id' ,`travel_tip_slug`='$slug'  ";
        } else {
            $query = "update travel_tip set `travel_tip_title` = '$travel_tip_title' , `travel_tip_details` = '$travel_tip_details' , `travel_tip_image` = '$travel_tip_image' , `travel_tip_date` = '$travel_tip_date' , `travel_tip_active` = '$travel_tip_active' , `travel_tip_order` = '$travel_tip_order',`company_id`='$company_id',`travel_tip_slug`='$slug'  where travel_tip_id = $id";
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
        $query = "delete from travel_tip where travel_tip_id=$id ";
        mysqli_query($_SESSION["db_conn"], $query);

        if (mysqli_affected_rows($_SESSION["db_conn"])>0) {
            return true;
        } else {
            return false;
        }
    }
    public static function updateCondition($id, $condition)
    {
        $query = "update travel_tip set $condition where travel_tip_id=$id ";
        mysqli_query($_SESSION["db_conn"], $query);

        if (mysqli_affected_rows($_SESSION["db_conn"])>0) {
            return true;
        } else {
            return false;
        }
    }
    public static function count($condition)
    {
        $query = "select count(*) as cc from travel_tip a where $condition";
        $result = mysqli_query($_SESSION["db_conn"], $query);
        $data = mysqli_fetch_object($result);
        return $data->cc;
    }
}
