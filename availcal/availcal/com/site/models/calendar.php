<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla modelitem library
jimport('joomla.application.component.modellist');

/**
 * Availability Calendar Site calendar model
 * 
 * @package    	com_availcal
 * @subpackage 	components
 * @link 				
 * @license			GNU/GPL
 */
 
class AvailcalModelCalendar extends JModelList
{
	protected  function _getListQuery()
	{
		// Get id
		$id = JRequest::getVar( 'id');		
		// Create a new query object.
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		// Select some fields
		$query->select( 'unix_timestamp(start_date)as start_date' );
		$query->select( 'unix_timestamp(end_date)as end_date' );
		$query->select( 'busy' );
		// From the AvailCal table
		$query->from('#__avail_calendar');
		
		$query->where('name = \'' . $id . '\'');
		

		return $query;
	}	
}
