<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2021-05-21 16:28
 */
interface BrandCategoryMappingDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return BrandCategoryMapping 
	 */
	public function load($id);

	/**
	 * Get all records from table
	 */
	public function queryAll();
	
	/**
	 * Get all records from table ordered by field
	 * @Param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn);
	
	/**
 	 * Delete record from table
 	 * @param brandCategoryMapping primary key
 	 */
	public function delete($id);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param BrandCategoryMapping brandCategoryMapping
 	 */
	public function insert($brandCategoryMapping);
	
	/**
 	 * Update record in table
 	 *
 	 * @param BrandCategoryMapping brandCategoryMapping
 	 */
	public function update($brandCategoryMapping);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByBrandId($value);

	public function queryByCategoryId($value);


	public function deleteByBrandId($value);

	public function deleteByCategoryId($value);


}
?>