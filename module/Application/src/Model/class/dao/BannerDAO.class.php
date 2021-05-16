<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2021-05-16 16:32
 */
interface BannerDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return Banner 
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
 	 * @param banner primary key
 	 */
	public function delete($id);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param Banner banner
 	 */
	public function insert($banner);
	
	/**
 	 * Update record in table
 	 *
 	 * @param Banner banner
 	 */
	public function update($banner);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByTitle($value);

	public function queryByLocation($value);

	public function queryByImage($value);

	public function queryByDisplayOrder($value);

	public function queryByActive($value);


	public function deleteByTitle($value);

	public function deleteByLocation($value);

	public function deleteByImage($value);

	public function deleteByDisplayOrder($value);

	public function deleteByActive($value);


}
?>