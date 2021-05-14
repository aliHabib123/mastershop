<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2021-05-14 19:34
 */
interface SocialMediaDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return SocialMedia 
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
 	 * @param socialMedia primary key
 	 */
	public function delete($id);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param SocialMedia socialMedia
 	 */
	public function insert($socialMedia);
	
	/**
 	 * Update record in table
 	 *
 	 * @param SocialMedia socialMedia
 	 */
	public function update($socialMedia);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByName($value);

	public function queryByUrl($value);

	public function queryByActive($value);

	public function queryByDisplayOrder($value);


	public function deleteByName($value);

	public function deleteByUrl($value);

	public function deleteByActive($value);

	public function deleteByDisplayOrder($value);


}
?>