<?php

use Application\Controller\UserController;

/**
 * Class that operate on table 'user'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2021-04-23 23:35
 */
class UserMySqlExtDAO extends UserMySqlDAO
{

	public function checkLoginCredentials($email, $type = 1)
	{
		$txt = "SELECT * FROM `user` WHERE `email` = ? AND user_type = ?";
		$sqlQuery = new SqlQuery($txt);
		//var_dump($sqlQuery);die();
		$sqlQuery->setString($email);
		$sqlQuery->set($type);
		// $sqlQuery->setString($password);

		return $this->getRow($sqlQuery);
	}

	public function updatePassword($password, $adminId)
	{
		$sql = 'UPDATE user SET password = ?  WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);

		$sqlQuery->set($password);
		$sqlQuery->set($adminId);

		return $this->executeUpdate($sqlQuery);
	}

	public function getUserCount($condition)
	{
		$sql = "select count(*) as count from user where $condition";
		// /print_r($sql);die();
		$sqlQuery = new SqlQuery($sql);
		//print_r($this->getRow($sqlQuery));
		return $this->execute($sqlQuery)[0]['count'];
	}
	public function select($condition)
	{
		$sql = "SELECT * FROM user WHERE $condition";
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}

	public function updateFile($supplierId, $fileName)
	{
		$sql = 'UPDATE user SET uploaded_file = ?  WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);

		$sqlQuery->set($fileName);
		$sqlQuery->set($supplierId);

		return $this->executeUpdate($sqlQuery);
	}
	public function getUserByEmailAndType($value, $type = 3)
	{
		$sql = 'SELECT * FROM user WHERE email = ? AND user_type = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		$sqlQuery->set($type);
		return $this->getRow($sqlQuery);
	}

	public function getUserByActivationCodeAndType($code, $type = 3)
	{
		$sql = 'SELECT * FROM user WHERE activation_code = ? AND user_type = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($code);
		$sqlQuery->set($type);
		return $this->getRow($sqlQuery);
	}
}
