<?php
/*
 * This file is part of the Seven Logger Magento extension
 *
 * (c) Sergey Kolodyazhnyy <sergey.kolodyazhnyy@gmail.com>
 *
 */

class Seven_Logger_Helper_Data extends Mage_Core_Helper_Abstract {

    /**
     * @param string $time
     * @param string $message
     * @param int $level
     * @param string $category
     * @return mixed
     */

    public function log($message, $level = 0, $category = 'system.log', $time = null) {
        if($time === null)
            $time = new DateTime();

        return Mage::getSingleton('seven_logger/log_message')->getMessage($message, $level, $category)
            ->addEntry($time);
    }

}