<?php
/**
 * Class that operate on table 'banner_image'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2021-05-15 20:57
 */
class BannerImageMySqlExtDAO extends BannerImageMySqlDAO{

    public function select($condition){
		$sql = "SELECT * FROM banner_image WHERE $condition";
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
}
?>