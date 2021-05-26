<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2021-05-14 19:34
 */
interface ItemTagDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return ItemTag 
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
 	 * @param itemTag primary key
 	 */
	public function delete($id);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param ItemTag itemTag
 	 */
	public function insert($itemTag);
	
	/**
 	 * Update record in table
 	 *
 	 * @param ItemTag itemTag
 	 */
	public function update($itemTag);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByName($value);

	public function queryBySlug($value);

	public function queryByType($value);

	public function queryByDisplayOrder($value);


	public function deleteByName($value);

	public function deleteBySlug($value);

	public function deleteByType($value);

	public function deleteByDisplayOrder($value);


}
?>