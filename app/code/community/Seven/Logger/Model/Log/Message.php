<?php
/*
 * This file is part of the Seven Logger Magento extension
 *
 * (c) Sergey Kolodyazhnyy <sergey.kolodyazhnyy@gmail.com>
 *
 */

/**
 * @method int getMessageId()
 * @method Seven_Logger_Model_Log_Message setMessageId(int $id)
 * @method string getText()
 * @method Seven_Logger_Model_Log_Message setText(string $message)
 * @method string getCategory()
 * @method Seven_Logger_Model_Log_Message setCategory(string $category)
 * @method int getLevel()
 * @method Seven_Logger_Model_Log_Message setLevel(int $level)
 * @method string getHash()
 * @method Seven_Logger_Model_Log_Message setHash(string $hash)
 * @method Seven_Logger_Model_Resource_Log_Message getResource()
 * @method Seven_Logger_Model_Resource_Log_Message_Collection getCollection()
 */

class Seven_Logger_Model_Log_Message extends Mage_Core_Model_Abstract {

    /**
     * Resource initialization
     */

    public function _construct() {
        $this->_init('seven_logger/log_message');
    }

    /**
     * Return all message occurrences as array where keys is
     * time and values - number of occurrences at this time
     *
     * @return Seven_Logger_Model_Resource_Log_Message_Collection
     */

    public function getEntries() {
        return $this->getCollection()
            ->addOccurencesToSelect()
            ->addFieldToFilter('main_table.message_id', $this->getMessageId());
    }

    /**
     * @param $text
     * @param int $level
     * @param string $category
     * @internal param $message
     * @return Seven_Logger_Model_Log_Message
     */

    static public function getMessage($text, $level = 0, $category = '') {
        /** @var $message Seven_Logger_Model_Log_Message */
        $message = new static();
        $data = array(
            'text'      => $text,
            'level'     => $level,
            'category'  => $category
        );
        $hash = $message->getResource()->getMessageHash($data);
        $message->load($hash, 'hash');

        if(!$message->getMessageId())
            $message->setData($data);

        return $message;
    }

    /**
     * Create message entry for specific time
     *
     * @param $time
     */

    public function addEntry($time) {
        if(!$this->getMessageId())
            $this->save();

        $this->getResource()->addEntry($this, $time);
    }

}