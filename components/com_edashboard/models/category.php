<?php

defined('_JEXEC') or die('Restricted access');

/**
 * Item model.
 *
 * @package  JSN_LighDoc
 * @since    1.0.0
 */
class EdashboardModelCategory extends JModelList
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
	 * Method to auto-populate the model state.
	 *
	 * This method should only be called once per instantiation and is designed
	 * to be called on the first call to the getState() method unless the model
	 * configuration flag to ignore the request is set.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @param   string  $ordering   An optional ordering field.
	 * @param   string  $direction  An optional direction (asc|desc).
	 *
	 * @return  void
	 *
	 * @since   12.2
	 */
	protected function populateState($ordering = null, $direction = null)
	{
		// Initialise variables.
		$app 				= JFactory::getApplication();
		$categoryID	 		= $app->getUserStateFromRequest($this->context . '.category.catid', 'category_id', '0', 'int');
		$this->setState('category.catid', $categoryID);

		$value = $this->_input->get('limit', $this->_app->get('list_limit', 0), 'uint');
		$this->setState('list.limit', $value);
		
		$value = $this->_input->get('limitstart', 0, 'uint');
		$this->setState('list.start', $value);
		
		parent::populateState($ordering, $direction);
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
		
		$categoryID	= (int) $this->getState('category.catid');
		
		$query	= $this->_db->getQuery(true);
		$query->select('*');
		$query->from($this->_db->quoteName('#__edashboard'));
		$query->where($this->_db->quoteName('catid') . ' = ' . $this->_db->quote((int) $categoryID) . ' AND ' . $this->_db->quoteName('published') . ' = ' . $this->_db->quote((int) 1));
		$query->order('name ASC');
		return $query->__toString();
	}
}
