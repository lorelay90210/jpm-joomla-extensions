<?php
/**
 * 	Availability Calendar Component Administrator Darkperiod View
 * 
 * 	@package    	com_availcal
 * 	@subpackage 	components
 * 	@link 				
 * 	@license			GNU/GPL
 */

	// No direct access
	defined( '_JEXEC' ) or die( 'Restricted access' );
	
	jimport( 'joomla.application.component.view' );
	
	/**
	 * Darkperiod View
	 *
	 * @package    com_boxoffice
	 * @subpackage components
	 */
	class AvailcalViewDarkperiod extends JView
	{
		/**
		 * 	Darkperiod view edit method 
		 * 	@return void 
		 **/
		function edit( $id )
		{
			// Build the toolbar for the edit function
			JToolBarHelper::title( JText::_( 'DARK_PERIODS' ) . ': [<small>' . JText::_( 'EDIT' ) . '</small>]' );
			JToolBarHelper::save();
			JToolBarHelper::cancel( 'cancel', 'Close' ); 
	
			// Get the darkperiod  
			$model =& $this->getModel();
			$darkperiod = $model->getDarkperiod( $id ); 
			$this->assignRef( 'darkperiod',	$darkperiod );

			parent::display();
		}
		
		/**
		 * 	Darkperiod view add method
		 * 	@return void
		 **/
		function add()
		{
			// Build the toolbar for the add function
			JToolBarHelper::title( JText::_( 'DARK_PERIODS' ) . ': [<small>' . JText::_( 'ADD' ) . '</small>]' );
			JToolBarHelper::save();
			JToolBarHelper::cancel();
	
			// Get a new revue from the model
			$model =& $this->getModel();
			$darkperiod = $model->getNewDarkperiod();
			$this->assignRef( 'darkperiod', $darkperiod );
	
			parent::display();
		}
	}