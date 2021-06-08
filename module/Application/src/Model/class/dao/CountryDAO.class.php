<?php
/**
 * Intreface DAO
 */
interface CountryDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return Country 
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
 	 * @param country primary key
 	 */
	public function delete($id);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param Country country
 	 */
	public function insert($country);
	
	/**
 	 * Update record in table
 	 *
 	 * @param Country country
 	 */
	public function update($country);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByIso($value);

	public function queryByName($value);

	public function queryByNicename($value);

	public function queryByIso3($value);

	public function queryByNumcode($value);

	public function queryByPhonecode($value);


	public function deleteByIso($value);

	public function deleteByName($value);

	public function deleteByNicename($value);

	public function deleteByIso3($value);

	public function deleteByNumcode($value);

	public function deleteByPhonecode($value);


}
?>