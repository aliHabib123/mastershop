<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2021-05-14 19:34
 */
interface ImageDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return Image 
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
 	 * @param image primary key
 	 */
	public function delete($id);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param Image image
 	 */
	public function insert($image);
	
	/**
 	 * Update record in table
 	 *
 	 * @param Image image
 	 */
	public function update($image);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByCaption($value);

	public function queryByImageName($value);

	public function queryByAlbumId($value);


	public function deleteByCaption($value);

	public function deleteByImageName($value);

	public function deleteByAlbumId($value);


}
?>