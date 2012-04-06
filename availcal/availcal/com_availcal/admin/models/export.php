<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla modelform library
jimport('joomla.application.component.modeladmin');

/**
 * Export Model
 *
 */
class AvailCalModelExport extends JModel
{

	/**
	 * Method to Export one or more records.
	 *
	 * @param	array	$pks	An array of record primary keys.
	 *
	 * @return	$objects
	 * @since	1.6
	 */
	public function getItems($cid)
	{
		$db = JFactory::getDBO();		
		$query = "SELECT * FROM #__avail_calendar  WHERE id IN (". implode(",", $cid) .")";
		$db->setQuery($query);
		$items = $db->loadAssocList();
		return $items;
	}
}
