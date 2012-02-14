<?php
/**
 * 	Availabiltiy Calendar Component Administrator Darkperiod View
 *
 * 	@package    	com_availcal
 * 	@subpackage 	components
 * 	@link
 * 	@license			GNU/GPL
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

//enable tooltips
JHTML::_('behavior.tooltip');
?>


<script language="javascript" type="text/javascript">
	Joomla.submitbutton = function(pressbutton) {
		var form = document.adminForm;
		var re = /\//g;
		if (pressbutton == 'cancel') {
			submitform( pressbutton );
			return;
		}

		// do field validation
		if (form.name.value == ""){
			alert( "<?php echo JText::_( 'NO_NAME', true ); ?>" );
		} else if (form.end_date.value.replace( re,'') < form.start_date.value.replace( re,'')){
			alert( "<?php echo JText::_( 'END_DATE', true ); ?>" );
		} else {
			submitform( pressbutton );
		}
	}
</script>

<form action="index.php" method="post" name="adminForm" id="adminForm">

<div class="col100">

<fieldset class="adminform"><legend><?php echo JText::_( 'Details' ); ?></legend>

<table class="admintable">

	<tr>
		<td width="100" align="right" class="key"><span
			class="editlinktip hasTip"
			title="<?php  echo JText::_(TITLE_TIP_001) ?>::<?php echo JText::_(TIP_001)?>"
			style="text-decoration: none; color: #333;"> <label for="title"><?php echo JText::_( 'NAAM' ); ?>:</label>
		</span></td>
		<td><input class="inputbox" type="text" name="name" id="name"
			size="25" value="<?php echo $this->darkperiod->name;?>" /></td>
	</tr>
	<tr>
		<td width="100" align="right" class="key"><span
			class="editlinktip hasTip"
			title="<?php  echo JText::_(TITLE_TIP_005) ?>::<?php echo JText::_(TIP_005)?>"
			style="text-decoration: none; color: #333;"> <label for="title"><?php echo JText::_( 'BUSY' ); ?>:</label>
		</span></td>
		<td>
		<?php
		$options = array();		
		$options[] = JHTML::_('select.option', '1', JText::_('FULL') );	
		$options[] = JHTML::_('select.option', '0', JText::_('PARTLY'));		
		echo JHTML::_('select.genericlist', $options, 'busy', null, 'value', 'text', $this->darkperiod->busy)	;?></td>

	</tr>



	<tr>
		<td width="100" align="right" class="key"><span
			class="editlinktip hasTip"
			title="<?php  echo JText::_(TITLE_TIP_002) ?>::<?php echo JText::_(TIP_002)?>"
			style="text-decoration: none; color: #333;"> <label for="start_date"><?php echo JText::_( 'START_DATUM' ); ?>:</label>
		</span></td>
		<td><?php 
		echo JHTML::_('calendar',
		JHTML::_('date', $this->darkperiod->start_date, JTEXT::_('Y/m/d')),
											'start_date', 
											'start_date', 
											'%Y/%m/%d', 
		array('class'=>'inputbox',
														'size'=>'25', 
														'maxlength'=>'19' ) ); 
		?></td>
	</tr>
	<tr>
		<td width="100" align="right" class="key"><span
			class="editlinktip hasTip"
			title="<?php  echo JText::_(TITLE_TIP_003) ?>::<?php echo JText::_(TIP_003)?>"
			style="text-decoration: none; color: #333;"> <label for="end_date"><?php echo JText::_( 'EIND_DATUM' ); ?>:</label></span></td>
		<td><?php 
		echo JHTML::_('calendar',
		JHTML::_('date', $this->darkperiod->end_date, JTEXT::_('Y/m/d')),
														'end_date', 
														'end_date', 
														'%Y/%m/%d', 
		array('class'=>'inputbox',
																	'size'=>'25', 
																	'maxlength'=>'19' ) );
		?></td>
	</tr>

	<tr>
		<td width="100" align="right" class="key"><span
			class="editlinktip hasTip"
			title="<?php  echo JText::_(TITLE_TIP_004) ?>::<?php echo JText::_(TIP_004)?>"
			style="text-decoration: none; color: #333;"> <label for="remarks"><?php echo JText::_( 'OPMERKING' ); ?>:</label></span></td>
		<td><input class="text_area" type="text" name="remarks" id="remarks"
			size="50" maxlength="250"
			value="<?php echo $this->darkperiod->remarks;?>" /></td>
	</tr>



</table>

</fieldset>

</div>

<div class="clr"></div>

<input type="hidden" name="option"
	value="<?php echo JRequest::getVar( 'option' ); ?>" /> <input
	type="hidden" name="id" value="<?php echo $this->darkperiod->id; ?>" />
<input type="hidden" name="task" value="" /></form>
