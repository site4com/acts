<?php

defined('_JEXEC') or die;

/**
 * Edashboard list controller class.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_edashboard
 * @since       1.6
 */
class EdashboardControllerEdashboard extends JControllerAdmin
{
	/**
	 * Proxy for getModel.
	 */
	public function getModel($name = 'Post', $prefix = 'EdashboardModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);
		return $model;
	}

	protected function postDeleteHook(JModelLegacy $model, $ids = null)
	{
	}
}
