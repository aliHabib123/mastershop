<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2021-05-31 12:29
 */
interface ItemBrandMappingDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return ItemBrandMapping 
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
 	 * @param itemBrandMapping primary key
 	 */
	public function delete($id);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param ItemBrandMapping itemBrandMapping
 	 */
	public function insert($itemBrandMapping);
	
	/**
 	 * Update record in table
 	 *
 	 * @param ItemBrandMapping itemBrandMapping
 	 */
	public function update($itemBrandMapping);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByItemId($value);

	public function queryByBrandId($value);


	public function deleteByItemId($value);

	public function deleteByBrandId($value);


}
?>