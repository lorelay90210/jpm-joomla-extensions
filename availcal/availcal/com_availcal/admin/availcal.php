<?php
/**
 * Availability Calendar Administrator entry point
 *
 * @package    	com_availcal
 * @subpackage 	components
 * @link
 * @license			GNU/GPL
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );


// import joomla controller library
jimport('joomla.application.component.controller');

// Get an instance of the controller prefixed by HasData
$controller = JController::getInstance('AvailCal');

// Perform the Request task
$controller->execute(JRequest::getCmd('task'));

// Redirect if set by the controller
$controller->redirect();