<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2021-05-14 19:34
 */
interface ItemAttributeMappingDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return ItemAttributeMapping 
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
 	 * @param itemAttributeMapping primary key
 	 */
	public function delete($id);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param ItemAttributeMapping itemAttributeMapping
 	 */
	public function insert($itemAttributeMapping);
	
	/**
 	 * Update record in table
 	 *
 	 * @param ItemAttributeMapping itemAttributeMapping
 	 */
	public function update($itemAttributeMapping);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByItemId($value);

	public function queryByAttributeId($value);

	public function queryByValue($value);

	public function queryByDisplayOrder($value);


	public function deleteByItemId($value);

	public function deleteByAttributeId($value);

	public function deleteByValue($value);

	public function deleteByDisplayOrder($value);


}
?>