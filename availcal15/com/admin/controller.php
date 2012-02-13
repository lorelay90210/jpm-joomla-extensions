<?php
/**
 * Availabilit Calendar Administrator default controller 
 * 
 * @package    	com_availcal
 * @subpackage 	components
 * @link 				
 * @license			GNU/GPL
 */
	
	// no direct access
	defined( '_JEXEC' ) or die( 'Restricted access' );
	
	// Load the base JController class
	jimport( 'joomla.application.component.controller' );
	jimport('joomla.client.helper');
	
	/**
	 * Availability Calendar Component Administrator Controller
	 *
	 * @package    	com_availcal
	 * @subpackage 	components
	 */
	class AvailcalController extends JController
	{
		/**
		 *	Method to display the list view
		 *
		 *	@access		public
		 *
		 */
		function display()
		{
			// We override the JController default display method which expects a view
			// named availcal. We want a view of 'darkperiods' that uses the 'default' layout. 
			// Set the view and the model  
			$view =& $this->getView( JRequest::getVar( 'view', 'darkperiods' ), 'html' );
			$model =& $this->getModel( 'darkperiods' ); 
			$view->setModel( $model, true ); 
			
			// Use the View display method
			$view->display(); 
		}
		
		/**
		 *	Method to display the edit view
		 *
		 *	@access		public 
		 *
		 */
		function edit()
		{
			// Get the requested id(s) as an array of ids
			$cids = JRequest::getVar( 'cid', null, 'default', 'array' );
			
			if( $cids === null )
			{
				// Report an error if there was no cid parameter in the request
				JError::raiseError( 500, 'cid parameter missing from the request' );
			}
			
			// Get the first darkperiod to be edited
			$darkperiodId = (int)$cids[0];

			// Set the view and model for a single darkperiod
			$view =& $this->getView( JRequest::getVar( 'view', 'darkperiod' ), 'html' );
			$model =& $this->getModel( 'darkperiod' );       
			$view->setModel( $model, true );
		
			// Display the edit form for the requested darkperiod
			$view->edit( $darkperiodId );
		}
		
		/**
		 *	Method to save the darkperiod
		 *
		 *	@access		public
		 *
		 */
		function save()
		{			
			$model =& $this->getModel( 'darkperiod' );
			$model->store();
			
			$redirectTo = JRoute::_( 'index.php?option=' .
															 JRequest::getVar( 'option' ) .
															 '&task=display' );
			
			$this->setRedirect( $redirectTo, JText::_( 'SAVED' ) );
		}
		
		/**
		 *	Method to add a new darkperiod
		 *
		 *	@access		public
		 *
		 */
		function add()
		{
			// Set the view for a single darkday 
			$view =& $this->getView( JRequest::getVar( 'view', 'darkperiod' ), 'html' );
			$model =& $this->getModel( 'darkperiod' );
			$view->setModel( $model, true );
			
			$view->add();
		}
		
		/**
		 *	Method to remove one or more darkperiod
		 *
		 *	@access		public
		 *
		 */
		function remove()
		{
			// Retrieve the ids to be removed
			$cids = JRequest::getVar( 'cid', null, 'default', 'array' );
			
			if( $cids === null )
			{
				// Make sure there were records to be removed
				JError::raiseError( 500, JText::_( 'NO_SELECTION' ) );
			}
			
			$model =& $this->getModel( 'darkperiods');
			$model->delete( $cids);
			
			$redirectTo = JRoute::_( 'index.php?option=' .
															 JRequest::getVar( 'option' ) .
															 '&task=display' );
			
			$this->setRedirect( $redirectTo, JText::_( 'DELETED' ) );
		}
		
		/**
		 *	Method to cancel
		 *
		 *	@access		public
		 *
		 */
		function cancel()
		{		
			$redirectTo = JRoute::_( 'index.php?option=' .
															 JRequest::getVar( 'option' ) .
															 '&task=display' );
			
			$this->setRedirect( $redirectTo, JText::_( 'CANCELLED' ) );
		}
		/**
		 *  Method to upload a XML file
		 * 
		 *  @access		public
		 */
		function uploadform()
		{
			//Read file	
			$view =& $this->getView( JRequest::getVar( 'view', 'xmlupload' ), 'html' );
			$ftp =& JClientHelper::setCredentialsFromRequest('ftp');
			$view->assignRef('ftp', $ftp);				
			
			// Use the View display method
			$view->display(); 
		} 
		function readfile()
		{
			
			//Read file		
			$model = $this->getModel('xmlupload');
			$dest = $model->readFile();
			if (!$dest) {			
				$msg = JText::_( 'ERROR_UPLOAD' );
				$this->setRedirect( 'index.php?option=com_availcal&task=uploadform', $msg );
				Return;												
			}
			if (!$model->convertXml($dest)) {
				$msg = $model->errorCode;
				if (!$model->deleteFile($dest))	
				{
					$msg = JText::_( 'ERROR_DELETE' );
				}
				$this->setRedirect( 'index.php?option=com_availcal&task=uploadform', $msg );
				Return;												
			}
			// delete file
			if (!$model->deleteFile($dest))	{
				$msg = JText::_( 'ERROR_DELETE' );
				$this->setRedirect( 'index.php?option=com_availcal&task=uploadform', $msg );
				Return;												
			}			
			$msg = JText::_( 'READY' );			
			$this->setRedirect( 'index.php?option=com_availcal&task=uploadform', $msg );
		}
		
	}
	
	