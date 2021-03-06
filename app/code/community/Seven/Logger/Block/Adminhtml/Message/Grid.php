<?php
/*
 * This file is part of the Seven Logger Magento extension
 *
 * (c) Sergey Kolodyazhnyy <sergey.kolodyazhnyy@gmail.com>
 *
 */

class Seven_Logger_Block_Adminhtml_Message_Grid extends Mage_Adminhtml_Block_Widget_Grid {

    /**
     *
     */

    public function __construct() {
        parent::__construct();
        $this->setId('sevenLoggerMessageGrid');
        $this->setDefaultSort('last_occurrence');
        $this->setDefaultDir('DESC');
    }

    /**
     * @return $this
     */

    protected function _prepareCollection() {
        /* @var $collection Seven_Logger_Model_Resource_Log_Message_Collection */
        $collection = Mage::getModel('seven_logger/log_message')->getCollection()
            ->addOccurencesToSelect()
            ->groupMessages();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * @return $this
     */

    protected function _prepareColumns() {
        $this->addColumn('occures', array(
            'header'    => Mage::helper('seven_logger')->__('Occurences'),
            'index'     => 'occures',
            'type'      => 'number',
            'filter'    => false
        ));

        $this->addColumn('level', array(
            'header'    => Mage::helper('seven_logger')->__('Level'),
            'index'     => 'level',
            'type'      => 'options',
            'options' => array(
                Zend_Log::ALERT  => Mage::helper('seven_logger')->__('Alert'),
                Zend_Log::CRIT   => Mage::helper('seven_logger')->__('Critical'),
                Zend_Log::DEBUG  => Mage::helper('seven_logger')->__('Debug'),
                Zend_Log::EMERG  => Mage::helper('seven_logger')->__('Emergency'),
                Zend_Log::ERR    => Mage::helper('seven_logger')->__('Error'),
                Zend_Log::INFO   => Mage::helper('seven_logger')->__('Info'),
                Zend_Log::NOTICE => Mage::helper('seven_logger')->__('Notice'),
                Zend_Log::WARN   => Mage::helper('seven_logger')->__('Warning')
            )
        ));

        $this->addColumn('text', array(
            'header'    => Mage::helper('seven_logger')->__('Message'),
            'align'     => 'left',
            'index'     => 'text',
            'renderer'  => 'seven_logger/adminhtml_message_grid_renderer_text'
        ));

        $this->addColumn('category', array(
            'header'    => Mage::helper('seven_logger')->__('Category'),
            'index'     => 'category'
        ));

        $this->addColumn('last_occurrence', array(
            'header'    => Mage::helper('seven_logger')->__('Last occurrence'),
            'index'     => 'last_occurrence',
            'type'      => 'datetime',
            'filter'    => false
        ));

        return parent::_prepareColumns();
    }

    /**
     * Row click url
     *
     * @param $row
     * @return string
     */

    public function getRowUrl($row) {
        /** @var $row Seven_Logger_Model_Log_Message */
        return $this->getUrl('*/*/view', array('id' => $row->getMessageId()));
    }

}
