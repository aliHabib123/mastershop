<?php
/**
 * Class that operate on table 'sale_order_item'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2021-05-14 19:34
 */
class SaleOrderItemMySqlDAO implements SaleOrderItemDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return SaleOrderItemMySql 
	 */
	public function load($id){
		$sql = 'SELECT * FROM sale_order_item WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($id);
		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll(){
		$sql = 'SELECT * FROM sale_order_item';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM sale_order_item ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param saleOrderItem primary key
 	 */
	public function delete($id){
		$sql = 'DELETE FROM sale_order_item WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($id);
		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param SaleOrderItemMySql saleOrderItem
 	 */
	public function insert($saleOrderItem){
		$sql = 'INSERT INTO sale_order_item (sale_order_id, item_id, qty, price, meta) VALUES (?, ?, ?, ?, ?)';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($saleOrderItem->saleOrderId);
		$sqlQuery->set($saleOrderItem->itemId);
		$sqlQuery->setNumber($saleOrderItem->qty);
		$sqlQuery->set($saleOrderItem->price);
		$sqlQuery->set($saleOrderItem->meta);

		$id = $this->executeInsert($sqlQuery);	
		$saleOrderItem->id = $id;
		return $id;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param SaleOrderItemMySql saleOrderItem
 	 */
	public function update($saleOrderItem){
		$sql = 'UPDATE sale_order_item SET sale_order_id = ?, item_id = ?, qty = ?, price = ?, meta = ? WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($saleOrderItem->saleOrderId);
		$sqlQuery->set($saleOrderItem->itemId);
		$sqlQuery->setNumber($saleOrderItem->qty);
		$sqlQuery->set($saleOrderItem->price);
		$sqlQuery->set($saleOrderItem->meta);

		$sqlQuery->set($saleOrderItem->id);
		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM sale_order_item';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}

	public function queryBySaleOrderId($value){
		$sql = 'SELECT * FROM sale_order_item WHERE sale_order_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByItemId($value){
		$sql = 'SELECT * FROM sale_order_item WHERE item_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByQty($value){
		$sql = 'SELECT * FROM sale_order_item WHERE qty = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByPrice($value){
		$sql = 'SELECT * FROM sale_order_item WHERE price = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByMeta($value){
		$sql = 'SELECT * FROM sale_order_item WHERE meta = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}


	public function deleteBySaleOrderId($value){
		$sql = 'DELETE FROM sale_order_item WHERE sale_order_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByItemId($value){
		$sql = 'DELETE FROM sale_order_item WHERE item_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByQty($value){
		$sql = 'DELETE FROM sale_order_item WHERE qty = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByPrice($value){
		$sql = 'DELETE FROM sale_order_item WHERE price = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByMeta($value){
		$sql = 'DELETE FROM sale_order_item WHERE meta = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}


	
	/**
	 * Read row
	 *
	 * @return SaleOrderItemMySql 
	 */
	protected function readRow($row){
		$saleOrderItem = new SaleOrderItem();
		
		$saleOrderItem->id = $row['id'];
		$saleOrderItem->saleOrderId = $row['sale_order_id'];
		$saleOrderItem->itemId = $row['item_id'];
		$saleOrderItem->qty = $row['qty'];
		$saleOrderItem->price = $row['price'];
		$saleOrderItem->meta = $row['meta'];

		return $saleOrderItem;
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
	 * @return SaleOrderItemMySql 
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