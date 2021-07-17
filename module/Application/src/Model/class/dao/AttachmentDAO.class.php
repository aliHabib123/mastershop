<?php
/**
 * Intreface DAO
 */
interface AttachmentDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return Attachment 
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
 	 * @param attachment primary key
 	 */
	public function delete($id);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param Attachment attachment
 	 */
	public function insert($attachment);
	
	/**
 	 * Update record in table
 	 *
 	 * @param Attachment attachment
 	 */
	public function update($attachment);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByUrl($value);

	public function queryByImageName($value);


	public function deleteByUrl($value);

	public function deleteByImageName($value);


}
?>