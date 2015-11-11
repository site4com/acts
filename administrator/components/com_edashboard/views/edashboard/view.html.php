<?php

defined('_JEXEC') or die;

/**
 * View class for a list of edashboard.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_edashboard
 * @since       1.6
 */
class EdashboardViewEdashboard extends JViewLegacy
{
	protected $items;

	protected $pagination;

	protected $state;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');
		$this->state		= $this->get('State');

        $this->loadHelper('edashboard');
		EdashboardHelper::addSubmenu('edashboard');

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

		$this->addToolbar();
		$this->sidebar = JHtmlSidebar::render();
		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @since   1.6
	 */
	protected function addToolbar()
	{
		$state	= $this->get('State');

		$canDo	= JHelperContent::getActions('com_edashboard', 'category', $state->get('filter.category_id'));
		$user	= JFactory::getUser();

		// Get the toolbar object instance
		$bar = JToolBar::getInstance('toolbar');
		JToolbarHelper::title(JText::_('COM_EDASHBOARD_MANAGER'), 'calendar-3');

		if (count($user->getAuthorisedCategories('com_edashboard', 'core.create')) > 0)
		{
			JToolbarHelper::addNew('post.add');
		}
		if ($canDo->get('core.edit'))
		{
			JToolbarHelper::editList('post.edit');
		}
		if ($canDo->get('core.edit.state'))
		{
			JToolbarHelper::publish('edashboard.publish', 'JTOOLBAR_PUBLISH', true);
			JToolbarHelper::unpublish('edashboard.unpublish', 'JTOOLBAR_UNPUBLISH', true);
			JToolbarHelper::archiveList('edashboard.archive');
		}
		if ($canDo->get('core.admin'))
		{
			JToolbarHelper::checkin('post.checkin');
			}
		if ($state->get('filter.published') == -2 && $canDo->get('core.delete'))
		{
			JToolbarHelper::deleteList('', 'edashboard.delete', 'JTOOLBAR_EMPTY_TRASH');
		} elseif ($canDo->get('core.edit.state'))
		{
			JToolbarHelper::trash('edashboard.trash');
		}
		
		if ($user->authorise('core.admin', 'com_edashboard'))
		{
			JToolbarHelper::preferences('com_edashboard');
		}
		JToolbarHelper::help('JHELP_COMPONENTS_ACT');

		JHtmlSidebar::setAction('index.php?option=com_edashboard&view=edashboard');

		JHtmlSidebar::addFilter(
			JText::_('JOPTION_SELECT_PUBLISHED'),
			'filter_published',
			JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), 'value', 'text', $this->state->get('filter.published'), true)
		);

		JHtmlSidebar::addFilter(
			JText::_('JOPTION_SELECT_CATEGORY'),
			'filter_category_id',
			JHtml::_('select.options', JHtml::_('category.options', 'com_edashboard'), 'value', 'text', $this->state->get('filter.category_id'))
		);
	}

	/**
	 * Returns an array of fields the table can be sorted by
	 *
	 * @return  array  Array containing the field name to sort by as the key and display text as value
	 *
	 * @since   3.0
	 */
	protected function getSortFields()
	{
		return array(
			'a.ordering' => JText::_('JGRID_HEADING_ORDERING'),
			'a.published' => JText::_('JSTATUS'),
			'a.document_number' => JText::_('JSTATUS'),
			'a.official_number' => JText::_('JSTATUS'),
			'a.name' => JText::_('JGLOBAL_TITLE'),
			'category_title' => JText::_('JCATEGORY'),
			'a.access' => JText::_('JGRID_HEADING_ACCESS'),
			'a.language' => JText::_('JGRID_HEADING_LANGUAGE'),
			'a.id' => JText::_('JGRID_HEADING_ID')
		);
	}
}
