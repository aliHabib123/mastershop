<?php
/**
 * Class that operate on table 'item_attribute'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2021-05-14 19:34
 */
class ItemAttributeMySqlDAO implements ItemAttributeDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return ItemAttributeMySql 
	 */
	public function load($id){
		$sql = 'SELECT * FROM item_attribute WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll(){
		$sql = 'SELECT * FROM item_attribute';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM item_attribute ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param itemAttribute primary key
 	 */
	public function delete($id){
		$sql = 'DELETE FROM item_attribute WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param ItemAttributeMySql itemAttribute
 	 */
	public function insert($itemAttribute){
		$sql = 'INSERT INTO item_attribute (attribute_name, display_order, lang_id, translation_id) VALUES (?, ?, ?, ?)';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($itemAttribute->attributeName);
		$sqlQuery->setNumber($itemAttribute->displayOrder);
		$sqlQuery->setNumber($itemAttribute->langId);
		$sqlQuery->set($itemAttribute->translationId);

		$id = $this->executeInsert($sqlQuery);	
		$itemAttribute->id = $id;
		return $id;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param ItemAttributeMySql itemAttribute
 	 */
	public function update($itemAttribute){
		$sql = 'UPDATE item_attribute SET attribute_name = ?, display_order = ?, lang_id = ?, translation_id = ? WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($itemAttribute->attributeName);
		$sqlQuery->setNumber($itemAttribute->displayOrder);
		$sqlQuery->setNumber($itemAttribute->langId);
		$sqlQuery->set($itemAttribute->translationId);

		$sqlQuery->setNumber($itemAttribute->id);
		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM item_attribute';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}

	public function queryByAttributeName($value){
		$sql = 'SELECT * FROM item_attribute WHERE attribute_name = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByDisplayOrder($value){
		$sql = 'SELECT * FROM item_attribute WHERE display_order = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByLangId($value){
		$sql = 'SELECT * FROM item_attribute WHERE lang_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByTranslationId($value){
		$sql = 'SELECT * FROM item_attribute WHERE translation_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}


	public function deleteByAttributeName($value){
		$sql = 'DELETE FROM item_attribute WHERE attribute_name = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByDisplayOrder($value){
		$sql = 'DELETE FROM item_attribute WHERE display_order = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByLangId($value){
		$sql = 'DELETE FROM item_attribute WHERE lang_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByTranslationId($value){
		$sql = 'DELETE FROM item_attribute WHERE translation_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}


	
	/**
	 * Read row
	 *
	 * @return ItemAttributeMySql 
	 */
	protected function readRow($row){
		$itemAttribute = new ItemAttribute();
		
		$itemAttribute->id = $row['id'];
		$itemAttribute->attributeName = $row['attribute_name'];
		$itemAttribute->displayOrder = $row['display_order'];
		$itemAttribute->langId = $row['lang_id'];
		$itemAttribute->translationId = $row['translation_id'];

		return $itemAttribute;
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
	 * @return ItemAttributeMySql 
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