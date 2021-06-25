<?php
/**
 * Intreface DAO
 */
interface OptionsDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return Options 
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
 	 * @param option primary key
 	 */
	public function delete($id);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param Options option
 	 */
	public function insert($option);
	
	/**
 	 * Update record in table
 	 *
 	 * @param Options option
 	 */
	public function update($option);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByAdminName($value);

	public function queryByName($value);

	public function queryByOptionGroup($value);

	public function queryByType($value);

	public function queryByValue($value);

	public function queryByValueText($value);

	public function queryByEditable($value);


	public function deleteByAdminName($value);

	public function deleteByName($value);

	public function deleteByOptionGroup($value);

	public function deleteByType($value);

	public function deleteByValue($value);

	public function deleteByValueText($value);

	public function deleteByEditable($value);


}
?>