<?php
/**
 * Class that operate on table 'warehouse'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2021-05-14 19:24
 */
class WarehouseMySqlExtDAO extends WarehouseMySqlDAO {

	public function getWarehouseBySupplierId($supplierId){
        $sql = "SELECT
                a.*,
                b.`first_name`,
                b.`last_name`,
                b.`mobile`,
                b.`email`
            FROM
                `warehouse` a
                LEFT OUTER JOIN `user` b
                ON a.`contact_id` = b.`id`
            WHERE a.`company_id` = ? ORDER BY a.`warehouse_id` DESC";
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($supplierId);
		return $this->getList($sqlQuery);
    }
}
?>