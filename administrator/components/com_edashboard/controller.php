<?php

defined('_JEXEC') or die;

/**
 * Edashboard master display controller.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_edashboard
 * @since       1.6
 */
class EdashboardController extends JControllerLegacy
{
	/**
	 * Method to display a view.
	 *
	 * @param   boolean			If true, the view output will be cached
	 * @param   array  An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
	 *
	 * @return  JController		This object to support chaining.
	 * @since   1.5
	 */
	public function display($cachable = false, $urlparams = false)
	{
		JForm::addFieldPath(JPATH_COMPONENT . '/models/fields');
		require_once JPATH_COMPONENT.'/helpers/edashboard.php';

		$view   = $this->input->get('view', 'edashboard');
		$layout = $this->input->get('layout', 'default');
		$id     = $this->input->getInt('id');
		$document = JFactory::getDocument();
		$url = JUri::base(). 'components/com_edashboard/assets/js/main.js';

		$document->addScript($url);
		// Check for edit form.
		if ($view == 'edashboard' && $layout == 'edit' && !$this->checkEditId('com_edashboard.edit.post', $id))
		{

			// Somehow the person just went to the form - we don't allow that.
			$this->setError(JText::sprintf('JLIB_APPLICATION_ERROR_UNHELD_ID', $id));
			$this->setMessage($this->getError(), 'error');
			$this->setRedirect(JRoute::_('index.php?option=com_edashboard&view=edashboard', false));

			return false;
		}

		parent::display();
	}
}
