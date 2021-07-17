<?php
/**
 * Class that operate on table 'items_temp'. Database Mysql.
 */
class ItemsTempMySqlDAO implements ItemsTempDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return ItemsTempMySql 
	 */
	public function load($id){
		$sql = 'SELECT * FROM items_temp WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll(){
		$sql = 'SELECT * FROM items_temp';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM items_temp ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param itemsTemp primary key
 	 */
	public function delete($id){
		$sql = 'DELETE FROM items_temp WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param ItemsTempMySql itemsTemp
 	 */
	public function insert($itemsTemp){
		$sql = 'INSERT INTO items_temp (image1, image2, image3, image4, title, category, sub_category, product_category, sku, description, specs, color, size, weight, dimension, brand_name, stock, price, special_price, warranty, exchange, title_ar, description_ar, specs_ar, color_ar, size_ar, dimensions_ar, warranty_ar, exchange_ar, supplier_id, processed) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($itemsTemp->image1);
		$sqlQuery->set($itemsTemp->image2);
		$sqlQuery->set($itemsTemp->image3);
		$sqlQuery->set($itemsTemp->image4);
		$sqlQuery->set($itemsTemp->title);
		$sqlQuery->set($itemsTemp->category);
		$sqlQuery->set($itemsTemp->subCategory);
		$sqlQuery->set($itemsTemp->productCategory);
		$sqlQuery->set($itemsTemp->sku);
		$sqlQuery->set($itemsTemp->description);
		$sqlQuery->set($itemsTemp->specs);
		$sqlQuery->set($itemsTemp->color);
		$sqlQuery->set($itemsTemp->size);
		$sqlQuery->set($itemsTemp->weight);
		$sqlQuery->set($itemsTemp->dimension);
		$sqlQuery->set($itemsTemp->brandName);
		$sqlQuery->set($itemsTemp->stock);
		$sqlQuery->set($itemsTemp->price);
		$sqlQuery->set($itemsTemp->specialPrice);
		$sqlQuery->set($itemsTemp->warranty);
		$sqlQuery->set($itemsTemp->exchange);
		$sqlQuery->set($itemsTemp->titleAr);
		$sqlQuery->set($itemsTemp->descriptionAr);
		$sqlQuery->set($itemsTemp->specsAr);
		$sqlQuery->set($itemsTemp->colorAr);
		$sqlQuery->set($itemsTemp->sizeAr);
		$sqlQuery->set($itemsTemp->dimensionsAr);
		$sqlQuery->set($itemsTemp->warrantyAr);
		$sqlQuery->set($itemsTemp->exchangeAr);
		$sqlQuery->setNumber($itemsTemp->supplierId);
		$sqlQuery->setNumber($itemsTemp->processed);

		$id = $this->executeInsert($sqlQuery);	
		$itemsTemp->id = $id;
		return $id;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param ItemsTempMySql itemsTemp
 	 */
	public function update($itemsTemp){
		$sql = 'UPDATE items_temp SET image1 = ?, image2 = ?, image3 = ?, image4 = ?, title = ?, category = ?, sub_category = ?, product_category = ?, sku = ?, description = ?, specs = ?, color = ?, size = ?, weight = ?, dimension = ?, brand_name = ?, stock = ?, price = ?, special_price = ?, warranty = ?, exchange = ?, title_ar = ?, description_ar = ?, specs_ar = ?, color_ar = ?, size_ar = ?, dimensions_ar = ?, warranty_ar = ?, exchange_ar = ?, supplier_id = ?, processed = ? WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($itemsTemp->image1);
		$sqlQuery->set($itemsTemp->image2);
		$sqlQuery->set($itemsTemp->image3);
		$sqlQuery->set($itemsTemp->image4);
		$sqlQuery->set($itemsTemp->title);
		$sqlQuery->set($itemsTemp->category);
		$sqlQuery->set($itemsTemp->subCategory);
		$sqlQuery->set($itemsTemp->productCategory);
		$sqlQuery->set($itemsTemp->sku);
		$sqlQuery->set($itemsTemp->description);
		$sqlQuery->set($itemsTemp->specs);
		$sqlQuery->set($itemsTemp->color);
		$sqlQuery->set($itemsTemp->size);
		$sqlQuery->set($itemsTemp->weight);
		$sqlQuery->set($itemsTemp->dimension);
		$sqlQuery->set($itemsTemp->brandName);
		$sqlQuery->set($itemsTemp->stock);
		$sqlQuery->set($itemsTemp->price);
		$sqlQuery->set($itemsTemp->specialPrice);
		$sqlQuery->set($itemsTemp->warranty);
		$sqlQuery->set($itemsTemp->exchange);
		$sqlQuery->set($itemsTemp->titleAr);
		$sqlQuery->set($itemsTemp->descriptionAr);
		$sqlQuery->set($itemsTemp->specsAr);
		$sqlQuery->set($itemsTemp->colorAr);
		$sqlQuery->set($itemsTemp->sizeAr);
		$sqlQuery->set($itemsTemp->dimensionsAr);
		$sqlQuery->set($itemsTemp->warrantyAr);
		$sqlQuery->set($itemsTemp->exchangeAr);
		$sqlQuery->setNumber($itemsTemp->supplierId);
		$sqlQuery->setNumber($itemsTemp->processed);

		$sqlQuery->setNumber($itemsTemp->id);
		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM items_temp';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}

	public function queryByImage1($value){
		$sql = 'SELECT * FROM items_temp WHERE image1 = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByImage2($value){
		$sql = 'SELECT * FROM items_temp WHERE image2 = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByImage3($value){
		$sql = 'SELECT * FROM items_temp WHERE image3 = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByImage4($value){
		$sql = 'SELECT * FROM items_temp WHERE image4 = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByTitle($value){
		$sql = 'SELECT * FROM items_temp WHERE title = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByCategory($value){
		$sql = 'SELECT * FROM items_temp WHERE category = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryBySubCategory($value){
		$sql = 'SELECT * FROM items_temp WHERE sub_category = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByProductCategory($value){
		$sql = 'SELECT * FROM items_temp WHERE product_category = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryBySku($value){
		$sql = 'SELECT * FROM items_temp WHERE sku = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByDescription($value){
		$sql = 'SELECT * FROM items_temp WHERE description = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryBySpecs($value){
		$sql = 'SELECT * FROM items_temp WHERE specs = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByColor($value){
		$sql = 'SELECT * FROM items_temp WHERE color = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryBySize($value){
		$sql = 'SELECT * FROM items_temp WHERE size = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByWeight($value){
		$sql = 'SELECT * FROM items_temp WHERE weight = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByDimension($value){
		$sql = 'SELECT * FROM items_temp WHERE dimension = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByBrandName($value){
		$sql = 'SELECT * FROM items_temp WHERE brand_name = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByStock($value){
		$sql = 'SELECT * FROM items_temp WHERE stock = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByPrice($value){
		$sql = 'SELECT * FROM items_temp WHERE price = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryBySpecialPrice($value){
		$sql = 'SELECT * FROM items_temp WHERE special_price = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByWarranty($value){
		$sql = 'SELECT * FROM items_temp WHERE warranty = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByExchange($value){
		$sql = 'SELECT * FROM items_temp WHERE exchange = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByTitleAr($value){
		$sql = 'SELECT * FROM items_temp WHERE title_ar = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByDescriptionAr($value){
		$sql = 'SELECT * FROM items_temp WHERE description_ar = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryBySpecsAr($value){
		$sql = 'SELECT * FROM items_temp WHERE specs_ar = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByColorAr($value){
		$sql = 'SELECT * FROM items_temp WHERE color_ar = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryBySizeAr($value){
		$sql = 'SELECT * FROM items_temp WHERE size_ar = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByDimensionsAr($value){
		$sql = 'SELECT * FROM items_temp WHERE dimensions_ar = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByWarrantyAr($value){
		$sql = 'SELECT * FROM items_temp WHERE warranty_ar = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByExchangeAr($value){
		$sql = 'SELECT * FROM items_temp WHERE exchange_ar = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryBySupplierId($value){
		$sql = 'SELECT * FROM items_temp WHERE supplier_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByProcessed($value){
		$sql = 'SELECT * FROM items_temp WHERE processed = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}


	public function deleteByImage1($value){
		$sql = 'DELETE FROM items_temp WHERE image1 = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByImage2($value){
		$sql = 'DELETE FROM items_temp WHERE image2 = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByImage3($value){
		$sql = 'DELETE FROM items_temp WHERE image3 = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByImage4($value){
		$sql = 'DELETE FROM items_temp WHERE image4 = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByTitle($value){
		$sql = 'DELETE FROM items_temp WHERE title = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByCategory($value){
		$sql = 'DELETE FROM items_temp WHERE category = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteBySubCategory($value){
		$sql = 'DELETE FROM items_temp WHERE sub_category = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByProductCategory($value){
		$sql = 'DELETE FROM items_temp WHERE product_category = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteBySku($value){
		$sql = 'DELETE FROM items_temp WHERE sku = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByDescription($value){
		$sql = 'DELETE FROM items_temp WHERE description = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteBySpecs($value){
		$sql = 'DELETE FROM items_temp WHERE specs = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByColor($value){
		$sql = 'DELETE FROM items_temp WHERE color = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteBySize($value){
		$sql = 'DELETE FROM items_temp WHERE size = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByWeight($value){
		$sql = 'DELETE FROM items_temp WHERE weight = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByDimension($value){
		$sql = 'DELETE FROM items_temp WHERE dimension = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByBrandName($value){
		$sql = 'DELETE FROM items_temp WHERE brand_name = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByStock($value){
		$sql = 'DELETE FROM items_temp WHERE stock = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByPrice($value){
		$sql = 'DELETE FROM items_temp WHERE price = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteBySpecialPrice($value){
		$sql = 'DELETE FROM items_temp WHERE special_price = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByWarranty($value){
		$sql = 'DELETE FROM items_temp WHERE warranty = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByExchange($value){
		$sql = 'DELETE FROM items_temp WHERE exchange = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByTitleAr($value){
		$sql = 'DELETE FROM items_temp WHERE title_ar = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByDescriptionAr($value){
		$sql = 'DELETE FROM items_temp WHERE description_ar = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteBySpecsAr($value){
		$sql = 'DELETE FROM items_temp WHERE specs_ar = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByColorAr($value){
		$sql = 'DELETE FROM items_temp WHERE color_ar = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteBySizeAr($value){
		$sql = 'DELETE FROM items_temp WHERE size_ar = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByDimensionsAr($value){
		$sql = 'DELETE FROM items_temp WHERE dimensions_ar = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByWarrantyAr($value){
		$sql = 'DELETE FROM items_temp WHERE warranty_ar = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByExchangeAr($value){
		$sql = 'DELETE FROM items_temp WHERE exchange_ar = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteBySupplierId($value){
		$sql = 'DELETE FROM items_temp WHERE supplier_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByProcessed($value){
		$sql = 'DELETE FROM items_temp WHERE processed = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}


	
	/**
	 * Read row
	 *
	 * @return ItemsTempMySql 
	 */
	protected function readRow($row){
		$itemsTemp = new ItemsTemp();
		
		$itemsTemp->image1 = $row['image1'];
		$itemsTemp->image2 = $row['image2'];
		$itemsTemp->image3 = $row['image3'];
		$itemsTemp->image4 = $row['image4'];
		$itemsTemp->title = $row['title'];
		$itemsTemp->category = $row['category'];
		$itemsTemp->subCategory = $row['sub_category'];
		$itemsTemp->productCategory = $row['product_category'];
		$itemsTemp->sku = $row['sku'];
		$itemsTemp->description = $row['description'];
		$itemsTemp->specs = $row['specs'];
		$itemsTemp->color = $row['color'];
		$itemsTemp->size = $row['size'];
		$itemsTemp->weight = $row['weight'];
		$itemsTemp->dimension = $row['dimension'];
		$itemsTemp->brandName = $row['brand_name'];
		$itemsTemp->stock = $row['stock'];
		$itemsTemp->price = $row['price'];
		$itemsTemp->specialPrice = $row['special_price'];
		$itemsTemp->warranty = $row['warranty'];
		$itemsTemp->exchange = $row['exchange'];
		$itemsTemp->titleAr = $row['title_ar'];
		$itemsTemp->descriptionAr = $row['description_ar'];
		$itemsTemp->specsAr = $row['specs_ar'];
		$itemsTemp->colorAr = $row['color_ar'];
		$itemsTemp->sizeAr = $row['size_ar'];
		$itemsTemp->dimensionsAr = $row['dimensions_ar'];
		$itemsTemp->warrantyAr = $row['warranty_ar'];
		$itemsTemp->exchangeAr = $row['exchange_ar'];
		$itemsTemp->supplierId = $row['supplier_id'];
		$itemsTemp->processed = $row['processed'];
		$itemsTemp->id = $row['id'];

		return $itemsTemp;
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
	 * @return ItemsTempMySql 
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