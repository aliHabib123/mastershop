<?php
/**
 * Intreface DAO
 */
interface ItemCategoryDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return ItemCategory 
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
 	 * @param itemCategory primary key
 	 */
	public function delete($id);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param ItemCategory itemCategory
 	 */
	public function insert($itemCategory);
	
	/**
 	 * Update record in table
 	 *
 	 * @param ItemCategory itemCategory
 	 */
	public function update($itemCategory);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByName($value);

	public function queryByImage($value);

	public function queryByBannerImage($value);

	public function queryByParentId($value);

	public function queryBySlug($value);

	public function queryByDisplayOrder($value);

	public function queryByMegaMenuDisplayOrder($value);

	public function queryByActive($value);

	public function queryByLangId($value);

	public function queryByTranslationId($value);

	public function queryByIsStatic($value);

	public function queryByIsFeatured($value);

	public function queryByCreatedAt($value);

	public function queryByUpdatedAt($value);


	public function deleteByName($value);

	public function deleteByImage($value);

	public function deleteByBannerImage($value);

	public function deleteByParentId($value);

	public function deleteBySlug($value);

	public function deleteByDisplayOrder($value);

	public function deleteByMegaMenuDisplayOrder($value);

	public function deleteByActive($value);

	public function deleteByLangId($value);

	public function deleteByTranslationId($value);

	public function deleteByIsStatic($value);

	public function deleteByIsFeatured($value);

	public function deleteByCreatedAt($value);

	public function deleteByUpdatedAt($value);


}
?>