<?php
/**
 * Class that operate on table 'user'. Database Mysql.
 */
class UserMySqlDAO implements UserDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return UserMySql 
	 */
	public function load($id){
		$sql = 'SELECT * FROM user WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($id);
		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll(){
		$sql = 'SELECT * FROM user';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM user ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param user primary key
 	 */
	public function delete($id){
		$sql = 'DELETE FROM user WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($id);
		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param UserMySql user
 	 */
	public function insert($user){
		$sql = 'INSERT INTO user (first_name, middle_name, last_name, full_name, nice_name, email, dob, password, mobile, tel_1, tel_2, company_name, company_commission, contact_person, activation_code, status, country, city, state, postcode, user_type, address_1, address_2, address_3, uploaded_file, usd_exchange_rate, deleted, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($user->firstName);
		$sqlQuery->set($user->middleName);
		$sqlQuery->set($user->lastName);
		$sqlQuery->set($user->fullName);
		$sqlQuery->set($user->niceName);
		$sqlQuery->set($user->email);
		$sqlQuery->set($user->dob);
		$sqlQuery->set($user->password);
		$sqlQuery->set($user->mobile);
		$sqlQuery->set($user->tel1);
		$sqlQuery->set($user->tel2);
		$sqlQuery->set($user->companyName);
		$sqlQuery->set($user->companyCommission);
		$sqlQuery->set($user->contactPerson);
		$sqlQuery->set($user->activationCode);
		$sqlQuery->set($user->status);
		$sqlQuery->set($user->country);
		$sqlQuery->set($user->city);
		$sqlQuery->set($user->state);
		$sqlQuery->set($user->postcode);
		$sqlQuery->set($user->userType);
		$sqlQuery->set($user->address1);
		$sqlQuery->set($user->address2);
		$sqlQuery->set($user->address3);
		$sqlQuery->set($user->uploadedFile);
		$sqlQuery->set($user->usdExchangeRate);
		$sqlQuery->setNumber($user->deleted);
		$sqlQuery->set($user->createdAt);
		$sqlQuery->set($user->updatedAt);

		$id = $this->executeInsert($sqlQuery);	
		$user->id = $id;
		return $id;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param UserMySql user
 	 */
	public function update($user){
		$sql = 'UPDATE user SET first_name = ?, middle_name = ?, last_name = ?, full_name = ?, nice_name = ?, email = ?, dob = ?, password = ?, mobile = ?, tel_1 = ?, tel_2 = ?, company_name = ?, company_commission = ?, contact_person = ?, activation_code = ?, status = ?, country = ?, city = ?, state = ?, postcode = ?, user_type = ?, address_1 = ?, address_2 = ?, address_3 = ?, uploaded_file = ?, usd_exchange_rate = ?, deleted = ?, created_at = ?, updated_at = ? WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($user->firstName);
		$sqlQuery->set($user->middleName);
		$sqlQuery->set($user->lastName);
		$sqlQuery->set($user->fullName);
		$sqlQuery->set($user->niceName);
		$sqlQuery->set($user->email);
		$sqlQuery->set($user->dob);
		$sqlQuery->set($user->password);
		$sqlQuery->set($user->mobile);
		$sqlQuery->set($user->tel1);
		$sqlQuery->set($user->tel2);
		$sqlQuery->set($user->companyName);
		$sqlQuery->set($user->companyCommission);
		$sqlQuery->set($user->contactPerson);
		$sqlQuery->set($user->activationCode);
		$sqlQuery->set($user->status);
		$sqlQuery->set($user->country);
		$sqlQuery->set($user->city);
		$sqlQuery->set($user->state);
		$sqlQuery->set($user->postcode);
		$sqlQuery->set($user->userType);
		$sqlQuery->set($user->address1);
		$sqlQuery->set($user->address2);
		$sqlQuery->set($user->address3);
		$sqlQuery->set($user->uploadedFile);
		$sqlQuery->set($user->usdExchangeRate);
		$sqlQuery->setNumber($user->deleted);
		$sqlQuery->set($user->createdAt);
		$sqlQuery->set($user->updatedAt);

		$sqlQuery->set($user->id);
		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM user';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}

	public function queryByFirstName($value){
		$sql = 'SELECT * FROM user WHERE first_name = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByMiddleName($value){
		$sql = 'SELECT * FROM user WHERE middle_name = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByLastName($value){
		$sql = 'SELECT * FROM user WHERE last_name = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByFullName($value){
		$sql = 'SELECT * FROM user WHERE full_name = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByNiceName($value){
		$sql = 'SELECT * FROM user WHERE nice_name = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByEmail($value){
		$sql = 'SELECT * FROM user WHERE email = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByDob($value){
		$sql = 'SELECT * FROM user WHERE dob = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByPassword($value){
		$sql = 'SELECT * FROM user WHERE password = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByMobile($value){
		$sql = 'SELECT * FROM user WHERE mobile = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByTel1($value){
		$sql = 'SELECT * FROM user WHERE tel_1 = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByTel2($value){
		$sql = 'SELECT * FROM user WHERE tel_2 = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByCompanyName($value){
		$sql = 'SELECT * FROM user WHERE company_name = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByCompanyCommission($value){
		$sql = 'SELECT * FROM user WHERE company_commission = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByContactPerson($value){
		$sql = 'SELECT * FROM user WHERE contact_person = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByActivationCode($value){
		$sql = 'SELECT * FROM user WHERE activation_code = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByStatus($value){
		$sql = 'SELECT * FROM user WHERE status = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByCountry($value){
		$sql = 'SELECT * FROM user WHERE country = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByCity($value){
		$sql = 'SELECT * FROM user WHERE city = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByState($value){
		$sql = 'SELECT * FROM user WHERE state = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByPostcode($value){
		$sql = 'SELECT * FROM user WHERE postcode = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByUserType($value){
		$sql = 'SELECT * FROM user WHERE user_type = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByAddress1($value){
		$sql = 'SELECT * FROM user WHERE address_1 = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByAddress2($value){
		$sql = 'SELECT * FROM user WHERE address_2 = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByAddress3($value){
		$sql = 'SELECT * FROM user WHERE address_3 = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByUploadedFile($value){
		$sql = 'SELECT * FROM user WHERE uploaded_file = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByUsdExchangeRate($value){
		$sql = 'SELECT * FROM user WHERE usd_exchange_rate = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByDeleted($value){
		$sql = 'SELECT * FROM user WHERE deleted = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByCreatedAt($value){
		$sql = 'SELECT * FROM user WHERE created_at = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByUpdatedAt($value){
		$sql = 'SELECT * FROM user WHERE updated_at = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}


	public function deleteByFirstName($value){
		$sql = 'DELETE FROM user WHERE first_name = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByMiddleName($value){
		$sql = 'DELETE FROM user WHERE middle_name = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByLastName($value){
		$sql = 'DELETE FROM user WHERE last_name = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByFullName($value){
		$sql = 'DELETE FROM user WHERE full_name = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByNiceName($value){
		$sql = 'DELETE FROM user WHERE nice_name = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByEmail($value){
		$sql = 'DELETE FROM user WHERE email = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByDob($value){
		$sql = 'DELETE FROM user WHERE dob = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByPassword($value){
		$sql = 'DELETE FROM user WHERE password = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByMobile($value){
		$sql = 'DELETE FROM user WHERE mobile = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByTel1($value){
		$sql = 'DELETE FROM user WHERE tel_1 = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByTel2($value){
		$sql = 'DELETE FROM user WHERE tel_2 = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByCompanyName($value){
		$sql = 'DELETE FROM user WHERE company_name = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByCompanyCommission($value){
		$sql = 'DELETE FROM user WHERE company_commission = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByContactPerson($value){
		$sql = 'DELETE FROM user WHERE contact_person = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByActivationCode($value){
		$sql = 'DELETE FROM user WHERE activation_code = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByStatus($value){
		$sql = 'DELETE FROM user WHERE status = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByCountry($value){
		$sql = 'DELETE FROM user WHERE country = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByCity($value){
		$sql = 'DELETE FROM user WHERE city = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByState($value){
		$sql = 'DELETE FROM user WHERE state = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByPostcode($value){
		$sql = 'DELETE FROM user WHERE postcode = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByUserType($value){
		$sql = 'DELETE FROM user WHERE user_type = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByAddress1($value){
		$sql = 'DELETE FROM user WHERE address_1 = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByAddress2($value){
		$sql = 'DELETE FROM user WHERE address_2 = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByAddress3($value){
		$sql = 'DELETE FROM user WHERE address_3 = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByUploadedFile($value){
		$sql = 'DELETE FROM user WHERE uploaded_file = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByUsdExchangeRate($value){
		$sql = 'DELETE FROM user WHERE usd_exchange_rate = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByDeleted($value){
		$sql = 'DELETE FROM user WHERE deleted = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByCreatedAt($value){
		$sql = 'DELETE FROM user WHERE created_at = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByUpdatedAt($value){
		$sql = 'DELETE FROM user WHERE updated_at = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}


	
	/**
	 * Read row
	 *
	 * @return UserMySql 
	 */
	protected function readRow($row){
		$user = new User();
		
		$user->id = $row['id'];
		$user->firstName = $row['first_name'];
		$user->middleName = $row['middle_name'];
		$user->lastName = $row['last_name'];
		$user->fullName = $row['full_name'];
		$user->niceName = $row['nice_name'];
		$user->email = $row['email'];
		$user->dob = $row['dob'];
		$user->password = $row['password'];
		$user->mobile = $row['mobile'];
		$user->tel1 = $row['tel_1'];
		$user->tel2 = $row['tel_2'];
		$user->companyName = $row['company_name'];
		$user->companyCommission = $row['company_commission'];
		$user->contactPerson = $row['contact_person'];
		$user->activationCode = $row['activation_code'];
		$user->status = $row['status'];
		$user->country = $row['country'];
		$user->city = $row['city'];
		$user->state = $row['state'];
		$user->postcode = $row['postcode'];
		$user->userType = $row['user_type'];
		$user->address1 = $row['address_1'];
		$user->address2 = $row['address_2'];
		$user->address3 = $row['address_3'];
		$user->uploadedFile = $row['uploaded_file'];
		$user->usdExchangeRate = $row['usd_exchange_rate'];
		$user->deleted = $row['deleted'];
		$user->createdAt = $row['created_at'];
		$user->updatedAt = $row['updated_at'];

		return $user;
	}
	
	protected function getList($sqlQuery){
		$tab = QueryExecutor::execute($sqlQuery);
		$ret = array();
		for($i=0;$i<count($tab);$i++){
			$ret[$i] = $this->readRow($tab[$i]);
		}
		return $ret;
	}
	
	/**
	 * Get row
	 *
	 * @return UserMySql 
	 */
	protected function getRow($sqlQuery){
		$tab = QueryExecutor::execute($sqlQuery);
		if(count($tab)==0){
			return null;
		}
		return $this->readRow($tab[0]);		
	}
	
	/**
	 * Execute sql query
	 */
	protected function execute($sqlQuery){
		return QueryExecutor::execute($sqlQuery);
	}
	
		
	/**
	 * Execute sql query
	 */
	protected function executeUpdate($sqlQuery){
		return QueryExecutor::executeUpdate($sqlQuery);
	}

	/**
	 * Query for one row and one column
	 */
	protected function querySingleResult($sqlQuery){
		return QueryExecutor::queryForString($sqlQuery);
	}

	/**
	 * Insert row to table
	 */
	protected function executeInsert($sqlQuery){
		return QueryExecutor::executeInsert($sqlQuery);
	}
}
?>