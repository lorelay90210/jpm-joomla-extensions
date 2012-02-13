<?php
/**
 * Availability Calendar Administrator darkperiod model
 * 
 * @package    	com_availcal
 * @subpackage 	components
 * @link 				
 * @license			GNU/GPL
 */
	
	// no direct access
	defined( '_JEXEC' ) or die( 'Restricted access' );
	
	// Import the JModel class
	jimport( 'joomla.application.component.model' );
	
	/**
	 *  Availability Calendar Darkperiod Model
	 *
 	 * 	@package    	com_availcal
   * 	@subpackage 	components
	 */
	class AvailcalModelDarkperiod extends JModel
	{
		/**
		 *	Method to get a darkperiod
		 *
		 *	@access public
		 *	@return object
		 */
		function getDarkperiod( $id )
		{
			$db 	 = $this->getDBO();
			$table = $db->nameQuote( '#__avail_calendar' );
			$key   = $db->nameQuote( 'id' );
			$query = "SELECT * FROM " . $table . " WHERE " . $key . " = " . $id;
			
			$db->setQuery( $query );
			$darkperiod = $db->loadObject();
		
			if( $darkperiod === null )
			{
				JError::raiseError( 500, 'Darkperiod [' .$id.'] not found.' );
			} 
			else
			{
				// Return the revue data
				return $darkperiod;
			}
		}
		
		/**
		 *	Method that returns an empty darkperiod with id of 0
		 *
		 *	@access public
		 *	@return object
		 */
		function getNewDarkperiod()
		{
			$newDarkperiod =& $this->getTable( 'darkperiod' );
			$newDarkperiod->id = 0;
			
			return $newDarkperiode;
		}
				
		/**
		 *	Method to store a darkperiod
		 *
		 *	@access public
		 *	@return Boolean true on success
		 */
		function store()
		{
			// Get the table
			$table =& $this->getTable();
			$darkperiod = JRequest::get('post');
			
			// Convert the date to a form that the database can understand
			jimport('joomla.utilities.date');
			
			$startdate = new JDate( JRequest::getVar( 'start_date', '', 'post'));
			$darkperiod['start_date'] = $startdate->toMySQL();
			$enddate = new JDate(  JRequest::getVar( 'end_date', '', 'post'));
			$darkperiod['end_date'] = $enddate->toMySQL();
			
			// Make sure the table buffer is empty
			$table->reset();			
			
			// Bind the data to the table
			if( !$table->bind($darkperiod))
			{
				$this->setError( $this->_db->getErrorMsg());
				return false;
			}
			
			// Validate the data
			if( !$table->check())
			{
				$this->setError( $this->_db->getErrorMsg());
				return false;
			}
			
		// Store the revue
			if( !$table->store())
			{
				// An error occurred, update the model error message
				$this->setError( $table->getErrorMsg());
				return false;
			}
			
			
			
			

			return true;
		}
	}
	
	