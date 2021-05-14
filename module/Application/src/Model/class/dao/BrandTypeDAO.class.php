<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2021-05-14 19:34
 */
interface BrandTypeDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return BrandType 
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
 	 * @param brandType primary key
 	 */
	public function delete($id);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param BrandType brandType
 	 */
	public function insert($brandType);
	
	/**
 	 * Update record in table
 	 *
 	 * @param BrandType brandType
 	 */
	public function update($brandType);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByName($value);

	public function queryByImage($value);

	public function queryByDisplayOrder($value);


	public function deleteByName($value);

	public function deleteByImage($value);

	public function deleteByDisplayOrder($value);


}
?>