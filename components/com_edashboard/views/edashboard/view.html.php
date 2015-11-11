<?php

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

class EdashboardViewEdashboard extends JViewLegacy
{
	protected $state;
	protected $item;

	function display($tpl = null)
	{
		
		$app               = JFactory::getApplication();
		$params            = $app->getParams();
		$this->input        = $app->input;
		$model             = $this->getModel();
		
		$this->edashboards = $this->getModel()->getEdashboard();
		$this->attachments = $this->getModel()->getListAttachment();
		
		$this->pagination  = $this->get('Pagination');

		parent::display($tpl);
	}
}