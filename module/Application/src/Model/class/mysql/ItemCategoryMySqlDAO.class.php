<?php
/**
 * Class that operate on table 'item_category'. Database Mysql.
 */
class ItemCategoryMySqlDAO implements ItemCategoryDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return ItemCategoryMySql 
	 */
	public function load($id){
		$sql = 'SELECT * FROM item_category WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll(){
		$sql = 'SELECT * FROM item_category';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM item_category ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param itemCategory primary key
 	 */
	public function delete($id){
		$sql = 'DELETE FROM item_category WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param ItemCategoryMySql itemCategory
 	 */
	public function insert($itemCategory){
		$sql = 'INSERT INTO item_category (name, image, banner_image, parent_id, slug, display_order, mega_menu_display_order, active, lang_id, translation_id, is_static, is_featured, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($itemCategory->name);
		$sqlQuery->set($itemCategory->image);
		$sqlQuery->set($itemCategory->bannerImage);
		$sqlQuery->setNumber($itemCategory->parentId);
		$sqlQuery->set($itemCategory->slug);
		$sqlQuery->setNumber($itemCategory->displayOrder);
		$sqlQuery->setNumber($itemCategory->megaMenuDisplayOrder);
		$sqlQuery->setNumber($itemCategory->active);
		$sqlQuery->setNumber($itemCategory->langId);
		$sqlQuery->set($itemCategory->translationId);
		$sqlQuery->setNumber($itemCategory->isStatic);
		$sqlQuery->setNumber($itemCategory->isFeatured);
		$sqlQuery->set($itemCategory->createdAt);
		$sqlQuery->set($itemCategory->updatedAt);

		$id = $this->executeInsert($sqlQuery);	
		$itemCategory->id = $id;
		return $id;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param ItemCategoryMySql itemCategory
 	 */
	public function update($itemCategory){
		$sql = 'UPDATE item_category SET name = ?, image = ?, banner_image = ?, parent_id = ?, slug = ?, display_order = ?, mega_menu_display_order = ?, active = ?, lang_id = ?, translation_id = ?, is_static = ?, is_featured = ?, created_at = ?, updated_at = ? WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($itemCategory->name);
		$sqlQuery->set($itemCategory->image);
		$sqlQuery->set($itemCategory->bannerImage);
		$sqlQuery->setNumber($itemCategory->parentId);
		$sqlQuery->set($itemCategory->slug);
		$sqlQuery->setNumber($itemCategory->displayOrder);
		$sqlQuery->setNumber($itemCategory->megaMenuDisplayOrder);
		$sqlQuery->setNumber($itemCategory->active);
		$sqlQuery->setNumber($itemCategory->langId);
		$sqlQuery->set($itemCategory->translationId);
		$sqlQuery->setNumber($itemCategory->isStatic);
		$sqlQuery->setNumber($itemCategory->isFeatured);
		$sqlQuery->set($itemCategory->createdAt);
		$sqlQuery->set($itemCategory->updatedAt);

		$sqlQuery->setNumber($itemCategory->id);
		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM item_category';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}

	public function queryByName($value){
		$sql = 'SELECT * FROM item_category WHERE name = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByImage($value){
		$sql = 'SELECT * FROM item_category WHERE image = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByBannerImage($value){
		$sql = 'SELECT * FROM item_category WHERE banner_image = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByParentId($value){
		$sql = 'SELECT * FROM item_category WHERE parent_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryBySlug($value){
		$sql = 'SELECT * FROM item_category WHERE slug = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByDisplayOrder($value){
		$sql = 'SELECT * FROM item_category WHERE display_order = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByMegaMenuDisplayOrder($value){
		$sql = 'SELECT * FROM item_category WHERE mega_menu_display_order = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByActive($value){
		$sql = 'SELECT * FROM item_category WHERE active = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByLangId($value){
		$sql = 'SELECT * FROM item_category WHERE lang_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByTranslationId($value){
		$sql = 'SELECT * FROM item_category WHERE translation_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByIsStatic($value){
		$sql = 'SELECT * FROM item_category WHERE is_static = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByIsFeatured($value){
		$sql = 'SELECT * FROM item_category WHERE is_featured = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByCreatedAt($value){
		$sql = 'SELECT * FROM item_category WHERE created_at = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByUpdatedAt($value){
		$sql = 'SELECT * FROM item_category WHERE updated_at = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}


	public function deleteByName($value){
		$sql = 'DELETE FROM item_category WHERE name = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByImage($value){
		$sql = 'DELETE FROM item_category WHERE image = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByBannerImage($value){
		$sql = 'DELETE FROM item_category WHERE banner_image = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByParentId($value){
		$sql = 'DELETE FROM item_category WHERE parent_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteBySlug($value){
		$sql = 'DELETE FROM item_category WHERE slug = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByDisplayOrder($value){
		$sql = 'DELETE FROM item_category WHERE display_order = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByMegaMenuDisplayOrder($value){
		$sql = 'DELETE FROM item_category WHERE mega_menu_display_order = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByActive($value){
		$sql = 'DELETE FROM item_category WHERE active = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByLangId($value){
		$sql = 'DELETE FROM item_category WHERE lang_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByTranslationId($value){
		$sql = 'DELETE FROM item_category WHERE translation_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByIsStatic($value){
		$sql = 'DELETE FROM item_category WHERE is_static = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByIsFeatured($value){
		$sql = 'DELETE FROM item_category WHERE is_featured = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByCreatedAt($value){
		$sql = 'DELETE FROM item_category WHERE created_at = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByUpdatedAt($value){
		$sql = 'DELETE FROM item_category WHERE updated_at = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}


	
	/**
	 * Read row
	 *
	 * @return ItemCategoryMySql 
	 */
	protected function readRow($row){
		$itemCategory = new ItemCategory();
		
		$itemCategory->id = $row['id'];
		$itemCategory->name = $row['name'];
		$itemCategory->image = $row['image'];
		$itemCategory->bannerImage = $row['banner_image'];
		$itemCategory->parentId = $row['parent_id'];
		$itemCategory->slug = $row['slug'];
		$itemCategory->displayOrder = $row['display_order'];
		$itemCategory->megaMenuDisplayOrder = $row['mega_menu_display_order'];
		$itemCategory->active = $row['active'];
		$itemCategory->langId = $row['lang_id'];
		$itemCategory->translationId = $row['translation_id'];
		$itemCategory->isStatic = $row['is_static'];
		$itemCategory->isFeatured = $row['is_featured'];
		$itemCategory->createdAt = $row['created_at'];
		$itemCategory->updatedAt = $row['updated_at'];

		// ++
		$itemCategory->arabicName = isset($row['arabic_name']) ? $row['arabic_name'] : '';

		return $itemCategory;
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
	 * @return ItemCategoryMySql 
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