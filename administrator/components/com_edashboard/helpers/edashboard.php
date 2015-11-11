<?php

defined('_JEXEC') or die;

/**
 * Edashboard component helper.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_edashboard
 * @since       1.6
 */
class EdashboardHelper extends JHelperContent
{
	public static $extension = 'com_edashboard';

	/**
	 * Configure the Linkbar.
	 *
	 * @param   string  $vName  The name of the active view.
	 *
	 * @return  void
	 */
	public static function addSubmenu($vName)
	{
		
        JHtmlSidebar::addEntry(
            JText::_('COM_EDASHBOARD_SUBMENU_CATEGORIE'),
            'index.php?option=com_categories&extension=com_edashboard',
            $vName == 'categories');
        
        JHtmlSidebar::addEntry(
        		JText::_('COM_EDASHBOARD_SUBMENU_AFFISSIONI'),
        		'index.php?option=com_edashboard',
        		$vName == 'edashboard');
	}
}
