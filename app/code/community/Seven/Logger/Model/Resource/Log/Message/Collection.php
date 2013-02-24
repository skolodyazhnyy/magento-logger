<?php
/*
 * This file is part of the Seven Logger Magento extension
 *
 * (c) Sergey Kolodyazhnyy <sergey.kolodyazhnyy@gmail.com>
 *
 */

class Seven_Logger_Model_Resource_Log_Message_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{

    /**
     * Resource initialization
     */

    public function _construct()
    {
        $this->_init('seven_logger/log_message');
    }

    /**
     * @return Seven_Logger_Model_Resource_Log_Message_Collection
     */

    public function addOccurencesToSelect() {
        $this->getSelect()->joinInner('seven_logger_entry', '`seven_logger_entry`.`message_id` = `main_table`.`message_id`');
        return $this;
    }

    /**
     * @return Seven_Logger_Model_Resource_Log_Message_Collection
     */

    public function groupMessages() {
        $this->getSelect()
            ->columns(array('SUM(`count`) as occures', 'MAX(`time`) as last_occurrence'))
            ->group('main_table.message_id');
        return $this;
    }

    /**
     * @return int
     */

    public function getSize()
    {
        if (is_null($this->_totalRecords)) {
            $sql = $this->getSelectCountSql();
            $records = $this->getConnection()->fetchCol($sql, $this->_bindParams);
            if(count($records) > 1)
                return count($records);
            return reset($records);
        }
        return intval($this->_totalRecords);
    }

    /**
     * @param Varien_Object $item
     * @return mixed
     */

    protected function _getItemId(Varien_Object $item)
    {
        $id = parent::_getItemId($item);
        // Make each entry unique
        if($time = $item->getTime())
            return $id . "@" . $time;
        return $id;
    }

}
