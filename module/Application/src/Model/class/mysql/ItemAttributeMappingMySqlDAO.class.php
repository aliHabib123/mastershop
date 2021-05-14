<?php
/**
 * Class that operate on table 'item_attribute_mapping'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2021-05-14 19:34
 */
class ItemAttributeMappingMySqlDAO implements ItemAttributeMappingDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return ItemAttributeMappingMySql 
	 */
	public function load($id){
		$sql = 'SELECT * FROM item_attribute_mapping WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll(){
		$sql = 'SELECT * FROM item_attribute_mapping';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM item_attribute_mapping ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param itemAttributeMapping primary key
 	 */
	public function delete($id){
		$sql = 'DELETE FROM item_attribute_mapping WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param ItemAttributeMappingMySql itemAttributeMapping
 	 */
	public function insert($itemAttributeMapping){
		$sql = 'INSERT INTO item_attribute_mapping (item_id, attribute_id, value, display_order) VALUES (?, ?, ?, ?)';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($itemAttributeMapping->itemId);
		$sqlQuery->setNumber($itemAttributeMapping->attributeId);
		$sqlQuery->set($itemAttributeMapping->value);
		$sqlQuery->setNumber($itemAttributeMapping->displayOrder);

		$id = $this->executeInsert($sqlQuery);	
		$itemAttributeMapping->id = $id;
		return $id;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param ItemAttributeMappingMySql itemAttributeMapping
 	 */
	public function update($itemAttributeMapping){
		$sql = 'UPDATE item_attribute_mapping SET item_id = ?, attribute_id = ?, value = ?, display_order = ? WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($itemAttributeMapping->itemId);
		$sqlQuery->setNumber($itemAttributeMapping->attributeId);
		$sqlQuery->set($itemAttributeMapping->value);
		$sqlQuery->setNumber($itemAttributeMapping->displayOrder);

		$sqlQuery->setNumber($itemAttributeMapping->id);
		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM item_attribute_mapping';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}

	public function queryByItemId($value){
		$sql = 'SELECT * FROM item_attribute_mapping WHERE item_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByAttributeId($value){
		$sql = 'SELECT * FROM item_attribute_mapping WHERE attribute_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByValue($value){
		$sql = 'SELECT * FROM item_attribute_mapping WHERE value = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByDisplayOrder($value){
		$sql = 'SELECT * FROM item_attribute_mapping WHERE display_order = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}


	public function deleteByItemId($value){
		$sql = 'DELETE FROM item_attribute_mapping WHERE item_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByAttributeId($value){
		$sql = 'DELETE FROM item_attribute_mapping WHERE attribute_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByValue($value){
		$sql = 'DELETE FROM item_attribute_mapping WHERE value = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByDisplayOrder($value){
		$sql = 'DELETE FROM item_attribute_mapping WHERE display_order = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}


	
	/**
	 * Read row
	 *
	 * @return ItemAttributeMappingMySql 
	 */
	protected function readRow($row){
		$itemAttributeMapping = new ItemAttributeMapping();
		
		$itemAttributeMapping->id = $row['id'];
		$itemAttributeMapping->itemId = $row['item_id'];
		$itemAttributeMapping->attributeId = $row['attribute_id'];
		$itemAttributeMapping->value = $row['value'];
		$itemAttributeMapping->displayOrder = $row['display_order'];

		return $itemAttributeMapping;
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
	 * @return ItemAttributeMappingMySql 
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