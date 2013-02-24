<?php
/*
 * This file is part of the Seven Logger Magento extension
 *
 * (c) Sergey Kolodyazhnyy <sergey.kolodyazhnyy@gmail.com>
 *
 */

class Seven_Logger_Block_Adminhtml_Message_Details extends Mage_Adminhtml_Block_Template {

    /**
     *
     */

    protected function _construct() {
        $this->setTemplate('seven_logger/message/details.phtml');
        return parent::_construct();
    }

    /**
     * @return string
     */

    protected function _toHtml() {
        if(!$this->getMessage())
            return '';
        return parent::_toHtml();
    }

    /**
     * @return Seven_Logger_Model_Log_Message
     */

    protected function getMessage() {
        return Mage::registry('seven_logger.message');
    }

}