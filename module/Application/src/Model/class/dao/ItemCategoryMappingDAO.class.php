<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2021-05-14 19:34
 */
interface ItemCategoryMappingDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return ItemCategoryMapping 
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
 	 * @param itemCategoryMapping primary key
 	 */
	public function delete($id);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param ItemCategoryMapping itemCategoryMapping
 	 */
	public function insert($itemCategoryMapping);
	
	/**
 	 * Update record in table
 	 *
 	 * @param ItemCategoryMapping itemCategoryMapping
 	 */
	public function update($itemCategoryMapping);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByItemId($value);

	public function queryByCategoryId($value);


	public function deleteByItemId($value);

	public function deleteByCategoryId($value);


}
?>