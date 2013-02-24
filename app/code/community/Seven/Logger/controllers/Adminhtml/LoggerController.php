<?php
/*
 * This file is part of the Seven Logger Magento extension
 *
 * (c) Sergey Kolodyazhnyy <sergey.kolodyazhnyy@gmail.com>
 *
 */

class Seven_Logger_Adminhtml_LoggerController extends Mage_Adminhtml_Controller_Action {

    /**
     *
     */

    public function indexAction() {
        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     *
     */

    public function messagesAction() {
        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     *
     */

    public function viewAction() {
        /** @var $message Seven_Logger_Model_Log_Message */
        $message = Mage::getModel('seven_logger/log_message')->load((int) $this->getRequest()->getParam('id'));

        if(!$message->getMessageId()) {
            $this->_forward('noroute');
            return;
        }

        Mage::register('seven_logger.message', $message);
        $this->loadLayout();
        $this->renderLayout();
    }

}