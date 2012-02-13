<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * Availability Calendar Site view
 *
 * @package    	com_availcal
 * @subpackage 	components
 * @link
 * @license			GNU/GPL
 */
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla view library
jimport('joomla.application.component.view');

/**
 * HTML View class for the AvailCal Component
 */
class AvailcalViewCalendar extends JView
{
	// Overwriting JView display method
	function display($tpl = null)
	{
		//Get Plugin Params		
		$enabled = JPluginHelper::isEnabled('content', 'availcal'); 
		if ($enabled)
		{
			$plugin = JPluginHelper::getPlugin('content', 'availcal');
			$pluginParams = new JRegistry();
			$pluginParams->loadString($plugin->params);
			$week_firstday = $pluginParams->get('week_firstday',0);
		}
		else 
		{
			$week_firstday = 0; 
		}
		//Get dark periods
		$this->items = $this->get('Items');
			

		// Display the view
		parent::display($tpl);

	}
}
