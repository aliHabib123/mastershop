<?php
/**
 * Intreface DAO
 */
interface ItemDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return Item 
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
 	 * @param item primary key
 	 */
	public function delete($id);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param Item item
 	 */
	public function insert($item);
	
	/**
 	 * Update record in table
 	 *
 	 * @param Item item
 	 */
	public function update($item);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByTitle($value);

	public function queryByDescription($value);

	public function queryByImage($value);

	public function queryByRegularPrice($value);

	public function queryBySalePrice($value);

	public function queryByWeight($value);

	public function queryByHeight($value);

	public function queryByWidth($value);

	public function queryBySku($value);

	public function queryByQty($value);

	public function queryBySpecification($value);

	public function queryByColor($value);

	public function queryBySize($value);

	public function queryByDimensions($value);

	public function queryByWarranty($value);

	public function queryByExchange($value);

	public function queryByStatus($value);

	public function queryByIsFeatured($value);

	public function queryByIsNew($value);

	public function queryBySupplierId($value);

	public function queryByDisplayOrder($value);

	public function queryByLangId($value);

	public function queryByTranslationId($value);

	public function queryByAlbumId($value);

	public function queryBySlug($value);

	public function queryByCreatedAt($value);

	public function queryByUpdatedAt($value);


	public function deleteByTitle($value);

	public function deleteByDescription($value);

	public function deleteByImage($value);

	public function deleteByRegularPrice($value);

	public function deleteBySalePrice($value);

	public function deleteByWeight($value);

	public function deleteByHeight($value);

	public function deleteByWidth($value);

	public function deleteBySku($value);

	public function deleteByQty($value);

	public function deleteBySpecification($value);

	public function deleteByColor($value);

	public function deleteBySize($value);

	public function deleteByDimensions($value);

	public function deleteByWarranty($value);

	public function deleteByExchange($value);

	public function deleteByStatus($value);

	public function deleteByIsFeatured($value);

	public function deleteByIsNew($value);

	public function deleteBySupplierId($value);

	public function deleteByDisplayOrder($value);

	public function deleteByLangId($value);

	public function deleteByTranslationId($value);

	public function deleteByAlbumId($value);

	public function deleteBySlug($value);

	public function deleteByCreatedAt($value);

	public function deleteByUpdatedAt($value);


}
?>