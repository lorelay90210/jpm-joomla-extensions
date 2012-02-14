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
	
	// Require the base controller
	require_once( JPATH_COMPONENT.DS.'controller.php' );
	
	// Create the controller
	$controller =  new AvailcalController();

	//Perform the requested task
	$controller->execute( JRequest::getVar( 'task' ) );
	
	//Redirect if set by the controller
	$controller->redirect();