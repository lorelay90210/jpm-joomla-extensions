<?php
/**
 * Availability Calendar Component Administrator Darkperiods View
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
 * Darkperiods View
 *
 * @package    com_availcal
 * @subpackage components
 */
class AvailCalViewDarkperiods extends JView

{
	protected $items;
	protected $pagination;
	protected $state;
	
	/**
	 * Accommodations view display method
	 * @return void
	 */
	function display($tpl = null) 
	{
		// Get data from the model
		$items = $this->get('Items');
		$pagination = $this->get('Pagination');
 		$state = $this->get('State');
		// Check for errors.
		if (count($errors = $this->get('Errors'))) 
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		// Assign data to the view
		$this->items = $items;
		$this->pagination = $pagination;
		$this->state = $state;
		
		// Set the toolbar
		$this->addToolBar();
		 
		// Display the template
		parent::display($tpl);
	}
	/**
	 * Setting the toolbar
	 */
	protected function addToolBar() 
	{
		JToolBarHelper::title(JText::_('DARK_PERIODS'));
		JToolBarHelper::deleteList('', 'darkperiods.delete');
		JToolBarHelper::editList('darkperiod.edit');
		JToolBarHelper::addNew('darkperiod.add');
		JToolBarHelper::custom('export.export','export','export', 'Export');
	}
	
}
