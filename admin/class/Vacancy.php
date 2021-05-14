<?php
class Vacancy
{
    public static function select($condition)
    {
        if ($condition == "") {
            $condition=1;
        }
        $query = "select * from vacancy where $condition ";
        $result = mysqli_query($_SESSION["db_conn"], $query);
        $objects = array();
        while ($data = mysqli_fetch_object($result)) {
            array_push($objects, $data);
        }
    
        return $objects;
    }
    public static function selectById($id)
    {
        $query = "select * from vacancy where vacancy_id=$id ";
        $result = mysqli_query($_SESSION["db_conn"], $query);
        $data = mysqli_fetch_object($result);
        return $data;
    }
    public static function save($id, $vacancy_title, $vacancy_details, $vacancy_date, $company_id)
    {
        if ($id == "") {
            $query = "insert into vacancy set `vacancy_title` = '$vacancy_title' , `vacancy_details` = '$vacancy_details' , `vacancy_date` = '$vacancy_date' , `company_id` = '$company_id'  ";
        } else {
            $query = "update vacancy set `vacancy_title` = '$vacancy_title' , `vacancy_details` = '$vacancy_details' , `vacancy_date` = '$vacancy_date' , `company_id` = '$company_id'  where vacancy_id = $id";
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
        $query = "delete from vacancy where vacancy_id=$id ";
        mysqli_query($_SESSION["db_conn"], $query);

        if (mysqli_affected_rows($_SESSION["db_conn"])>0) {
            return true;
        } else {
            return false;
        }
    }
    public static function updateCondition($id, $condition)
    {
        $query = "update vacancy set $condition where vacancy_id=$id ";
        mysqli_query($_SESSION["db_conn"], $query);

        if (mysqli_affected_rows($_SESSION["db_conn"])>0) {
            return true;
        } else {
            return false;
        }
    }
    public static function count($condition)
    {
        $query = "select count(*) as cc from vacancy where $condition";
        $result = mysqli_query($_SESSION["db_conn"], $query);
        $data = mysqli_fetch_object($result);
        return $data->cc;
    }
}
