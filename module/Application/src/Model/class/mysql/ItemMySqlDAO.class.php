<?php
/**
 * Class that operate on table 'item'. Database Mysql.
 */
class ItemMySqlDAO implements ItemDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return ItemMySql 
	 */
	public function load($id){
		$sql = 'SELECT * FROM item WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($id);
		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll(){
		$sql = 'SELECT * FROM item';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM item ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param item primary key
 	 */
	public function delete($id){
		$sql = 'DELETE FROM item WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($id);
		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param ItemMySql item
 	 */
	public function insert($item){
		$sql = 'INSERT INTO item (title, description, image, regular_price, sale_price, weight, height, width, sku, qty, specification, color, size, dimensions, warranty, exchange, status, is_featured, is_new, supplier_id, display_order, lang_id, translation_id, album_id, slug, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($item->title);
		$sqlQuery->set($item->description);
		$sqlQuery->set($item->image);
		$sqlQuery->set($item->regularPrice);
		$sqlQuery->set($item->salePrice);
		$sqlQuery->set($item->weight);
		$sqlQuery->set($item->height);
		$sqlQuery->set($item->width);
		$sqlQuery->set($item->sku);
		$sqlQuery->setNumber($item->qty);
		$sqlQuery->set($item->specification);
		$sqlQuery->set($item->color);
		$sqlQuery->set($item->size);
		$sqlQuery->set($item->dimensions);
		$sqlQuery->set($item->warranty);
		$sqlQuery->set($item->exchange);
		$sqlQuery->set($item->status);
		$sqlQuery->set($item->isFeatured);
		$sqlQuery->set($item->isNew);
		$sqlQuery->setNumber($item->supplierId);
		$sqlQuery->setNumber($item->displayOrder);
		$sqlQuery->setNumber($item->langId);
		$sqlQuery->set($item->translationId);
		$sqlQuery->set($item->albumId);
		$sqlQuery->set($item->slug);
		$sqlQuery->set($item->createdAt);
		$sqlQuery->set($item->updatedAt);

		$id = $this->executeInsert($sqlQuery);	
		$item->id = $id;
		return $id;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param ItemMySql item
 	 */
	public function update($item){
		$sql = 'UPDATE item SET title = ?, description = ?, image = ?, regular_price = ?, sale_price = ?, weight = ?, height = ?, width = ?, sku = ?, qty = ?, specification = ?, color = ?, size = ?, dimensions = ?, warranty = ?, exchange = ?, status = ?, is_featured = ?, is_new = ?, supplier_id = ?, display_order = ?, lang_id = ?, translation_id = ?, album_id = ?, slug = ?, created_at = ?, updated_at = ? WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($item->title);
		$sqlQuery->set($item->description);
		$sqlQuery->set($item->image);
		$sqlQuery->set($item->regularPrice);
		$sqlQuery->set($item->salePrice);
		$sqlQuery->set($item->weight);
		$sqlQuery->set($item->height);
		$sqlQuery->set($item->width);
		$sqlQuery->set($item->sku);
		$sqlQuery->setNumber($item->qty);
		$sqlQuery->set($item->specification);
		$sqlQuery->set($item->color);
		$sqlQuery->set($item->size);
		$sqlQuery->set($item->dimensions);
		$sqlQuery->set($item->warranty);
		$sqlQuery->set($item->exchange);
		$sqlQuery->set($item->status);
		$sqlQuery->set($item->isFeatured);
		$sqlQuery->set($item->isNew);
		$sqlQuery->setNumber($item->supplierId);
		$sqlQuery->setNumber($item->displayOrder);
		$sqlQuery->setNumber($item->langId);
		$sqlQuery->set($item->translationId);
		$sqlQuery->set($item->albumId);
		$sqlQuery->set($item->slug);
		$sqlQuery->set($item->createdAt);
		$sqlQuery->set($item->updatedAt);

		$sqlQuery->set($item->id);
		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM item';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}

	public function queryByTitle($value){
		$sql = 'SELECT * FROM item WHERE title = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByDescription($value){
		$sql = 'SELECT * FROM item WHERE description = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByImage($value){
		$sql = 'SELECT * FROM item WHERE image = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByRegularPrice($value){
		$sql = 'SELECT * FROM item WHERE regular_price = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryBySalePrice($value){
		$sql = 'SELECT * FROM item WHERE sale_price = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByWeight($value){
		$sql = 'SELECT * FROM item WHERE weight = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByHeight($value){
		$sql = 'SELECT * FROM item WHERE height = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByWidth($value){
		$sql = 'SELECT * FROM item WHERE width = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryBySku($value){
		$sql = 'SELECT * FROM item WHERE sku = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByQty($value){
		$sql = 'SELECT * FROM item WHERE qty = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryBySpecification($value){
		$sql = 'SELECT * FROM item WHERE specification = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByColor($value){
		$sql = 'SELECT * FROM item WHERE color = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryBySize($value){
		$sql = 'SELECT * FROM item WHERE size = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByDimensions($value){
		$sql = 'SELECT * FROM item WHERE dimensions = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByWarranty($value){
		$sql = 'SELECT * FROM item WHERE warranty = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByExchange($value){
		$sql = 'SELECT * FROM item WHERE exchange = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByStatus($value){
		$sql = 'SELECT * FROM item WHERE status = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByIsFeatured($value){
		$sql = 'SELECT * FROM item WHERE is_featured = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByIsNew($value){
		$sql = 'SELECT * FROM item WHERE is_new = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryBySupplierId($value){
		$sql = 'SELECT * FROM item WHERE supplier_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByDisplayOrder($value){
		$sql = 'SELECT * FROM item WHERE display_order = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByLangId($value){
		$sql = 'SELECT * FROM item WHERE lang_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByTranslationId($value){
		$sql = 'SELECT * FROM item WHERE translation_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByAlbumId($value){
		$sql = 'SELECT * FROM item WHERE album_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryBySlug($value){
		$sql = 'SELECT * FROM item WHERE slug = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByCreatedAt($value){
		$sql = 'SELECT * FROM item WHERE created_at = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByUpdatedAt($value){
		$sql = 'SELECT * FROM item WHERE updated_at = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}


	public function deleteByTitle($value){
		$sql = 'DELETE FROM item WHERE title = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByDescription($value){
		$sql = 'DELETE FROM item WHERE description = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByImage($value){
		$sql = 'DELETE FROM item WHERE image = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByRegularPrice($value){
		$sql = 'DELETE FROM item WHERE regular_price = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteBySalePrice($value){
		$sql = 'DELETE FROM item WHERE sale_price = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByWeight($value){
		$sql = 'DELETE FROM item WHERE weight = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByHeight($value){
		$sql = 'DELETE FROM item WHERE height = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByWidth($value){
		$sql = 'DELETE FROM item WHERE width = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteBySku($value){
		$sql = 'DELETE FROM item WHERE sku = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByQty($value){
		$sql = 'DELETE FROM item WHERE qty = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteBySpecification($value){
		$sql = 'DELETE FROM item WHERE specification = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByColor($value){
		$sql = 'DELETE FROM item WHERE color = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteBySize($value){
		$sql = 'DELETE FROM item WHERE size = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByDimensions($value){
		$sql = 'DELETE FROM item WHERE dimensions = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByWarranty($value){
		$sql = 'DELETE FROM item WHERE warranty = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByExchange($value){
		$sql = 'DELETE FROM item WHERE exchange = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByStatus($value){
		$sql = 'DELETE FROM item WHERE status = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByIsFeatured($value){
		$sql = 'DELETE FROM item WHERE is_featured = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByIsNew($value){
		$sql = 'DELETE FROM item WHERE is_new = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteBySupplierId($value){
		$sql = 'DELETE FROM item WHERE supplier_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByDisplayOrder($value){
		$sql = 'DELETE FROM item WHERE display_order = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByLangId($value){
		$sql = 'DELETE FROM item WHERE lang_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByTranslationId($value){
		$sql = 'DELETE FROM item WHERE translation_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByAlbumId($value){
		$sql = 'DELETE FROM item WHERE album_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteBySlug($value){
		$sql = 'DELETE FROM item WHERE slug = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByCreatedAt($value){
		$sql = 'DELETE FROM item WHERE created_at = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByUpdatedAt($value){
		$sql = 'DELETE FROM item WHERE updated_at = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}


	
	/**
	 * Read row
	 *
	 * @return ItemMySql 
	 */
	protected function readRow($row){
		$item = new Item();
		
		$item->id = $row['id'];
		$item->title = $row['title'];
		$item->description = $row['description'];
		$item->image = $row['image'];
		$item->regularPrice = $row['regular_price'];
		$item->salePrice = $row['sale_price'];
		$item->weight = $row['weight'];
		$item->height = $row['height'];
		$item->width = $row['width'];
		$item->sku = $row['sku'];
		$item->qty = $row['qty'];
		$item->specification = $row['specification'];
		$item->color = $row['color'];
		$item->size = $row['size'];
		$item->dimensions = $row['dimensions'];
		$item->warranty = $row['warranty'];
		$item->exchange = $row['exchange'];
		$item->status = $row['status'];
		$item->isFeatured = $row['is_featured'];
		$item->isNew = $row['is_new'];
		$item->supplierId = $row['supplier_id'];
		$item->displayOrder = $row['display_order'];
		$item->langId = $row['lang_id'];
		$item->translationId = $row['translation_id'];
		$item->albumId = $row['album_id'];
		$item->slug = $row['slug'];
		$item->createdAt = $row['created_at'];
		$item->updatedAt = $row['updated_at'];

		//+
		$item->cartId = isset($row['cart_id']) ? $row['cart_id'] : "";
		$item->cartQty = isset($row['cart_qty']) ? $row['cart_qty'] : "";
		$item->companyName = isset($row['company_name']) ? $row['company_name'] : "";
		$item->companyCommission = isset($row['company_commission']) ? $row['company_commission'] : 0;
		$item->supplierstatus = isset($row['status']) ? $row['status'] : "";
		$item->usdExchangeRate = isset($row['usd_exchange_rate']) ? $row['usd_exchange_rate'] :"";

		return $item;
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
	 * @return ItemMySql 
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