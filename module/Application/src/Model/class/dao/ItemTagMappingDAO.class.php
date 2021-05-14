<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2021-05-14 19:34
 */
interface ItemTagMappingDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return ItemTagMapping 
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
 	 * @param itemTagMapping primary key
 	 */
	public function delete($id);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param ItemTagMapping itemTagMapping
 	 */
	public function insert($itemTagMapping);
	
	/**
 	 * Update record in table
 	 *
 	 * @param ItemTagMapping itemTagMapping
 	 */
	public function update($itemTagMapping);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByItemId($value);

	public function queryByTagId($value);


	public function deleteByItemId($value);

	public function deleteByTagId($value);


}
?>