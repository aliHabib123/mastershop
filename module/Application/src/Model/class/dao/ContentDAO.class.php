<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2021-05-14 19:34
 */
interface ContentDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return Content 
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
 	 * @param content primary key
 	 */
	public function delete($id);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param Content content
 	 */
	public function insert($content);
	
	/**
 	 * Update record in table
 	 *
 	 * @param Content content
 	 */
	public function update($content);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByParentId($value);

	public function queryByTitle($value);

	public function queryBySubtitle($value);

	public function queryByDetails($value);

	public function queryByImage($value);

	public function queryByFile($value);

	public function queryByAlbumId($value);

	public function queryByCustomUrl($value);

	public function queryBySlug($value);

	public function queryByDisplayOrder($value);

	public function queryByActive($value);

	public function queryByType($value);

	public function queryByMimeType($value);

	public function queryByLang($value);

	public function queryByTranslationId($value);

	public function queryByCanDelete($value);

	public function deleteByParentId($value);

	public function deleteByTitle($value);

	public function deleteBySubtitle($value);

	public function deleteByDetails($value);

	public function deleteByImage($value);

	public function deleteByFile($value);

	public function deleteByAlbumId($value);

	public function deleteByCustomUrl($value);

	public function deleteBySlug($value);

	public function deleteByDisplayOrder($value);

	public function deleteByActive($value);

	public function deleteByType($value);

	public function deleteByMimeType($value);

	public function deleteByLang($value);

	public function deleteByTranslationId($value);

	public function deleteByCanDelete($value);


}
?>