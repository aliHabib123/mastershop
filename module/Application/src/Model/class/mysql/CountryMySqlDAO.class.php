<?php
/**
 * Class that operate on table 'country'. Database Mysql.
 */
class CountryMySqlDAO implements CountryDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return CountryMySql 
	 */
	public function load($id){
		$sql = 'SELECT * FROM country WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll(){
		$sql = 'SELECT * FROM country';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM country ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param country primary key
 	 */
	public function delete($id){
		$sql = 'DELETE FROM country WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param CountryMySql country
 	 */
	public function insert($country){
		$sql = 'INSERT INTO country (iso, name, nicename, iso3, numcode, phonecode) VALUES (?, ?, ?, ?, ?, ?)';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($country->iso);
		$sqlQuery->set($country->name);
		$sqlQuery->set($country->nicename);
		$sqlQuery->set($country->iso3);
		$sqlQuery->set($country->numcode);
		$sqlQuery->setNumber($country->phonecode);

		$id = $this->executeInsert($sqlQuery);	
		$country->id = $id;
		return $id;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param CountryMySql country
 	 */
	public function update($country){
		$sql = 'UPDATE country SET iso = ?, name = ?, nicename = ?, iso3 = ?, numcode = ?, phonecode = ? WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($country->iso);
		$sqlQuery->set($country->name);
		$sqlQuery->set($country->nicename);
		$sqlQuery->set($country->iso3);
		$sqlQuery->set($country->numcode);
		$sqlQuery->setNumber($country->phonecode);

		$sqlQuery->setNumber($country->id);
		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM country';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}

	public function queryByIso($value){
		$sql = 'SELECT * FROM country WHERE iso = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByName($value){
		$sql = 'SELECT * FROM country WHERE name = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByNicename($value){
		$sql = 'SELECT * FROM country WHERE nicename = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByIso3($value){
		$sql = 'SELECT * FROM country WHERE iso3 = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByNumcode($value){
		$sql = 'SELECT * FROM country WHERE numcode = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByPhonecode($value){
		$sql = 'SELECT * FROM country WHERE phonecode = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}


	public function deleteByIso($value){
		$sql = 'DELETE FROM country WHERE iso = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByName($value){
		$sql = 'DELETE FROM country WHERE name = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByNicename($value){
		$sql = 'DELETE FROM country WHERE nicename = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByIso3($value){
		$sql = 'DELETE FROM country WHERE iso3 = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByNumcode($value){
		$sql = 'DELETE FROM country WHERE numcode = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByPhonecode($value){
		$sql = 'DELETE FROM country WHERE phonecode = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}


	
	/**
	 * Read row
	 *
	 * @return CountryMySql 
	 */
	protected function readRow($row){
		$country = new Country();
		
		$country->id = $row['id'];
		$country->iso = $row['iso'];
		$country->name = $row['name'];
		$country->nicename = $row['nicename'];
		$country->iso3 = $row['iso3'];
		$country->numcode = $row['numcode'];
		$country->phonecode = $row['phonecode'];

		return $country;
	}
	
	protected function getList($sqlQuery){
		$tab = QueryExecutor::execute($sqlQuery);
		$ret = array();
		for($i=0;$i<count($tab);$i++){
			$ret[$i] = $this->readRow($tab[$i]);
		}
		return $ret;
	}
	
	/**
	 * Get row
	 *
	 * @return CountryMySql 
	 */
	protected function getRow($sqlQuery){
		$tab = QueryExecutor::execute($sqlQuery);
		if(count($tab)==0){
			return null;
		}
		return $this->readRow($tab[0]);		
	}
	
	/**
	 * Execute sql query
	 */
	protected function execute($sqlQuery){
		return QueryExecutor::execute($sqlQuery);
	}
	
		
	/**
	 * Execute sql query
	 */
	protected function executeUpdate($sqlQuery){
		return QueryExecutor::executeUpdate($sqlQuery);
	}

	/**
	 * Query for one row and one column
	 */
	protected function querySingleResult($sqlQuery){
		return QueryExecutor::queryForString($sqlQuery);
	}

	/**
	 * Insert row to table
	 */
	protected function executeInsert($sqlQuery){
		return QueryExecutor::executeInsert($sqlQuery);
	}
}
?>