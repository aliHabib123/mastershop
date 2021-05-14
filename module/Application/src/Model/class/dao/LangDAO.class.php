<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2021-05-14 19:34
 */
interface LangDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return Lang 
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
 	 * @param lang primary key
 	 */
	public function delete($id);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param Lang lang
 	 */
	public function insert($lang);
	
	/**
 	 * Update record in table
 	 *
 	 * @param Lang lang
 	 */
	public function update($lang);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByName($value);

	public function queryByDisplayOrder($value);

	public function queryByIsDefault($value);


	public function deleteByName($value);

	public function deleteByDisplayOrder($value);

	public function deleteByIsDefault($value);


}
?>