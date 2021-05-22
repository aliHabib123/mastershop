<?php
/**
 * Class that operate on table 'content'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2021-05-14 19:34
 */
class ContentMySqlDAO implements ContentDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return ContentMySql 
	 */
	public function load($id){
		$sql = 'SELECT * FROM content WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($id);
		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll(){
		$sql = 'SELECT * FROM content';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM content ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param content primary key
 	 */
	public function delete($id){
		$sql = 'DELETE FROM content WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($id);
		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param ContentMySql content
 	 */
	public function insert($content){
		$sql = 'INSERT INTO content (parent_id, title, subtitle, details, image, file, album_id, custom_url, slug, display_order, active, type, mime_type, lang, translation_id, can_delete) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($content->parentId);
		$sqlQuery->set($content->title);
		$sqlQuery->set($content->subtitle);
		$sqlQuery->set($content->details);
		$sqlQuery->set($content->image);
		$sqlQuery->set($content->file);
		$sqlQuery->setNumber($content->albumId);
		$sqlQuery->set($content->customUrl);
		$sqlQuery->set($content->slug);
		$sqlQuery->setNumber($content->displayOrder);
		$sqlQuery->setNumber($content->active);
		$sqlQuery->set($content->type);
		$sqlQuery->set($content->mimeType);
		$sqlQuery->setNumber($content->lang);
		$sqlQuery->set($content->translationId);
		$sqlQuery->set($content->canDelete);

		$id = $this->executeInsert($sqlQuery);	
		$content->id = $id;
		return $id;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param ContentMySql content
 	 */
	public function update($content){
		$sql = 'UPDATE content SET parent_id = ?, title = ?, subtitle = ?, details = ?, image = ?, file = ?, album_id = ?, custom_url = ?, slug = ?, display_order = ?, active = ?, type = ?, mime_type = ?, lang = ?, translation_id = ?, can_delete = ? WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($content->parentId);
		$sqlQuery->set($content->title);
		$sqlQuery->set($content->subtitle);
		$sqlQuery->set($content->details);
		$sqlQuery->set($content->image);
		$sqlQuery->set($content->file);
		$sqlQuery->setNumber($content->albumId);
		$sqlQuery->set($content->customUrl);
		$sqlQuery->set($content->slug);
		$sqlQuery->setNumber($content->displayOrder);
		$sqlQuery->setNumber($content->active);
		$sqlQuery->set($content->type);
		$sqlQuery->set($content->mimeType);
		$sqlQuery->setNumber($content->lang);
		$sqlQuery->set($content->translationId);
		$sqlQuery->set($content->canDelete);

		$sqlQuery->set($content->id);
		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM content';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}

	public function queryByParentId($value){
		$sql = 'SELECT * FROM content WHERE parent_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByTitle($value){
		$sql = 'SELECT * FROM content WHERE title = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryBySubtitle($value){
		$sql = 'SELECT * FROM content WHERE subtitle = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByDetails($value){
		$sql = 'SELECT * FROM content WHERE details = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByImage($value){
		$sql = 'SELECT * FROM content WHERE image = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByFile($value){
		$sql = 'SELECT * FROM content WHERE file = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByAlbumId($value){
		$sql = 'SELECT * FROM content WHERE album_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByCustomUrl($value){
		$sql = 'SELECT * FROM content WHERE custom_url = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryBySlug($value){
		$sql = 'SELECT * FROM content WHERE slug = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByDisplayOrder($value){
		$sql = 'SELECT * FROM content WHERE display_order = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByActive($value){
		$sql = 'SELECT * FROM content WHERE active = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByType($value){
		$sql = 'SELECT * FROM content WHERE type = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByMimeType($value){
		$sql = 'SELECT * FROM content WHERE mime_type = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByLang($value){
		$sql = 'SELECT * FROM content WHERE lang = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByTranslationId($value){
		$sql = 'SELECT * FROM content WHERE translation_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByCanDelete($value){
		$sql = 'SELECT * FROM content WHERE can_delete = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}


	public function deleteByParentId($value){
		$sql = 'DELETE FROM content WHERE parent_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByTitle($value){
		$sql = 'DELETE FROM content WHERE title = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteBySubtitle($value){
		$sql = 'DELETE FROM content WHERE subtitle = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByDetails($value){
		$sql = 'DELETE FROM content WHERE details = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByImage($value){
		$sql = 'DELETE FROM content WHERE image = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByFile($value){
		$sql = 'DELETE FROM content WHERE file = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByAlbumId($value){
		$sql = 'DELETE FROM content WHERE album_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByCustomUrl($value){
		$sql = 'DELETE FROM content WHERE custom_url = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteBySlug($value){
		$sql = 'DELETE FROM content WHERE slug = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByDisplayOrder($value){
		$sql = 'DELETE FROM content WHERE display_order = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByActive($value){
		$sql = 'DELETE FROM content WHERE active = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByType($value){
		$sql = 'DELETE FROM content WHERE type = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByMimeType($value){
		$sql = 'DELETE FROM content WHERE mime_type = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByLang($value){
		$sql = 'DELETE FROM content WHERE lang = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByTranslationId($value){
		$sql = 'DELETE FROM content WHERE translation_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByCanDelete($value){
		$sql = 'DELETE FROM content WHERE can_delete = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}


	
	/**
	 * Read row
	 *
	 * @return ContentMySql 
	 */
	protected function readRow($row){
		$content = new Content();
		
		$content->id = $row['id'];
		$content->parentId = $row['parent_id'];
		$content->title = $row['title'];
		$content->subtitle = $row['subtitle'];
		$content->details = $row['details'];
		$content->image = $row['image'];
		$content->file = $row['file'];
		$content->albumId = $row['album_id'];
		$content->customUrl = $row['custom_url'];
		$content->slug = $row['slug'];
		$content->displayOrder = $row['display_order'];
		$content->active = $row['active'];
		$content->type = $row['type'];
		$content->mimeType = $row['mime_type'];
		$content->lang = $row['lang'];
		$content->translationId = $row['translation_id'];
		$content->canDelete = $row['can_delete'];

		return $content;
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
	 * @return ContentMySql 
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