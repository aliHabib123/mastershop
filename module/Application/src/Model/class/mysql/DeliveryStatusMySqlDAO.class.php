<?php
/**
 * Class that operate on table 'delivery_status'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2021-04-23 23:50
 */
class DeliveryStatusMySqlDAO implements DeliveryStatusDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return DeliveryStatusMySql 
	 */
	public function load($id){
		$sql = 'SELECT * FROM delivery_status WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll(){
		$sql = 'SELECT * FROM delivery_status';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM delivery_status ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param deliveryStatu primary key
 	 */
	public function delete($id){
		$sql = 'DELETE FROM delivery_status WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param DeliveryStatusMySql deliveryStatu
 	 */
	public function insert($deliveryStatu){
		$sql = 'INSERT INTO delivery_status (status, display_order) VALUES (?, ?)';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($deliveryStatu->status);
		$sqlQuery->setNumber($deliveryStatu->displayOrder);

		$id = $this->executeInsert($sqlQuery);	
		$deliveryStatu->id = $id;
		return $id;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param DeliveryStatusMySql deliveryStatu
 	 */
	public function update($deliveryStatu){
		$sql = 'UPDATE delivery_status SET status = ?, display_order = ? WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($deliveryStatu->status);
		$sqlQuery->setNumber($deliveryStatu->displayOrder);

		$sqlQuery->setNumber($deliveryStatu->id);
		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM delivery_status';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}

	public function queryByStatus($value){
		$sql = 'SELECT * FROM delivery_status WHERE status = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByDisplayOrder($value){
		$sql = 'SELECT * FROM delivery_status WHERE display_order = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}


	public function deleteByStatus($value){
		$sql = 'DELETE FROM delivery_status WHERE status = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByDisplayOrder($value){
		$sql = 'DELETE FROM delivery_status WHERE display_order = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}


	
	/**
	 * Read row
	 *
	 * @return DeliveryStatusMySql 
	 */
	protected function readRow($row){
		$deliveryStatu = new DeliveryStatu();
		
		$deliveryStatu->id = $row['id'];
		$deliveryStatu->status = $row['status'];
		$deliveryStatu->displayOrder = $row['display_order'];

		return $deliveryStatu;
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
	 * @return DeliveryStatusMySql 
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