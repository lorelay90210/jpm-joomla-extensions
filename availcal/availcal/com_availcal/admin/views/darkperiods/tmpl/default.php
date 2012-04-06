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
defined('_JEXEC') or die('Restricted access');
// load tooltip behavior
JHtml::_('behavior.tooltip');
JHtml::_('behavior.multiselect');

$listOrder	= $this->escape($this->state->get('list.ordering'));
$listDirn	= $this->escape($this->state->get('list.direction'));
?>
<form
	action="<?php echo JRoute::_('index.php?option=com_availcal&view=darkperiods'); ?>"
	method="post" name="adminForm" id="adminForm">
	<fieldset id="filter-bar">
		<div class="filter-search fltlft">
			<label class="filter-search-lbl" for="filter_search"><?php echo JText::_('JSEARCH_FILTER_LABEL'); ?>
			</label> <input type="text" name="filter_search" id="filter_search"
				value="<?php echo $this->escape($this->state->get('filter.search')); ?>"
				title="<?php echo JText::_('COM_CONTENT_FILTER_SEARCH_DESC'); ?>" />

			<button type="submit" class="btn">
			<?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?>
			</button>
			<button type="button"
				onclick="document.id('filter_search').value='';this.form.submit();">
				<?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?>
			</button>
		</div>
	</fieldset>
	<div class="clr"></div>
	<table class="adminlist">		
		<thead>
			<tr>

				<th width="20"><input type="checkbox" name="checkall-toggle"
					value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>"
					onclick="Joomla.checkAll(this)" />
				</th>
				<th width="100"><?php echo JHtml::_('grid.sort', 'NAAM', 'a.name', $listDirn, $listOrder); ?>
				</th>
				<th><?php echo JHtml::_('grid.sort', 'BUSY', 'a.busy', $listDirn, $listOrder); ?>
				</th>
				<th><?php echo JHtml::_('grid.sort', 'START_DATUM', 'a.start_date', $listDirn, $listOrder); ?>
				</th>
				<th><?php echo JHtml::_('grid.sort', 'END_DATUM', 'a.end_date', $listDirn, $listOrder); ?>
				</th>				
				<th><?php echo JText::_('OPMERKING'); ?>
				</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="6"><?php echo $this->pagination->getListFooter(); ?></td>
			</tr>

		</tfoot>

		<tbody>
		<?php foreach($this->items as $i => $item): ?>
			<tr class="row<?php echo $i % 2; ?>">
				<td><?php echo JHtml::_('grid.id', $i, $item->id); ?>
				</td>
				<td><?php echo $item->name; ?>
				</td>
				<td><?php echo  ($item->busy == 1 ? JText::_('full') : JText::_('partly')); ?>
				</td>
				<td><?php echo JHTML::_('date', $item->start_date, JTEXT::_('Y/m/d')); ?>
				</td>
				<td><?php echo JHTML::_('date', $item->end_date, JTEXT::_('Y/m/d')); ?>
				</td>				
				<td><?php echo $item->remarks; ?>
				</td>

			</tr>
			<?php endforeach; ?>

		</tbody>

	</table>

	<div>
		<input type="hidden" name="task" value="" /> <input type="hidden"
			name="boxchecked" value="0" /> <input type="hidden"
			name="darkperiods" value="1" /> <input type="hidden"
			name="filter_order" value="<?php echo $listOrder; ?>" /> <input
			type="hidden" name="filter_order_Dir"
			value="<?php echo $listDirn; ?>" />
			<?php echo JHtml::_('form.token'); ?>
	</div>
</form>
