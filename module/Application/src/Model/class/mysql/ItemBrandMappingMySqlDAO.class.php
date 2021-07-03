<?php
/**
 * Class that operate on table 'item_brand_mapping'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2021-05-31 12:29
 */
class ItemBrandMappingMySqlDAO implements ItemBrandMappingDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return ItemBrandMappingMySql 
	 */
	public function load($id){
		$sql = 'SELECT * FROM item_brand_mapping WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($id);
		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll(){
		$sql = 'SELECT * FROM item_brand_mapping';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM item_brand_mapping ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param itemBrandMapping primary key
 	 */
	public function delete($id){
		$sql = 'DELETE FROM item_brand_mapping WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($id);
		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param ItemBrandMappingMySql itemBrandMapping
 	 */
	public function insert($itemBrandMapping){
		$sql = 'INSERT INTO item_brand_mapping (item_id, brand_id) VALUES (?, ?)';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($itemBrandMapping->itemId);
		$sqlQuery->setNumber($itemBrandMapping->brandId);

		$id = $this->executeInsert($sqlQuery);	
		$itemBrandMapping->id = $id;
		return $id;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param ItemBrandMappingMySql itemBrandMapping
 	 */
	public function update($itemBrandMapping){
		$sql = 'UPDATE item_brand_mapping SET item_id = ?, brand_id = ? WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($itemBrandMapping->itemId);
		$sqlQuery->setNumber($itemBrandMapping->brandId);

		$sqlQuery->set($itemBrandMapping->id);
		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM item_brand_mapping';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}

	public function queryByItemId($value){
		$sql = 'SELECT * FROM item_brand_mapping WHERE item_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByBrandId($value){
		$sql = 'SELECT * FROM item_brand_mapping WHERE brand_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}


	public function deleteByItemId($value){
		$sql = 'DELETE FROM item_brand_mapping WHERE item_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByBrandId($value){
		$sql = 'DELETE FROM item_brand_mapping WHERE brand_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}


	
	/**
	 * Read row
	 *
	 * @return ItemBrandMappingMySql 
	 */
	protected function readRow($row){
		$itemBrandMapping = new ItemBrandMapping();
		
		$itemBrandMapping->id = $row['id'];
		$itemBrandMapping->itemId = $row['item_id'];
		$itemBrandMapping->brandId = $row['brand_id'];
		$itemBrandMapping->name = isset($row['name']) ? $row['name'] : "";
		$itemBrandMapping->image = isset($row['image']) ? $row['image'] : "";

		return $itemBrandMapping;
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
	 * @return ItemBrandMappingMySql 
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
