<?php
/**
 * Class that operate on table 'content'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2021-04-23 23:35
 */
class ContentMySqlExtDAO extends ContentMySqlDAO{

    public function select($condition){
		$sql = "SELECT * FROM content WHERE $condition";
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}

	public function updateTranslation($id, $translationId){
		$sql = 'UPDATE content SET translation_id = ? WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
	
		$sqlQuery->set($translationId);

		$sqlQuery->set($id);
		return $this->executeUpdate($sqlQuery);
	}
}
?>