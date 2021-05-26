<?php
/**
 * Class that operate on table 'item_tag'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2021-05-14 19:34
 */
class ItemTagMySqlDAO implements ItemTagDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return ItemTagMySql 
	 */
	public function load($id){
		$sql = 'SELECT * FROM item_tag WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll(){
		$sql = 'SELECT * FROM item_tag';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM item_tag ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param itemTag primary key
 	 */
	public function delete($id){
		$sql = 'DELETE FROM item_tag WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param ItemTagMySql itemTag
 	 */
	public function insert($itemTag){
		$sql = 'INSERT INTO item_tag (name, slug, type, display_order) VALUES (?, ?, ?, ?)';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($itemTag->name);
		$sqlQuery->set($itemTag->slug);
		$sqlQuery->set($itemTag->type);
		$sqlQuery->setNumber($itemTag->displayOrder);

		$id = $this->executeInsert($sqlQuery);	
		$itemTag->id = $id;
		return $id;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param ItemTagMySql itemTag
 	 */
	public function update($itemTag){
		$sql = 'UPDATE item_tag SET name = ?, slug = ?, type = ?, display_order = ? WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($itemTag->name);
		$sqlQuery->set($itemTag->slug);
		$sqlQuery->set($itemTag->type);
		$sqlQuery->setNumber($itemTag->displayOrder);

		$sqlQuery->setNumber($itemTag->id);
		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM item_tag';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}

	public function queryByName($value){
		$sql = 'SELECT * FROM item_tag WHERE name = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryBySlug($value){
		$sql = 'SELECT * FROM item_tag WHERE slug = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByType($value){
		$sql = 'SELECT * FROM item_tag WHERE type = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByDisplayOrder($value){
		$sql = 'SELECT * FROM item_tag WHERE display_order = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}


	public function deleteByName($value){
		$sql = 'DELETE FROM item_tag WHERE name = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteBySlug($value){
		$sql = 'DELETE FROM item_tag WHERE slug = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByType($value){
		$sql = 'DELETE FROM item_tag WHERE type = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByDisplayOrder($value){
		$sql = 'DELETE FROM item_tag WHERE display_order = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}


	
	/**
	 * Read row
	 *
	 * @return ItemTagMySql 
	 */
	protected function readRow($row){
		$itemTag = new ItemTag();
		
		$itemTag->id = $row['id'];
		$itemTag->name = $row['name'];
		$itemTag->slug = $row['slug'];
		$itemTag->type = $row['type'];
		$itemTag->displayOrder = $row['display_order'];

		return $itemTag;
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
	 * @return ItemTagMySql 
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