<?php
/*
 * This file is part of the Seven Logger Magento extension
 *
 * (c) Sergey Kolodyazhnyy <sergey.kolodyazhnyy@gmail.com>
 *
 */

class Seven_Logger_Block_Adminhtml_View_Message_Grid extends Mage_Adminhtml_Block_Widget_Grid {

    /**
     *
     */

    public function __construct() {
        parent::__construct();
        $this->setId('sevenLoggerMessageGrid');
        $this->setDefaultSort('occures');
        $this->setDefaultDir('DESC');
    }

    /**
     * @return $this
     */

    protected function _prepareCollection() {
        /* @var $message Seven_Logger_Model_Log_Message */
        if(!($message = Mage::registry('seven_logger.message')))
            throw new Exception('Message are not registered');

        $collection = $message->getEntries();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * @return $this
     */

    protected function _prepareColumns() {
        $this->addColumn('time', array(
            'header'    => Mage::helper('seven_logger')->__('Time'),
            'index'     => 'time',
            'type'      => 'datetime'
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
        return false;
    }

}
