<?php

defined('_JEXEC') or die;

/**
 * View to edit a edashboard.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_edashboard
 * @since       1.6
 */
class EdashboardViewPost extends JViewLegacy
{
	protected $item;

	protected $form;

	protected $state;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		$this->state	= $this->get('State');
		$this->item		= $this->get('Item');
		$this->form		= $this->get('Form');

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

		if ($this->getLayout() == 'modal')
		{
			$this->form->setFieldAttribute('language', 'readonly', 'true');
			$this->form->setFieldAttribute('catid', 'readonly', 'true');
		}
		$this->addToolbar();
		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @since   1.6
	 */
	protected function addToolbar()
	{
		JFactory::getApplication()->input->set('hidemainmenu', true);

		$user		= JFactory::getUser();
		$isNew		= ($this->item->id == 0);
		$checkedOut	= !($this->item->checked_out == 0 || $this->item->checked_out == $user->get('id'));

		// Since we don't track these assets at the item level, use the category id.
		$canDo		= JHelperContent::getActions('com_edashboard', 'category', $this->item->catid);

		JToolbarHelper::title(JText::_('COM_EDASHBOARD_MANAGER_POST'), 'post edashboard');

		// If not checked out, can save the item.
		if (!$checkedOut && ($canDo->get('core.edit') || count($user->getAuthorisedCategories('com_edashboard', 'core.create')) > 0))
		{
			JToolbarHelper::apply('post.apply');
			JToolbarHelper::save('post.save');
		}
		if (!$checkedOut && count($user->getAuthorisedCategories('com_edashboard', 'core.create')) > 0)
		{
			JToolbarHelper::save2new('post.save2new');
		}
		// If an existing item, can save to a copy.
		if (!$isNew && $canDo->get('core.create'))
		{
			JToolbarHelper::save2copy('post.save2copy');
		}

		if (empty($this->item->id))
		{
			JToolbarHelper::cancel('post.cancel');
		}
		else
		{
			JToolbarHelper::cancel('post.cancel', 'JTOOLBAR_CLOSE');
		}

		JToolbarHelper::divider();
		JToolbarHelper::help('JHELP_COMPONENTS_ACT_EDIT');
	}
}
