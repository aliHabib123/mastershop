<?php
/**
 * Class that operate on table 'banner'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2021-05-15 20:57
 */
class BannerMySqlExtDAO extends BannerMySqlDAO{

    public function select($condition){
		$sql = "SELECT * FROM banner WHERE $condition";
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
}
?>