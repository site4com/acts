<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

class EdashboardController extends JControllerLegacy
{
	/**
	 * Constructor
	 *
	 * @param   array  $config  An optional associative array of configuration settings.
	 *
	 * @return  void
	 */
	public function __construct($config = array())
	{
		// Get input object
		$this->input = JFactory::getApplication()->input;
	
		parent::__construct($config);
	}
}