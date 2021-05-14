<?php
class Document
{
    public static function select($condition)
    {
        if ($condition == "") {
            $condition=1;
        }
        $query = "select * from document where $condition ";
        $result = mysqli_query($_SESSION["db_conn"], $query);
        $objects = array();
        while ($data = mysqli_fetch_object($result)) {
            array_push($objects, $data);
        }
    
        return $objects;
    }
    public static function selectById($id)
    {
        $query = "select * from document where document_id=$id ";
        $result = mysqli_query($_SESSION["db_conn"], $query);
        $data = mysqli_fetch_object($result);
        return $data;
    }
    public static function save($id, $document_title, $document_pdf, $document_date, $partner_id, $company_id)
    {
        if ($id == "") {
            $query = "insert into document set `document_title` = '$document_title' , `document_pdf` = '$document_pdf' , `document_date` = '$document_date' , `partner_id` = '$partner_id' , `company_id` = '$company_id'  ";
        } else {
            $query = "update document set `document_title` = '$document_title' , `document_pdf` = '$document_pdf' , `document_date` = '$document_date' , `partner_id` = '$partner_id' , `company_id` = '$company_id'  where document_id = $id";
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
        $query = "delete from document where document_id=$id ";
        mysqli_query($_SESSION["db_conn"], $query);

        if (mysqli_affected_rows($_SESSION["db_conn"])>0) {
            return true;
        } else {
            return false;
        }
    }
    public static function updateCondition($id, $condition)
    {
        $query = "update document set $condition where document_id=$id ";
        mysqli_query($_SESSION["db_conn"], $query);

        if (mysqli_affected_rows($_SESSION["db_conn"])>0) {
            return true;
        } else {
            return false;
        }
    }
    public static function count($condition)
    {
        $query = "select count(*) as cc from document where $condition";
        $result = mysqli_query($_SESSION["db_conn"], $query);
        $data = mysqli_fetch_object($result);
        return $data->cc;
    }
}
