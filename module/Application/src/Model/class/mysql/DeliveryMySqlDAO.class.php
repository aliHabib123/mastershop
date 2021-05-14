<?php
/**
 * Class that operate on table 'delivery'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2021-05-14 19:34
 */
class DeliveryMySqlDAO implements DeliveryDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return DeliveryMySql 
	 */
	public function load($id){
		$sql = 'SELECT * FROM delivery WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($id);
		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll(){
		$sql = 'SELECT * FROM delivery';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM delivery ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param delivery primary key
 	 */
	public function delete($id){
		$sql = 'DELETE FROM delivery WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($id);
		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param DeliveryMySql delivery
 	 */
	public function insert($delivery){
		$sql = 'INSERT INTO delivery (order_id, delivery_company_id, delivery_state_id, driver_id, created_at, updated_at, delivery_history) VALUES (?, ?, ?, ?, ?, ?, ?)';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($delivery->orderId);
		$sqlQuery->setNumber($delivery->deliveryCompanyId);
		$sqlQuery->setNumber($delivery->deliveryStateId);
		$sqlQuery->set($delivery->driverId);
		$sqlQuery->set($delivery->createdAt);
		$sqlQuery->set($delivery->updatedAt);
		$sqlQuery->set($delivery->deliveryHistory);

		$id = $this->executeInsert($sqlQuery);	
		$delivery->id = $id;
		return $id;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param DeliveryMySql delivery
 	 */
	public function update($delivery){
		$sql = 'UPDATE delivery SET order_id = ?, delivery_company_id = ?, delivery_state_id = ?, driver_id = ?, created_at = ?, updated_at = ?, delivery_history = ? WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($delivery->orderId);
		$sqlQuery->setNumber($delivery->deliveryCompanyId);
		$sqlQuery->setNumber($delivery->deliveryStateId);
		$sqlQuery->set($delivery->driverId);
		$sqlQuery->set($delivery->createdAt);
		$sqlQuery->set($delivery->updatedAt);
		$sqlQuery->set($delivery->deliveryHistory);

		$sqlQuery->set($delivery->id);
		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM delivery';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}

	public function queryByOrderId($value){
		$sql = 'SELECT * FROM delivery WHERE order_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByDeliveryCompanyId($value){
		$sql = 'SELECT * FROM delivery WHERE delivery_company_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByDeliveryStateId($value){
		$sql = 'SELECT * FROM delivery WHERE delivery_state_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByDriverId($value){
		$sql = 'SELECT * FROM delivery WHERE driver_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByCreatedAt($value){
		$sql = 'SELECT * FROM delivery WHERE created_at = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByUpdatedAt($value){
		$sql = 'SELECT * FROM delivery WHERE updated_at = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByDeliveryHistory($value){
		$sql = 'SELECT * FROM delivery WHERE delivery_history = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}


	public function deleteByOrderId($value){
		$sql = 'DELETE FROM delivery WHERE order_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByDeliveryCompanyId($value){
		$sql = 'DELETE FROM delivery WHERE delivery_company_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByDeliveryStateId($value){
		$sql = 'DELETE FROM delivery WHERE delivery_state_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByDriverId($value){
		$sql = 'DELETE FROM delivery WHERE driver_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByCreatedAt($value){
		$sql = 'DELETE FROM delivery WHERE created_at = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByUpdatedAt($value){
		$sql = 'DELETE FROM delivery WHERE updated_at = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByDeliveryHistory($value){
		$sql = 'DELETE FROM delivery WHERE delivery_history = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}


	
	/**
	 * Read row
	 *
	 * @return DeliveryMySql 
	 */
	protected function readRow($row){
		$delivery = new Delivery();
		
		$delivery->id = $row['id'];
		$delivery->orderId = $row['order_id'];
		$delivery->deliveryCompanyId = $row['delivery_company_id'];
		$delivery->deliveryStateId = $row['delivery_state_id'];
		$delivery->driverId = $row['driver_id'];
		$delivery->createdAt = $row['created_at'];
		$delivery->updatedAt = $row['updated_at'];
		$delivery->deliveryHistory = $row['delivery_history'];

		return $delivery;
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
	 * @return DeliveryMySql 
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