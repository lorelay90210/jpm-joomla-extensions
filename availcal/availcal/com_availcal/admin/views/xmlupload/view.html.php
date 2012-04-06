<?php
/**
 * 	Availability Calendar Component Administrator Xmlupload View
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
	 * Xmlupload View
	 *
	 * @package    com_boxoffice
	 * @subpackage components
	 */
	class AvailcalViewXmlupload extends JView
	{
		function display($tpl=null)
		{
			/*
			 * Set toolbar items for the page
			 */
			JToolBarHelper::title( JText::_( 'XML_UPLOAD' ) . ': [<small>' . JText::_( 'EDIT' ) . '</small>]' );
	/*
			$paths = new stdClass();
			$paths->first = '';
	
			$this->assignRef('paths', $paths);
			$this->assignRef('state', $this->get('state'));
	*/
			parent::display($tpl);
		}
	}