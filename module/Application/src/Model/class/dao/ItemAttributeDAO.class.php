<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2021-05-14 19:34
 */
interface ItemAttributeDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return ItemAttribute 
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
 	 * @param itemAttribute primary key
 	 */
	public function delete($id);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param ItemAttribute itemAttribute
 	 */
	public function insert($itemAttribute);
	
	/**
 	 * Update record in table
 	 *
 	 * @param ItemAttribute itemAttribute
 	 */
	public function update($itemAttribute);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByAttributeName($value);

	public function queryByDisplayOrder($value);

	public function queryByLangId($value);

	public function queryByTranslationId($value);


	public function deleteByAttributeName($value);

	public function deleteByDisplayOrder($value);

	public function deleteByLangId($value);

	public function deleteByTranslationId($value);


}
?>