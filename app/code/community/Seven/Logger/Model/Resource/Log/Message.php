<?php
/*
 * This file is part of the Seven Logger Magento extension
 *
 * (c) Sergey Kolodyazhnyy <sergey.kolodyazhnyy@gmail.com>
 *
 */

class Seven_Logger_Model_Resource_Log_Message extends Mage_Core_Model_Resource_Db_Abstract {

    /**
     * Resource initialization
     */

    public function _construct() {
        $this->_init('seven_logger/log_message', 'message_id');
    }

    /**
     * @param Mage_Core_Model_Abstract $object
     * @return Mage_Core_Model_Resource_Db_Abstract|void
     */

    protected function _beforeSave(Mage_Core_Model_Abstract $object) {
        /** @var $object Seven_Logger_Model_Log_Message */
        $object->setHash($this->getMessageHash($object));
        return parent::_beforeSave($object);
    }

    /**
     * @param Seven_Logger_Model_Log_Message|array $object
     * @return string
     */

    public function getMessageHash($object) {
        if(is_array($object))
            $object = new Varien_Object($object);
        return md5(implode(':::', array($object->getCategory(), $object->getText(), $object->getLevel())));
    }

    public function getEntryTable() {
        return 'seven_logger_entry';
    }

    /**
     * @param Seven_Logger_Model_Log_Message $message
     * @param $time
     * @return \Seven_Logger_Model_Log_Message
     */

    public function addEntry(Seven_Logger_Model_Log_Message $message, $time) {
        if(!($time instanceof DateTime))
            $time = new DateTime($time);

        $entryTable = $this->getEntryTable();

        $this->_getWriteAdapter()->query(
            "INSERT INTO `{$entryTable}` (`message_id`, `time`)
                VALUES(:message_id, :time)
                ON DUPLICATE KEY UPDATE `count` = `count` + 1",
            array(
                'message_id' => $message->getMessageId(),
                'time' => $time->format('Y-m-d H:i:s')
            )
        );

        return $message;
    }

}