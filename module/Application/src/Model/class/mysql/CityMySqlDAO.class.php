<?php
/**
 * Class that operate on table 'city'. Database Mysql.
 */
class CityMySqlDAO implements CityDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return CityMySql 
	 */
	public function load($id){
		$sql = 'SELECT * FROM city WHERE city = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($id);
		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll(){
		$sql = 'SELECT * FROM city';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM city ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param city primary key
 	 */
	public function delete($city){
		$sql = 'DELETE FROM city WHERE city = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($city);
		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param CityMySql city
 	 */
	public function insert($city){
		$sql = 'INSERT INTO city (lat, lng, country, iso2, admin_name, capital, population, population_proper) VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($city->lat);
		$sqlQuery->set($city->lng);
		$sqlQuery->set($city->country);
		$sqlQuery->set($city->iso2);
		$sqlQuery->set($city->adminName);
		$sqlQuery->set($city->capital);
		$sqlQuery->setNumber($city->population);
		$sqlQuery->setNumber($city->populationProper);

		$id = $this->executeInsert($sqlQuery);	
		$city->city = $id;
		return $id;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param CityMySql city
 	 */
	public function update($city){
		$sql = 'UPDATE city SET lat = ?, lng = ?, country = ?, iso2 = ?, admin_name = ?, capital = ?, population = ?, population_proper = ? WHERE city = ?';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($city->lat);
		$sqlQuery->set($city->lng);
		$sqlQuery->set($city->country);
		$sqlQuery->set($city->iso2);
		$sqlQuery->set($city->adminName);
		$sqlQuery->set($city->capital);
		$sqlQuery->setNumber($city->population);
		$sqlQuery->setNumber($city->populationProper);

		$sqlQuery->set($city->city);
		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM city';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}

	public function queryByLat($value){
		$sql = 'SELECT * FROM city WHERE lat = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByLng($value){
		$sql = 'SELECT * FROM city WHERE lng = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByCountry($value){
		$sql = 'SELECT * FROM city WHERE country = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByIso2($value){
		$sql = 'SELECT * FROM city WHERE iso2 = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByAdminName($value){
		$sql = 'SELECT * FROM city WHERE admin_name = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByCapital($value){
		$sql = 'SELECT * FROM city WHERE capital = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByPopulation($value){
		$sql = 'SELECT * FROM city WHERE population = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByPopulationProper($value){
		$sql = 'SELECT * FROM city WHERE population_proper = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}


	public function deleteByLat($value){
		$sql = 'DELETE FROM city WHERE lat = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByLng($value){
		$sql = 'DELETE FROM city WHERE lng = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByCountry($value){
		$sql = 'DELETE FROM city WHERE country = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByIso2($value){
		$sql = 'DELETE FROM city WHERE iso2 = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByAdminName($value){
		$sql = 'DELETE FROM city WHERE admin_name = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByCapital($value){
		$sql = 'DELETE FROM city WHERE capital = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByPopulation($value){
		$sql = 'DELETE FROM city WHERE population = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByPopulationProper($value){
		$sql = 'DELETE FROM city WHERE population_proper = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}


	
	/**
	 * Read row
	 *
	 * @return CityMySql 
	 */
	protected function readRow($row){
		$city = new City();
		
		$city->city = $row['city'];
		$city->lat = $row['lat'];
		$city->lng = $row['lng'];
		$city->country = $row['country'];
		$city->iso2 = $row['iso2'];
		$city->adminName = $row['admin_name'];
		$city->capital = $row['capital'];
		$city->population = $row['population'];
		$city->populationProper = $row['population_proper'];

		return $city;
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
	 * @return CityMySql 
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