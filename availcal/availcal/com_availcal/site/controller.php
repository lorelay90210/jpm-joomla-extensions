<?php
/**
 * Availability Calendar Site Controller
 * 
 * @package    	com_availcal
 * @subpackage 	components
 * @link 				
 * @license			GNU/GPL
 */
 // No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controller library
jimport('joomla.application.component.controller');
 
/**
 * Availal Component Controller
 */
class AvailcalController extends JController
{
	/**
	 * display task
	 *
	 * @return void
	 */
	function display($cachable = false)
	{
		$format = JRequest::getvar( 'format', 'update');
	
		$view = $this->getView ('calendar', $format);
		$model = $this->getModel('calendar');
		$view->setModel ($model, true);
		
		// Use the View display method
			$view->display(); 
				
	}
}
