<?php
/**
 * Class that operate on table 'item_category_mapping'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2021-05-14 19:34
 */
class ItemCategoryMappingMySqlDAO implements ItemCategoryMappingDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return ItemCategoryMappingMySql 
	 */
	public function load($id){
		$sql = 'SELECT * FROM item_category_mapping WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($id);
		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll(){
		$sql = 'SELECT * FROM item_category_mapping';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM item_category_mapping ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param itemCategoryMapping primary key
 	 */
	public function delete($id){
		$sql = 'DELETE FROM item_category_mapping WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($id);
		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param ItemCategoryMappingMySql itemCategoryMapping
 	 */
	public function insert($itemCategoryMapping){
		$sql = 'INSERT INTO item_category_mapping (item_id, category_id) VALUES (?, ?)';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->setNumber($itemCategoryMapping->itemId);
		$sqlQuery->setNumber($itemCategoryMapping->categoryId);

		$id = $this->executeInsert($sqlQuery);	
		$itemCategoryMapping->id = $id;
		return $id;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param ItemCategoryMappingMySql itemCategoryMapping
 	 */
	public function update($itemCategoryMapping){
		$sql = 'UPDATE item_category_mapping SET item_id = ?, category_id = ? WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->setNumber($itemCategoryMapping->itemId);
		$sqlQuery->setNumber($itemCategoryMapping->categoryId);

		$sqlQuery->set($itemCategoryMapping->id);
		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM item_category_mapping';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}

	public function queryByItemId($value){
		$sql = 'SELECT * FROM item_category_mapping WHERE item_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByCategoryId($value){
		$sql = 'SELECT * FROM item_category_mapping WHERE category_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}


	public function deleteByItemId($value){
		$sql = 'DELETE FROM item_category_mapping WHERE item_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByCategoryId($value){
		$sql = 'DELETE FROM item_category_mapping WHERE category_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}


	
	/**
	 * Read row
	 *
	 * @return ItemCategoryMappingMySql 
	 */
	protected function readRow($row){
		$itemCategoryMapping = new ItemCategoryMapping();
		
		$itemCategoryMapping->id = $row['id'];
		$itemCategoryMapping->itemId = $row['item_id'];
		$itemCategoryMapping->categoryId = $row['category_id'];
		$itemCategoryMapping->categoryName = isset($row['name']) ? $row['name'] : "";
		$itemCategoryMapping->parentId = isset($row['parent_id']) ? $row['parent_id'] : "";

		return $itemCategoryMapping;
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
	 * @return ItemCategoryMappingMySql 
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