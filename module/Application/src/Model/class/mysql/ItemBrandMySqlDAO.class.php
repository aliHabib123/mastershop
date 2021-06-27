<?php
/**
 * Class that operate on table 'item_brand'. Database Mysql.
 */
class ItemBrandMySqlDAO implements ItemBrandDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return ItemBrandMySql 
	 */
	public function load($id){
		$sql = 'SELECT * FROM item_brand WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($id);
		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll(){
		$sql = 'SELECT * FROM item_brand';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM item_brand ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param itemBrand primary key
 	 */
	public function delete($id){
		$sql = 'DELETE FROM item_brand WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($id);
		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param ItemBrandMySql itemBrand
 	 */
	public function insert($itemBrand){
		$sql = 'INSERT INTO item_brand (name, image, brand_type_id, show_in_menu, display_order) VALUES (?, ?, ?, ?, ?)';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($itemBrand->name);
		$sqlQuery->set($itemBrand->image);
		$sqlQuery->setNumber($itemBrand->brandTypeId);
		$sqlQuery->setNumber($itemBrand->showInMenu);
		$sqlQuery->setNumber($itemBrand->displayOrder);

		$id = $this->executeInsert($sqlQuery);	
		$itemBrand->id = $id;
		return $id;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param ItemBrandMySql itemBrand
 	 */
	public function update($itemBrand){
		$sql = 'UPDATE item_brand SET name = ?, image = ?, brand_type_id = ?, show_in_menu = ?, display_order = ? WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($itemBrand->name);
		$sqlQuery->set($itemBrand->image);
		$sqlQuery->setNumber($itemBrand->brandTypeId);
		$sqlQuery->setNumber($itemBrand->showInMenu);
		$sqlQuery->setNumber($itemBrand->displayOrder);

		$sqlQuery->set($itemBrand->id);
		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM item_brand';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}

	public function queryByName($value){
		$sql = 'SELECT * FROM item_brand WHERE name = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByImage($value){
		$sql = 'SELECT * FROM item_brand WHERE image = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByBrandTypeId($value){
		$sql = 'SELECT * FROM item_brand WHERE brand_type_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByShowInMenu($value){
		$sql = 'SELECT * FROM item_brand WHERE show_in_menu = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByDisplayOrder($value){
		$sql = 'SELECT * FROM item_brand WHERE display_order = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}


	public function deleteByName($value){
		$sql = 'DELETE FROM item_brand WHERE name = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByImage($value){
		$sql = 'DELETE FROM item_brand WHERE image = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByBrandTypeId($value){
		$sql = 'DELETE FROM item_brand WHERE brand_type_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByShowInMenu($value){
		$sql = 'DELETE FROM item_brand WHERE show_in_menu = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByDisplayOrder($value){
		$sql = 'DELETE FROM item_brand WHERE display_order = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}


	
	/**
	 * Read row
	 *
	 * @return ItemBrandMySql 
	 */
	protected function readRow($row){
		$itemBrand = new ItemBrand();
		
		$itemBrand->id = $row['id'];
		$itemBrand->name = $row['name'];
		$itemBrand->image = $row['image'];
		$itemBrand->brandTypeId = $row['brand_type_id'];
		$itemBrand->showInMenu = $row['show_in_menu'];
		$itemBrand->displayOrder = $row['display_order'];

		return $itemBrand;
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
	 * @return ItemBrandMySql 
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