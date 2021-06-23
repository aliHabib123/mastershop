<?php
/**
 * Intreface DAO
 */
interface UserDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return User 
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
 	 * @param user primary key
 	 */
	public function delete($id);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param User user
 	 */
	public function insert($user);
	
	/**
 	 * Update record in table
 	 *
 	 * @param User user
 	 */
	public function update($user);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByFirstName($value);

	public function queryByMiddleName($value);

	public function queryByLastName($value);

	public function queryByFullName($value);

	public function queryByNiceName($value);

	public function queryByEmail($value);

	public function queryByDob($value);

	public function queryByPassword($value);

	public function queryByMobile($value);

	public function queryByTel1($value);

	public function queryByTel2($value);

	public function queryByCompanyName($value);

	public function queryByCompanyCommission($value);

	public function queryByContactPerson($value);

	public function queryByActivationCode($value);

	public function queryByStatus($value);

	public function queryByCountry($value);

	public function queryByCity($value);

	public function queryByState($value);

	public function queryByPostcode($value);

	public function queryByUserType($value);

	public function queryByAddress1($value);

	public function queryByAddress2($value);

	public function queryByAddress3($value);

	public function queryByUploadedFile($value);

	public function queryByUsdExchangeRate($value);

	public function queryByDeleted($value);

	public function queryByCreatedAt($value);

	public function queryByUpdatedAt($value);


	public function deleteByFirstName($value);

	public function deleteByMiddleName($value);

	public function deleteByLastName($value);

	public function deleteByFullName($value);

	public function deleteByNiceName($value);

	public function deleteByEmail($value);

	public function deleteByDob($value);

	public function deleteByPassword($value);

	public function deleteByMobile($value);

	public function deleteByTel1($value);

	public function deleteByTel2($value);

	public function deleteByCompanyName($value);

	public function deleteByCompanyCommission($value);

	public function deleteByContactPerson($value);

	public function deleteByActivationCode($value);

	public function deleteByStatus($value);

	public function deleteByCountry($value);

	public function deleteByCity($value);

	public function deleteByState($value);

	public function deleteByPostcode($value);

	public function deleteByUserType($value);

	public function deleteByAddress1($value);

	public function deleteByAddress2($value);

	public function deleteByAddress3($value);

	public function deleteByUploadedFile($value);

	public function deleteByUsdExchangeRate($value);

	public function deleteByDeleted($value);

	public function deleteByCreatedAt($value);

	public function deleteByUpdatedAt($value);


}
?>