<?php

/**
 * Class that operate on table 'options'. Database Mysql.
 */
class OptionsMySqlExtDAO extends OptionsMySqlDAO
{

    public function updateValue($id, $type, $value)
    {
        if ($type == 1) {
            $sql = "UPDATE `options` set `value` = '$value' where id = ?";
        } else {
            $sql = "UPDATE `options` set `value_text` = '$value' where id = ?";
        }
        $sqlQuery = new SqlQuery($sql);
        $sqlQuery->set($id);
        return $this->executeUpdate($sqlQuery);
    }
}
