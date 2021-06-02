<?php
/**
 * Class that operate on table 'warehouse'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2021-05-14 19:34
 */
class WarehouseMySqlDAO implements WarehouseDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return WarehouseMySql 
	 */
	public function load($id){
		$sql = 'SELECT * FROM warehouse WHERE warehouse_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll(){
		$sql = 'SELECT * FROM warehouse';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM warehouse ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param warehouse primary key
 	 */
	public function delete($warehouse_id){
		$sql = 'DELETE FROM warehouse WHERE warehouse_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($warehouse_id);
		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param WarehouseMySql warehouse
 	 */
	public function insert($warehouse){
		$sql = 'INSERT INTO warehouse (title, company_id, contact_id, active, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?)';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($warehouse->title);
		$sqlQuery->set($warehouse->companyId);
		$sqlQuery->set($warehouse->contactId);
		$sqlQuery->setNumber($warehouse->active);
		$sqlQuery->set($warehouse->createdAt);
		$sqlQuery->set($warehouse->updatedAt);

		$id = $this->executeInsert($sqlQuery);	
		$warehouse->warehouseId = $id;
		return $id;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param WarehouseMySql warehouse
 	 */
	public function update($warehouse){
		$sql = 'UPDATE warehouse SET title = ?, company_id = ?, contact_id = ?, active = ?, created_at = ?, updated_at = ? WHERE warehouse_id = ?';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($warehouse->title);
		$sqlQuery->set($warehouse->companyId);
		$sqlQuery->set($warehouse->contactId);
		$sqlQuery->setNumber($warehouse->active);
		$sqlQuery->set($warehouse->createdAt);
		$sqlQuery->set($warehouse->updatedAt);

		$sqlQuery->setNumber($warehouse->warehouseId);
		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM warehouse';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}

	public function queryByTitle($value){
		$sql = 'SELECT * FROM warehouse WHERE title = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByCompanyId($value){
		$sql = 'SELECT * FROM warehouse WHERE company_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByContactId($value){
		$sql = 'SELECT * FROM warehouse WHERE contact_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByActive($value){
		$sql = 'SELECT * FROM warehouse WHERE active = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByCreatedAt($value){
		$sql = 'SELECT * FROM warehouse WHERE created_at = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByUpdatedAt($value){
		$sql = 'SELECT * FROM warehouse WHERE updated_at = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}


	public function deleteByTitle($value){
		$sql = 'DELETE FROM warehouse WHERE title = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByCompanyId($value){
		$sql = 'DELETE FROM warehouse WHERE company_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByContactId($value){
		$sql = 'DELETE FROM warehouse WHERE contact_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByActive($value){
		$sql = 'DELETE FROM warehouse WHERE active = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByCreatedAt($value){
		$sql = 'DELETE FROM warehouse WHERE created_at = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByUpdatedAt($value){
		$sql = 'DELETE FROM warehouse WHERE updated_at = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}


	
	/**
	 * Read row
	 *
	 * @return WarehouseMySql 
	 */
	protected function readRow($row){
		$warehouse = new Warehouse();
		
		$warehouse->warehouseId = $row['warehouse_id'];
		$warehouse->title = $row['title'];
		$warehouse->companyId = $row['company_id'];
		$warehouse->contactId = $row['contact_id'];
		$warehouse->active = $row['active'];
		$warehouse->createdAt = $row['created_at'];
		$warehouse->updatedAt = $row['updated_at'];
		$warehouse->firstName = $row['first_name'];
		$warehouse->lastName = $row['last_name'];
		$warehouse->mobile = $row['mobile'];
		$warehouse->email = $row['email'];

		return $warehouse;
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
	 * @return WarehouseMySql 
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