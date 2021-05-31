<?php
/**
 * Class that operate on table 'item'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2021-04-23 23:35
 */
class ItemMySqlExtDAO extends ItemMySqlDAO{

	public function select($condition = '1', $limit = 0, $offset = 0){
        $sql = "SELECT * FROM item WHERE $condition";

        if($limit != 0){
            $sql .= " LIMIT $limit OFFSET $offset";
        }
        
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
    }
}
?>