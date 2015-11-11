<?php

defined('_JEXEC') or die;

/**
 * Content Component Category Tree
 *
 * @package     Joomla.Site
 * @subpackage  com_lightdoc
 * @since       1.6
 */
class EdashboardCategories extends JCategories
{
    public function __construct($options = array())
    {
        $options['table'] = '#__edashboard';
        $options['extension'] = 'com_edashboard';

        parent::__construct($options);
    }
}
