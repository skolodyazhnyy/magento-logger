<?php
/*
 * This file is part of the Seven Logger Magento extension
 *
 * (c) Sergey Kolodyazhnyy <sergey.kolodyazhnyy@gmail.com>
 *
 */

class Seven_Logger_Block_Adminhtml_View_Message extends Mage_Adminhtml_Block_Widget_Grid_Container {

    /**
     * Block constructor
     */
    public function __construct()
    {
        $this->_blockGroup = 'seven_logger';
        $this->_controller = 'adminhtml_view_message';
        $this->_headerText = Mage::helper('seven_logger')->__('View message');

        parent::__construct();

        $this->_removeButton('add');
    }

    /**
     * Check permission for passed action
     *
     * @param string $action
     * @return bool
     */
    protected function _isAllowedAction($action)
    {
        //return Mage::getSingleton('admin/session')->isAllowed('cms/page/' . $action);
    }

}