<?php
/*
 * This file is part of the Seven Logger Magento extension
 *
 * (c) Sergey Kolodyazhnyy <sergey.kolodyazhnyy@gmail.com>
 *
 */

class Seven_Logger_Helper_Data extends Mage_Core_Helper_Abstract {

    private $_queue;

    /**
     * @param $message
     * @param $level
     * @param $category
     * @param $time
     */

    protected function _enqueue($message, $level, $category, $time) {
        $this->_queue[] = array(
            'message'  => $message,
            'level'    => $level,
            'category' => $category,
            'time'     => $time
        );
    }

    /**
     * Flush postponed message queue
     */

    public function flush() {
        $queue = $this->_queue;
        $this->_queue = array();

        foreach($queue as $entry)
            $this->log($entry['message'], $entry['level'], $entry['category'], $entry['time']);
    }

    /**
     * @param string $time
     * @param string $message
     * @param int $level
     * @param string $category
     */

    public function log($message, $level = Zend_Log::NOTICE, $category = null, $time = null) {
        if($time === null)
            $time = new DateTime();

        if($category === null)
            $category = 'system.log';

        $this->flush();

        try {
            Seven_Logger_Model_Log_Message::getMessage($message, $level, $category)
                ->addEntry($time);
        } catch(Exception $exception) {
            $this->_enqueue($message, $level, $category, $time);
        }
    }

    /**
     * @param $message
     * @param string $category
     * @param null $time
     */

    public function crit($message, $category = null, $time = null) {
        $this->log($message, Zend_Log::CRIT, $category, $time);
    }

    /**
     * @param $message
     * @param string $category
     * @param null $time
     */

    public function notice($message, $category = null, $time = null) {
        $this->log($message, Zend_Log::NOTICE, $category, $time);
    }

    /**
     * @param $message
     * @param string $category
     * @param null $time
     */

    public function alert($message, $category = null, $time = null) {
        $this->log($message, Zend_Log::ALERT, $category, $time);
    }

    /**
     * @param $message
     * @param string $category
     * @param null $time
     */

    public function debug($message, $category = null, $time = null) {
        $this->log($message, Zend_Log::DEBUG, $category, $time);
    }

    /**
     * @param $message
     * @param string $category
     * @param null $time
     */

    public function emerg($message, $category = null, $time = null) {
        $this->log($message, Zend_Log::EMERG, $category, $time);
    }

    /**
     * @param $message
     * @param string $category
     * @param null $time
     */

    public function error($message, $category = null, $time = null) {
        $this->log($message, Zend_Log::ERR, $category, $time);
    }

    /**
     * @param $message
     * @param string $category
     * @param null $time
     */

    public function info($message, $category = null, $time = null) {
        $this->log($message, Zend_Log::INFO, $category, $time);
    }

    /**
     * @param $message
     * @param string $category
     * @param null $time
     */

    public function warn($message, $category = null, $time = null) {
        $this->log($message, Zend_Log::WARN, $category, $time);
    }

}