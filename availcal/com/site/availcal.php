<?php
/**
 * Availability Calendar Site entry point
 * 
 * @package    	com_availcal
 * @subpackage 	components
 * @link 				
 * @license			GNU/GPL
 */
 // No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import joomla controller library
jimport('joomla.application.component.controller');
 
// Get an instance of the controller prefixed by AvailCal
$controller = JController::getInstance('Availcal');
 
// Perform the Request task
$controller->execute(JRequest::getCmd('task'));
 
// Redirect if set by the controller
$controller->redirect();
