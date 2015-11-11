<?php

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

class EdashboardViewCategory extends JViewCategory
{
	/**
	 * Execute and display a template script.
	 *
	 * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
	 *
	 * @return  mixed  Exception object if there is any failure, otherwise nothing is returned.
	 */
	public function display($tpl = null)
	{
		$this->app            = JFactory::getApplication('site');
		$this->input          = $this->app->input;
		$this->params         = $this->app->getParams();

		$model                = $this->getModel();

		$categories           = JCategories::getInstance('Edashboard', array());

		$this->category       = $categories->get($this->input->getInt('category_id', 0));

		$this->edashboards    = $this->get('Items');

		$this->pagination     = $this->get('Pagination');

		parent::display($tpl);
	}
}