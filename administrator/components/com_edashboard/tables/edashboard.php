<?php

defined('_JEXEC') or die;

/**
 * @package     Joomla.Administrator
 * @subpackage  com_edashboard
 */
class EdashboardTableEdashboard extends JTable
{
	/**
	 * Ensure the params, metadata and images are json encoded in the bind method
	 *
	 * @var    array
	 * @since  3.3
	 */
	protected $_jsonEncode = array('params', 'metadata');

	/**
	 * Constructor
	 *
	 * @param   JDatabaseDriver  &$db  A database connector object
	 */
	public function __construct(&$db)
	{
		parent::__construct('#__edashboard', 'id', $db);

		JTableObserverTags::createObserver($this, array('typeAlias' => 'com_edashboard.post'));
	}
	/**
	 * Overriden JTable::store to set modified data.
	 *
	 * @param   boolean	 $updateNulls  True to update fields even if they are null.
	 *
	 * @return  boolean  True on success.
	 *
	 * @since   1.6
	 */
	public function store($updateNulls = false)
	{
		$date	= JFactory::getDate();
		$user	= JFactory::getUser();
		if ($this->id)
		{
			// Existing item
			$this->modified		= $date->toSql();
			$this->modified_by	= $user->get('id');
		}
		else
		{
			// New edashboard. A feed created and created_by field can be set by the user,
			// so we don't touch either of these if they are set.
			if (!(int) $this->created)
			{
				$this->created = $date->toSql();
			}
			if (empty($this->created_by))
			{
				$this->created_by = $user->get('id');
			}
		}
		// Verify that the alias is unique
		$table = JTable::getInstance('Edashboard', 'EdashboardTable');
		if ($table->load(array('alias' => $this->alias, 'catid' => $this->catid)) && ($table->id != $this->id || $this->id == 0))
		{
			$this->setError(JText::_('COM_EDASHBOARD_ERROR_UNIQUE_ALIAS') . ' ' . $this->alias);
			return false;
		}

		return parent::store($updateNulls);
	}

	/**
	 * Method to delete a row from the database table by primary key value.
	 *
	 * @param   mixed  $pk  An optional primary key value to delete.  If not set the instance property value is used.
	 *
	 * @return  boolean  True on success.
	 *
	 * @link    http://docs.joomla.org/JTable/delete
	 * @since   11.1
	 * @throws  UnexpectedValueException
	 * @ABP: delete attachments
	 */
	public function delete($pk = null)
	{
		if (is_null($pk))
		{
			$pk = array();

			foreach ($this->_tbl_keys AS $key)
			{
				$pk[$key] = $this->$key;
			}
		}
		elseif (!is_array($pk))
		{
			$pk = array($this->_tbl_key => $pk);
		}

		foreach ($this->_tbl_keys AS $key)
		{
			$pk[$key] = is_null($pk[$key]) ? $this->$key : $pk[$key];

			if ($pk[$key] === null)
			{
				throw new UnexpectedValueException('Null primary key not allowed.');
			}
			$this->$key = $pk[$key];
		}

		// Implement JObservableInterface: Pre-processing by observers
		$this->_observers->update('onBeforeDelete', array($pk));

		// If tracking assets, remove the asset first.
		if ($this->_trackAssets)
		{
			// Get the asset name
			$name  = $this->_getAssetName();
			$asset = self::getInstance('Asset');

			if ($asset->loadByName($name))
			{
				if (!$asset->delete())
				{
					$this->setError($asset->getError());

					return false;
				}
			}
		}

		// ABP: remove attachments
		// TODO: move to helper
		jimport('joomla.filesystem.file');
		$application = JFactory::getApplication();
		$base_path = JPATH_ROOT . "/edashboard_uploads";
		for($i = 0; $i < 12 ; $i++){
			$fname ="filename$i";
			if($this->$fname){
				if(!JFile::delete($base_path . '/' . $this->$fname)){
					$application->enqueueMessage(JText::_('COM_EDASHBOARD_DELETE_ATTACHMENT_ERROR') . ' ' . $this->$fname, 'warning');
				} else {
					$application->enqueueMessage(JText::_('COM_EDASHBOARD_DELETE_ATTACHMENT_SUCCESS') . ' ' . $this->$fname, 'message');
				}
			}
		}


		// Delete the row by primary key.
		$query = $this->_db->getQuery(true)
		->delete($this->_tbl);
		$this->appendPrimaryKeys($query, $pk);

		$this->_db->setQuery($query);

		// Check for a database error.
		$this->_db->execute();

		// Implement JObservableInterface: Post-processing by observers
		$this->_observers->update('onAfterDelete', array($pk));

		return true;
	}
}
