<?php
/**
 * Class that operate on table 'banner_image'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2021-05-15 20:57
 */
class BannerImageMySqlDAO implements BannerImageDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return BannerImageMySql 
	 */
	public function load($id){
		$sql = 'SELECT * FROM banner_image WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($id);
		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll(){
		$sql = 'SELECT * FROM banner_image';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM banner_image ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param bannerImage primary key
 	 */
	public function delete($id){
		$sql = 'DELETE FROM banner_image WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($id);
		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param BannerImageMySql bannerImage
 	 */
	public function insert($bannerImage){
		$sql = 'INSERT INTO banner_image (caption1, caption2, button_text, button_link, button_link_target, image_name, banner_id) VALUES (?, ?, ?, ?, ?, ?, ?)';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($bannerImage->caption1);
		$sqlQuery->set($bannerImage->caption2);
		$sqlQuery->set($bannerImage->buttonText);
		$sqlQuery->set($bannerImage->buttonLink);
		$sqlQuery->set($bannerImage->buttonLinkTarget);
		$sqlQuery->set($bannerImage->imageName);
		$sqlQuery->setNumber($bannerImage->bannerId);

		$id = $this->executeInsert($sqlQuery);	
		$bannerImage->id = $id;
		return $id;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param BannerImageMySql bannerImage
 	 */
	public function update($bannerImage){
		$sql = 'UPDATE banner_image SET caption1 = ?, caption2 = ?, button_text = ?, button_link = ?, button_link_target = ?, image_name = ?, banner_id = ? WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($bannerImage->caption1);
		$sqlQuery->set($bannerImage->caption2);
		$sqlQuery->set($bannerImage->buttonText);
		$sqlQuery->set($bannerImage->buttonLink);
		$sqlQuery->set($bannerImage->buttonLinkTarget);
		$sqlQuery->set($bannerImage->imageName);
		$sqlQuery->setNumber($bannerImage->bannerId);

		$sqlQuery->set($bannerImage->id);
		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM banner_image';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}

	public function queryByCaption1($value){
		$sql = 'SELECT * FROM banner_image WHERE caption1 = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByCaption2($value){
		$sql = 'SELECT * FROM banner_image WHERE caption2 = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByButtonText($value){
		$sql = 'SELECT * FROM banner_image WHERE button_text = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByButtonLink($value){
		$sql = 'SELECT * FROM banner_image WHERE button_link = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByButtonLinkTarget($value){
		$sql = 'SELECT * FROM banner_image WHERE button_link_target = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByImageName($value){
		$sql = 'SELECT * FROM banner_image WHERE image_name = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByBannerId($value){
		$sql = 'SELECT * FROM banner_image WHERE banner_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}


	public function deleteByCaption1($value){
		$sql = 'DELETE FROM banner_image WHERE caption1 = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByCaption2($value){
		$sql = 'DELETE FROM banner_image WHERE caption2 = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByButtonText($value){
		$sql = 'DELETE FROM banner_image WHERE button_text = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByButtonLink($value){
		$sql = 'DELETE FROM banner_image WHERE button_link = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByButtonLinkTarget($value){
		$sql = 'DELETE FROM banner_image WHERE button_link_target = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByImageName($value){
		$sql = 'DELETE FROM banner_image WHERE image_name = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByBannerId($value){
		$sql = 'DELETE FROM banner_image WHERE banner_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}


	
	/**
	 * Read row
	 *
	 * @return BannerImageMySql 
	 */
	protected function readRow($row){
		$bannerImage = new BannerImage();
		
		$bannerImage->id = $row['id'];
		$bannerImage->caption1 = $row['caption1'];
		$bannerImage->caption2 = $row['caption2'];
		$bannerImage->buttonText = $row['button_text'];
		$bannerImage->buttonLink = $row['button_link'];
		$bannerImage->buttonLinkTarget = $row['button_link_target'];
		$bannerImage->imageName = $row['image_name'];
		$bannerImage->bannerId = $row['banner_id'];

		return $bannerImage;
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
	 * @return BannerImageMySql 
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