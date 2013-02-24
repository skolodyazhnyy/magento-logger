<?php
/*
 * This file is part of the Seven Logger Magento extension
 *
 * (c) Sergey Kolodyazhnyy <sergey.kolodyazhnyy@gmail.com>
 *
 */

/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

/**
 * Create table 'seven_logger/log_message'
 */
$table = $installer->getConnection()
    ->newTable($installer->getTable('seven_logger/log_message'))
    ->addColumn('message_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
        'nullable'  => false,
        'primary'   => true,
    ), 'Message ID')
    ->addColumn('text', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
        'nullable'  => false,
    ), 'Message text')
    ->addColumn('category', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable'  => false,
    ), 'Category')
    ->addColumn('level', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
        'nullable'  => false,
    ), 'Level')
    ->addColumn('hash', Varien_Db_Ddl_Table::TYPE_CHAR, 32, array(
        'nullable'  => false,
    ), 'Message hash')
    ->addIndex($installer->getIdxName('seven_logger/log_message', array('hash')),
        array('hash'))
    ->setComment('Log messages');

$installer->getConnection()->createTable($table);

/**
 * Create table 'seven_logger_entry'
 */
$table = $installer->getConnection()
    ->newTable('seven_logger_entry')
    ->addColumn('time', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        'nullable'  => false,
    ), 'Time')
    ->addColumn('message_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
        'nullable'  => false,
    ), 'Message ID')
    ->addColumn('count', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => false,
    ), 'Number of occurrences')
    ->addIndex($installer->getIdxName('seven_logger_entry', array('message_id', 'time')),
        array('message_id', 'time'), array('type' => Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE))
    ->addIndex($installer->getIdxName('seven_logger_entry', array('message_id')),
        array('message_id'))
    ->addForeignKey($installer->getFkName('seven_logger_entry', 'message_id', 'seven_logger/log_message', 'message_id'),
        'message_id', $installer->getTable('seven_logger/log_message'), 'message_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->setComment('Log entries');

$installer->getConnection()->createTable($table);


$installer->endSetup();

