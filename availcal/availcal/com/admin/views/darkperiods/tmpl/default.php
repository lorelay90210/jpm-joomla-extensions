<?php
/**
 * 	Availability Calendar Component Administrator Darkperiods View
 *
 * 	@package    	com_availcal
 * 	@subpackage 	components
 * 	@link
 * 	@license			GNU/GPL
 */

// No direct access
defined('_JEXEC') or die('Restricted access'); ?>

<form action="index.php" method="post" name="adminForm">
<table>
			<tr>
				<td align="left" width="100%">
					<?php echo JText::_('FILTER'); ?>
					<input type="text" name="filter_search" id="search" value="<?php echo $this->lists['search']; ?>" class="text_area" onchange="document.adminForm.submit();" />
					<button onclick="this.form.submit();"><?php echo JText::_('Search'); ?></button>
					<button onclick="document.adminForm.filter_search.value=''; this.form.submit();"><?php echo JText::_('Reset'); ?></button>
				</td>				
			</tr>
		</table>
<table class="adminlist">
	<thead>
		<tr>
			<th width="20" nowrap="nowrap"><?php echo JHTML::_( 'grid.sort', 'ID', 'id', $this->lists['order_Dir'], $this->lists['order'] ); ?></th>
			<th width="20" nowrap="nowrap"><input type="checkbox" name="toggle"
				value=""
				onclick="checkAll(<?php echo count( $this->darkperiods ); ?>);" /></th>			
			<th width="420"><?php echo JHTML::_( 'grid.sort', 'Naam', 'naam', $this->lists['order_Dir'], $this->lists['order'] ); ?></th>
			<th width="80"><?php echo JHTML::_( 'grid.sort', 'busy', 'busy', $this->lists['order_Dir'], $this->lists['order'] ); ?></th>			
			<th width="80"><?php echo JHTML::_( 'grid.sort', 'Start_Datum', 'start_date', $this->lists['order_Dir'], $this->lists['order'] ); ?></th>
			<th width="80"><?php echo JHTML::_( 'grid.sort', 'Eind_Datum', 'end_date', $this->lists['order_Dir'], $this->lists['order'] ); ?></th>			
			<th><?php echo JText::_( 'Opmerking'); ?></th>
		</tr>
	</thead>

	<tbody>

	<?php
	$k = 0;
	$i = 0;

	foreach( $this->darkperiods as $row )
	{
		$checked 	 = JHTML::_( 'grid.id', $i, $row->id );
		$link 		 = JRoute::_( 'index.php?option='.
		JRequest::getVar( 'option' ) .
																  '&task=edit&cid[]='. $row->id .
																  '&hidemainmenu=1' ); ?>

		<tr class="<?php echo "row$k"; ?>">
			<td><?php echo $row->id; ?></td>
			<td><?php echo $checked; ?></td>
			<td><a href="<?php echo $link; ?>"><?php echo $row->name; ?></a></td>
			<td><?php echo  ($row->busy == 1 ? JText::_('full') : JText::_('partly')); ?></td>
			<td><?php echo JHTML::_('date', $row->start_date, JTEXT::_('Y/m/d')); ?></td>
			<td><?php echo JHTML::_('date', $row->end_date, JTEXT::_('Y/m/d')); ?></td>
			<td><?php echo $row->remarks; ?></td>
		</tr>

		<?php
		$k = 1 - $k;
		$i++;
	} ?>

	</tbody>
	<tfoot>
		<tr>
			<td colspan="6"><?php echo $this->page->getListFooter(); ?></td>
		</tr>
	</tfoot>
</table>

<input type="hidden" name="option"
	value="<?php echo JRequest::getVar( 'option' ); ?>" /> <input
	type="hidden" name="task" value="" /> <input type="hidden"
	name="boxchecked" value="0" /> <input type="hidden" name="hidemainmenu"
	value="0" /> <input type="hidden" name="filter_order"
	value="<?php echo $this->lists['order']; ?>" /> <input type="hidden"
	name="filter_order_Dir" value="" /></form>
