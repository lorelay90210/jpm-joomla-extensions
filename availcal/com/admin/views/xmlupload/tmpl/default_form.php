<?php // no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); ?>


<form enctype="multipart/form-data" action="index.php" method="post" name=xmluploadForm">

	<?php if ($this->ftp) : ?>
		<?php echo $this->loadTemplate('ftp'); ?>
	<?php endif; ?>

	<table class="adminform">
	<tr>
		<th colspan="2"><?php echo JText::_( 'Upload_XML_File' ); ?></th>
	</tr>
	<tr>
		<td width="120">
			<label for="xmluploadfile"><?php echo JText::_( 'XML_File' ); ?>:</label>
		</td>
		<td>
			<input class="input_box" id="xmlupload" name="xmlupload" type="file" size="57" />
			<input class="submit" type="submit" value="<?php echo JText::_( 'Upload_File' ); ?> "  />
		</td>
	</tr>
	</table>

	
	<input type="hidden" name="task" value="readfile" />
	<input type="hidden" name="option" value="com_availcal" />	
</form>