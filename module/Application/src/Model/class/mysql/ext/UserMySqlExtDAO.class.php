<?php
/**
 * Class that operate on table 'user'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2021-04-23 23:35
 */
class UserMySqlExtDAO extends UserMySqlDAO{

    public function checkLoginCredentials($email){
		$password = 'sadsdasd';
		$txt = "SELECT * FROM `user` WHERE `email` = ?";
		$sqlQuery = new SqlQuery($txt);
		//var_dump($sqlQuery);die();
		$sqlQuery->setString($email);
        // $sqlQuery->setString($password);
		
		return $this->getRow($sqlQuery);
	}
}
?>