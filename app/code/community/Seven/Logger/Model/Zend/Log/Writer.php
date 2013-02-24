<?php
/*
 * This file is part of the Seven Logger Magento extension
 *
 * (c) Sergey Kolodyazhnyy <sergey.kolodyazhnyy@gmail.com>
 *
 */

class Seven_Logger_Model_Zend_Log_Writer extends Zend_Log_Writer_Abstract {

    /**
     * @param $category
     */

    public function __construct($category) {
       $this->_category = basename($category);
    }

    /**
     * @param array $event
     */

    protected function _write($event) {
        Mage::helper('seven_logger')->log($event['message'], $event['priority'], $this->_category, $event['timestamp']);
    }

    /**
     * Create a new instance of Seven_Logger_Model_Zend_Log_Writer
     *
     * @param  array|Zend_Config $config
     * @return Seven_Logger_Model_Zend_Log_Writer
     * @throws Zend_Log_Exception
     */

    static public function factory($config)
    {
        return new self(self::_parseConfig($config));
    }
}