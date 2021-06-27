<?php
/**
 * Intreface DAO
 */
interface ItemBrandDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return ItemBrand 
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
 	 * @param itemBrand primary key
 	 */
	public function delete($id);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param ItemBrand itemBrand
 	 */
	public function insert($itemBrand);
	
	/**
 	 * Update record in table
 	 *
 	 * @param ItemBrand itemBrand
 	 */
	public function update($itemBrand);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByName($value);

	public function queryByImage($value);

	public function queryByBrandTypeId($value);

	public function queryByShowInMenu($value);

	public function queryByDisplayOrder($value);


	public function deleteByName($value);

	public function deleteByImage($value);

	public function deleteByBrandTypeId($value);

	public function deleteByShowInMenu($value);

	public function deleteByDisplayOrder($value);


}
?>