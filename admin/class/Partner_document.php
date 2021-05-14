<?php
class Partner_document
{
    public static function select($condition)
    {
        if ($condition == "") {
            $condition=1;
        }
        $query = "select a.*   ";
        $query.= " , b.partner_firstname ";
        $query.= " from partner_document a    ";
        $query.= " LEFT OUTER JOIN partner b ";
        $query.= " ON a.partner_id = b.partner_id ";
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
        $query = "select * from partner_document where partner_document_id=$id ";
        $result = mysqli_query($_SESSION["db_conn"], $query);
        $data = mysqli_fetch_object($result);
        return $data;
    }
    public static function save($id, $partner_document_title, $partner_document_file, $partner_document_active, $partner_id)
    {
        if ($id == "") {
            $query = "insert into partner_document set `partner_document_title` = '$partner_document_title' , `partner_document_file` = '$partner_document_file' , `partner_document_active` = '$partner_document_active' , `partner_id` = '$partner_id'  ";
        } else {
            $query = "update partner_document set `partner_document_title` = '$partner_document_title' , `partner_document_file` = '$partner_document_file' , `partner_document_active` = '$partner_document_active' , `partner_id` = '$partner_id'  where partner_document_id = $id";
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
        $query = "delete from partner_document where partner_document_id=$id ";
        mysqli_query($_SESSION["db_conn"], $query);

        if (mysqli_affected_rows($_SESSION["db_conn"])>0) {
            return true;
        } else {
            return false;
        }
    }
    public static function updateCondition($id, $condition)
    {
        $query = "update partner_document set $condition where partner_document_id=$id ";
        mysqli_query($_SESSION["db_conn"], $query);

        if (mysqli_affected_rows($_SESSION["db_conn"])>0) {
            return true;
        } else {
            return false;
        }
    }
    public static function count($condition)
    {
        $query = "select count(*) as cc from partner_document a where $condition";
        $result = mysqli_query($_SESSION["db_conn"], $query);
        $data = mysqli_fetch_object($result);
        return $data->cc;
    }
}
