<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2021-05-15 20:57
 */
interface BannerImageDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return BannerImage 
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
 	 * @param bannerImage primary key
 	 */
	public function delete($id);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param BannerImage bannerImage
 	 */
	public function insert($bannerImage);
	
	/**
 	 * Update record in table
 	 *
 	 * @param BannerImage bannerImage
 	 */
	public function update($bannerImage);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByCaption1($value);

	public function queryByCaption2($value);

	public function queryByButtonText($value);

	public function queryByButtonLink($value);

	public function queryByButtonLinkTarget($value);

	public function queryByImageName($value);

	public function queryByBannerId($value);


	public function deleteByCaption1($value);

	public function deleteByCaption2($value);

	public function deleteByButtonText($value);

	public function deleteByButtonLink($value);

	public function deleteByButtonLinkTarget($value);

	public function deleteByImageName($value);

	public function deleteByBannerId($value);


}
?>