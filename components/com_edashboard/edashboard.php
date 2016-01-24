<?php

defined('_JEXEC') or die('Restricted access');

// import joomla controller library
jimport('joomla.application.component.controller');

// Register helper class
//JLoader::register('EdashboardHelperRoute', JPATH_COMPONENT_SITE . '/helpers/route.php');

// Get the appropriate controller
$controller = JControllerLegacy::getInstance('Edashboard');

// Perform the request task
$controller->execute(JFactory::getApplication()->input->get('task'));

// Redirect if set by the controller
$controller->redirect();
