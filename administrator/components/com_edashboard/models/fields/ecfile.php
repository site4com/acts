<?php
/**
 * @package     Joomla.Platform
 * @subpackage  Form
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('JPATH_PLATFORM') or die;

/**
 * Form Field class for the Joomla Platform.
 * Provides an input field for files
 *
 * @link   http://www.w3.org/TR/html-markup/input.file.html#input.file
 * @since  11.1
 */
include_once (JPATH_ROOT . '/libraries/joomla/form/fields/file.php');
class JFormFieldEcFile extends JFormFieldFile
{
    protected function getInput()
    {

        // Initialize some field attributes.
        $accept    = !empty($this->accept) ? ' accept="' . $this->accept . '"' : '';
        $size      = !empty($this->size) ? ' size="' . $this->size . '"' : '';
        $class     = !empty($this->class) ? ' class="' . $this->class . '"' : '';
        $disabled  = $this->disabled ? ' disabled' : '';
        $required  = $this->required ? ' required aria-required="true"' : '';
        $autofocus = $this->autofocus ? ' autofocus' : '';
        $multiple  = $this->multiple ? ' multiple' : '';

        // Initialize JavaScript field attributes.
        $onchange = $this->onchange ? ' onchange="' . $this->onchange . '"' : '';

        // Including fallback code for HTML5 non supported browsers.
        JHtml::_('jquery.framework');
        JHtml::_('script', 'system/html5fallback.js', false, true);
        if ( $this->value ) {
            $html[] = '';
            foreach ($this->value as $_file) {
                $html[]= '<div style="padding:10px 0px">'.htmlspecialchars($_file['name'], ENT_COMPAT, 'UTF-8');
                $html[]= '<input style="margin-left:130px" type="input" value="'.$_file['ordering'].'" name="file_position['.$_file['id'].'][]"  />';
                $html[]= '<input style="margin-left:130px" type="checkbox" value="'.$_file['id'].'" name="file_delete[]"  />delete</div>';
            }

            return implode($html);
        } else {
            return '<input type="file" name="' . $this->name . '[]" id="' . $this->id . '"' . $accept . $disabled . $class . $size . $onchange . $required . $autofocus . $multiple . ' />';    
        }
        
    }
}