<?php
/**
 * @version		$Id: helper.php 21421 2011-06-03 07:21:02Z infograf768 $
 * @package		Joomla.Site
 * @subpackage	mod_availcal
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

class modAvailcalHelper
{
	public static function getDarkperiods($params)
	{
		// just startup
		$mainframe = JFactory::getApplication();


		
		//Get parameters
		$name = $params->get('name');
		
		//Array for the dark periods
		$dark_days = array();

		//Get the database
		$db =& JFactory::getDBO();
		//Get Darkperiods
		$query = 'SELECT unix_timestamp(start_date),unix_timestamp(end_date),busy FROM' . $db->nameQuote('#__avail_calendar'). 'WHERE' . $db->nameQuote('name') . ' = ' . $db->Quote($name) ;
		$db->setQuery($query);
		$db->query();

		//Check of object has one or more darkperiods
		$line = null;
		$dark_days = null;
		if ($num_rows = $db->getNumRows()	){
			$counter = 0;
			$line = $db->loadAssocList();
			while ($counter < $num_rows )
			{
				$dark_days[$counter]['start'] = $line[$counter]['unix_timestamp(start_date)'];
				$dark_days[$counter]['end'] = $line[$counter]['unix_timestamp(end_date)'];
				$dark_days[$counter]['busy'] = $line[$counter]['busy'];
				$counter++;
			}
		}
		return $dark_days;
	}
}
