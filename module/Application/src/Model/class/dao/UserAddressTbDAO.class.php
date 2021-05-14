<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2021-05-14 19:34
 */
interface UserAddressTbDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return UserAddressTb 
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
 	 * @param userAddressTb primary key
 	 */
	public function delete($id);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param UserAddressTb userAddressTb
 	 */
	public function insert($userAddressTb);
	
	/**
 	 * Update record in table
 	 *
 	 * @param UserAddressTb userAddressTb
 	 */
	public function update($userAddressTb);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByAddress($value);

	public function queryByUserId($value);


	public function deleteByAddress($value);

	public function deleteByUserId($value);


}
?>