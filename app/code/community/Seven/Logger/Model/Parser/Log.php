<?php
/*
 * This file is part of the Seven Logger Magento extension
 *
 * (c) Sergey Kolodyazhnyy <sergey.kolodyazhnyy@gmail.com>
 *
 */


class Seven_Logger_Model_Parser_Log implements  Seven_Logger_Model_Parser_Interface {

    const ENTRY_REGEXP = "/^([2-9][0-9]{3}-[0-2][0-9]-[0-3][0-9]T[0-2][0-9]:[0-5][0-9]:[0-5][0-9][+-][0-2][0-9]:[0-5][0-9]) (ERR|DEBUG|CRIT|EMERG|WARN|ALERT|INFO|NOTICE) \(([0-9]+)\): /";

    /**
     * @param string $source log filename
     * @throws Seven_Logger_Exception_FileRead
     */

    public function parse($source) {
        if(!($sourceHandle = fopen($source, "r")))
            throw new Seven_Logger_Exception_FileRead("Unable to read log file {$source}");
        $category = basename($source);
        $entryBuffer = "";
        while(!feof($sourceHandle)) {
            $line = fgets($sourceHandle);
            if(preg_match(self::ENTRY_REGEXP, $line)) {
                $this->parseEntry($entryBuffer, $category);
                $entryBuffer = $line;
            } else {
                $entryBuffer .= $line;
            }
        }
        $this->parseEntry($entryBuffer, $category);
        fclose($sourceHandle);
    }

    /**
     * @param $entry
     * @param $category
     */

    protected function parseEntry($entry, $category) {
        if(!strlen($entry = trim($entry)))
            return;

        if(preg_match(self::ENTRY_REGEXP, $entry, $match)) {
            $timestamp  = $match[1];
            $level      = $match[3];
            $message    = substr($entry, strlen($match[0]));
            Mage::helper('seven_logger')->log($message, $level, $category, $timestamp);
        }
    }

}