<?php
class Applicant
{
    public static function select($condition)
    {
        if ($condition == "") {
            $condition=1;
        }
        $query = "select * from applicant where $condition ";
        $result = mysqli_query($_SESSION["db_conn"], $query);
        $objects = array();
        while ($data = mysqli_fetch_object($result)) {
            array_push($objects, $data);
        }
    
        return $objects;
    }
    public static function selectById($id)
    {
        $query = "select * from applicant where applicant_id=$id ";
        $result = mysqli_query($_SESSION["db_conn"], $query);
        $data = mysqli_fetch_object($result);
        return $data;
    }
    public static function save($id, $applicant_fullname, $applicant_gender, $applicant_nationality, $applicant_address, $applicant_email, $applicant_phone, $applicant_cv, $application_date, $company_id)
    {
        if ($id == "") {
            $query = "insert into applicant set `applicant_fullname` = '$applicant_fullname' , `applicant_gender` = '$applicant_gender' , `applicant_nationality` = '$applicant_nationality' , `applicant_address` = '$applicant_address' , `applicant_email` = '$applicant_email' , `applicant_phone` = '$applicant_phone' , `applicant_cv` = '$applicant_cv' , `application_date` = '$application_date' , `company_id` = '$company_id'  ";
        } else {
            $query = "update applicant set `applicant_fullname` = '$applicant_fullname' , `applicant_gender` = '$applicant_gender' , `applicant_nationality` = '$applicant_nationality' , `applicant_address` = '$applicant_address' , `applicant_email` = '$applicant_email' , `applicant_phone` = '$applicant_phone' , `applicant_cv` = '$applicant_cv' , `application_date` = '$application_date' , `company_id` = '$company_id'  where applicant_id = $id";
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
        $query = "delete from applicant where applicant_id=$id ";
        mysqli_query($_SESSION["db_conn"], $query);

        if (mysqli_affected_rows($_SESSION["db_conn"])>0) {
            return true;
        } else {
            return false;
        }
    }
    public static function updateCondition($id, $condition)
    {
        $query = "update applicant set $condition where applicant_id=$id ";
        mysqli_query($_SESSION["db_conn"], $query);

        if (mysqli_affected_rows($_SESSION["db_conn"])>0) {
            return true;
        } else {
            return false;
        }
    }
    public static function count($condition)
    {
        $query = "select count(*) as cc from applicant where $condition";
        $result = mysqli_query($_SESSION["db_conn"], $query);
        $data = mysqli_fetch_object($result);
        return $data->cc;
    }
}
