<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla controllerform library
jimport('joomla.application.component.controllerform');

/**
 * Accommodation Controller
 */
class AvailCalControllerXmlUpload extends JController
{
	
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


