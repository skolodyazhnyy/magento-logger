<?php
/*
 * This file is part of the Seven Logger Magento extension
 *
 * (c) Sergey Kolodyazhnyy <sergey.kolodyazhnyy@gmail.com>
 *
 */

class Seven_Logger_Model_Observer {

    public function collectLog() {
        /** @var $parser Seven_Logger_Model_Parser_Interface */
        $parser = Mage::getModel('seven_logger/parser_log');

        $logs = glob(Mage::getBaseDir('var') . DS . "log/*.log");
        foreach($logs as $logfile) {
            try {
                $parser->parse($logfile);
            } catch(Exception $e) {
                // todo: fixme
            }
        }
    }

}