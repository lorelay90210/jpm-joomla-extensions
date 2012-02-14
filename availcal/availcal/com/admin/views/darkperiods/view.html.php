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
class AvailcalViewDarkperiods extends JView
{
	/**
	 * Darkperiods view display method
	 *
	 * @return void
	 **/
	function display( $tpl = null )
	{
		$mainframe  = JFactory::getApplication();
			
		JToolBarHelper::title( JText::_( 'DARK_PERIODS' ) );
		JToolBarHelper::deleteList();
		JToolBarHelper::editListX();
		JToolBarHelper::addNewX();		
		JToolBarHelper::help( 'help', true );

		// Prepare list array
		$lists = array();
			
		// Force the layout form to submit itself immediately
		$js = "onchange=\"if (this.options[selectedIndex].value!='')
												{ document.adminForm.submit(); }\"";
			
		// Get the user state
		$filter_order     = $mainframe->getUserStateFromRequest($option.'filter_order', 'filter_order', 'name');
		$filter_order_Dir = $mainframe->getUserStateFromRequest($option.'filter_order_Dir', 'filter_order_Dir', 'ASC');
		$filter_search	  = $mainframe->getUserStateFromRequest($option.'filter_search', 'filter_search');
		
		// Build the list array for use in the layout
		$lists['order'] 		= $filter_order;
		$lists['order_Dir'] = $filter_order_Dir;
		$lists['search'] = $filter_search;
		

		// Get revues  and pagination from the model
		$model  =& $this->getModel( 'darkperiods' );
		$darkperiods =& $model->getDarkperiods();
		$page   =& $model->getPagination();

		// Assign references for the layout to use
		$this->assignRef('lists',  $lists);
		$this->assignRef('darkperiods', $darkperiods);
		$this->assignRef('page', $page);

		parent::display( $tpl );
	}
}