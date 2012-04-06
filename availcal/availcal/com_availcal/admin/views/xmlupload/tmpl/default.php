<?php // no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); ?>
<script type="text/javascript">
	submitbutton = function(pressbutton) {
		var form = document.getElementById('xmluploadForm');

		// do field validation
		if (form.xmlupload.value == ""){
			alert("<?php echo JText::_('COM_AVAILCAL_PLEASE_SELECT_A_FILE', true); ?>");
		} else {			
			form.submit();
		}
	}
</script>
<form name="xmluploadForm" id="xmluploadForm" method="post" action="<?php echo JRoute::_('index.php?option=com_availcal&view=xmlupload');?>"
	enctype="multipart/form-data"
	>
	
	<?php echo JText::_('UPLOAD_XML_FILE'); ?>
	<input type="file" name="xmlupload"  id="xmlupload" size="57" id="xmlupload"/> 
	<input class="button" type="button" value="<?php echo JText::_('COM_AVAILCAL_UPLOAD_FILE'); ?>" onclick="submitbutton()" />
		
	<input type="hidden" name="type" value="" />	
	<input type="hidden" name="task" value="xmlupload.readfile" />
	<?php echo JHtml::_('form.token'); ?>
</form>
