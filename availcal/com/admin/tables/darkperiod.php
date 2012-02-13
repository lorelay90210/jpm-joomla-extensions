<?php
/**
 * Avalilability Calendar Administrator revues table
 *
 * @package    	com_availcal
 * @subpackage 	components
 * @link
 * @license			GNU/GPL
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

/**
 * Revue Table class
 *
 * @package    com_boxoffice
 * @subpackage components
 */
class TableDarkperiod extends JTable
{
	/** @var int Primary key */
	var $id 							= 0;
	/** @var int */
	var $name 							= '';
	/** @var int */
	var $busy							= 1;
	/** @var datetime */
	var $start_date						= '';
	/** @var datetime */
	var $end_date 						= '';
	/** @var string */
	var $remarks 						= '';


	/**
		* @param database A database connector object
		*/
	function __construct( &$db )
	{
		parent::__construct( '#__avail_calendar', 'id', $db );
	}

	
		
}