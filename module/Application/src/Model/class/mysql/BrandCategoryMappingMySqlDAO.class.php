<?php
/**
 * Class that operate on table 'brand_category_mapping'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2021-05-21 16:28
 */
class BrandCategoryMappingMySqlDAO implements BrandCategoryMappingDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return BrandCategoryMappingMySql 
	 */
	public function load($id){
		$sql = 'SELECT * FROM brand_category_mapping WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($id);
		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll(){
		$sql = 'SELECT * FROM brand_category_mapping';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM brand_category_mapping ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param brandCategoryMapping primary key
 	 */
	public function delete($id){
		$sql = 'DELETE FROM brand_category_mapping WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($id);
		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param BrandCategoryMappingMySql brandCategoryMapping
 	 */
	public function insert($brandCategoryMapping){
		$sql = 'INSERT INTO brand_category_mapping (brand_id, category_id) VALUES (?, ?)';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->setNumber($brandCategoryMapping->brandId);
		$sqlQuery->setNumber($brandCategoryMapping->categoryId);

		$id = $this->executeInsert($sqlQuery);	
		$brandCategoryMapping->id = $id;
		return $id;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param BrandCategoryMappingMySql brandCategoryMapping
 	 */
	public function update($brandCategoryMapping){
		$sql = 'UPDATE brand_category_mapping SET brand_id = ?, category_id = ? WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->setNumber($brandCategoryMapping->brandId);
		$sqlQuery->setNumber($brandCategoryMapping->categoryId);

		$sqlQuery->set($brandCategoryMapping->id);
		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM brand_category_mapping';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}

	public function queryByBrandId($value){
		$sql = 'SELECT * FROM brand_category_mapping WHERE brand_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByCategoryId($value){
		$sql = 'SELECT * FROM brand_category_mapping WHERE category_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}


	public function deleteByBrandId($value){
		$sql = 'DELETE FROM brand_category_mapping WHERE brand_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByCategoryId($value){
		$sql = 'DELETE FROM brand_category_mapping WHERE category_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}


	
	/**
	 * Read row
	 *
	 * @return BrandCategoryMappingMySql 
	 */
	protected function readRow($row){
		$brandCategoryMapping = new BrandCategoryMapping();
		
		$brandCategoryMapping->id = $row['id'];
		$brandCategoryMapping->brandId = $row['brand_id'];
		$brandCategoryMapping->categoryId = $row['category_id'];
		$brandCategoryMapping->categoryName = isset($row['name']) ? $row['name'] : "";

		return $brandCategoryMapping;
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
	 * @return BrandCategoryMappingMySql 
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
