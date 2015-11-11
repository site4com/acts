<?php

defined('_JEXEC') or die('Restricted access');

/**
 * Item model.
 *
 * @package  JSN_LighDoc
 * @since    1.0.0
 */
class EdashboardModelEdashboard extends JModelList
{
	protected $option = "com_edashboard";

	/**
	 * Constructor.
	 *
	 * @param   array  $config  An optional associative array of configuration settings.
	 *
	 * @see     JController
	 * @since   11.1
	 */
	public function __construct($config = array())
	{
		parent::__construct($config);
		$this->_app = JFactory::getApplication();
		$this->_input = $this->_app->input;
	}

	/**
	 * Method to get a JDatabaseQuery object for retrieving the data set from a database.
	 *
	 * @return  JDatabaseQuery   A JDatabaseQuery object to retrieve the data set.
	 *
	 * @since   12.2
	 */
	protected function getListQuery()
	{
		$value = $this->_input->get('limitstart', 0, 'uint');
		$this->setState('list.start', $value);

		$ID	= (int) $this->_input->get('edashboard_id', 0, 'uint');
		
		$query	= $this->_db->getQuery(true);
		$query->select('*');
		$query->from($this->_db->quoteName('#__edashboard'));
		$query->where($this->_db->quoteName('id') . ' = ' . $this->_db->quote((int) $ID) . ' AND ' . $this->_db->quoteName('published') . ' = ' . $this->_db->quote((int) 1));
		$query->order('name ASC');
		return $query->__toString();
	}

	public function getListAttachment()
	{
		$value = $this->_input->get('limitstart', 0, 'uint');
		$this->setState('list.start', $value);

		$ID	= (int) $this->_input->get('edashboard_id', 0, 'uint');
		$db =  JFactory::getDbo();

		$query	= $db->getQuery(true);
		$query->select('*');
		$query->from($db->quoteName('#__edashboard_attachments'));
		$query->where($db->quoteName('edashboard_id') . ' = ' . $db->quote((int) $ID));
		$query->order('ordering ASC');
		
		$db->setQuery($query);
		$result	= $db->loadObjectList();

		return $result;
	}

	public function getEdashboard()
	{		
		$ID	= (int) $this->_input->get('edashboard_id', 0, 'uint');
		$db =  JFactory::getDbo();

		$query	= $db->getQuery(true);
		$query->select('*');
		$query->from($db->quoteName('#__edashboard'));
		$query->where($db->quoteName('id') . ' = ' . $db->quote((int) $ID));
		
		$db->setQuery($query);
		$result	= $db->loadObject();

		return $result;
	}
}
