<?php
/*
 * This file is part of the Seven Logger Magento extension
 *
 * (c) Sergey Kolodyazhnyy <sergey.kolodyazhnyy@gmail.com>
 *
 */

class Seven_Logger_Block_Adminhtml_Message_Grid_Renderer_Text extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract {

    /**
     * Renders grid column
     *
     * @param   Varien_Object $row
     * @return  string
     */
    public function render(Varien_Object $row)
    {
        return htmlspecialchars($this->_firstLine(parent::render($row)));
    }

    /**
     * @param $text
     * @return string
     */

    protected function _firstLine($text) {
        $text = ltrim($text);
        if(($position = strpos($text, "\n")) !== false)
            return substr($text, 0, $position);
        return $text;
    }

}