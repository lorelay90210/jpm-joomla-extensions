<?php
/**
 * Availability Calendar Administrator xmlUpload model
 *
 * @package    	com_availcal
 * @subpackage 	components
 * @link
 * @license			GNU/GPL
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// Import the JModel class
jimport( 'joomla.application.component.model' );
// joomla  date utilities
jimport('joomla.utilities.date');

/**
 *  Availability Calendar xmlUpload Model
 *
 * 	@package    	com_availcal
 * 	@subpackage 	components
 */
class AvailcalModelXmlupload extends JModel
{
	/**
	 *	Method to upload a XML file
	 *
	 *	@access public
	 *	@return object
	 */
	function readfile()
	{
		//Retrieve file details from uploaded file, sent from upload form
		$file = JRequest::getVar('xmlupload', null, 'files', 'array');

		//Import filesystem libraries. Perhaps not necessary, but does not hurt
		jimport('joomla.filesystem.file');

		//Clean up filename to get rid of strange characters like spaces etc
		$filename = JFile::makeSafe($file['name']);

		//Set up the source and destination of the file
		$src = $file['tmp_name'];
		$dest = JPATH_ROOT . DS . "tmp" . DS . $filename;
		if ( strtolower(JFile::getExt($filename) ) == 'xml') {
			if ( JFile::upload($src, $dest) ) {
				return $dest;
			} else {
				return false;
			}
		} else {
			return false;
		}
			
			
		return true;
	}
	/**
	 *
	 * Method to convert XML file
	 *
	 * @access public
	 *	@return object
	 */
	function convertXml($dest)
	{
		$parser =& JFactory:: getXMLParser('Simple');
		$parser->loadFile($dest);
		$document =& $parser->document;
		if ($document->name() != 'objects')
		{
			$this->errorCode = JText::_( 'WRONG XML' );
			return false;
		}
		$objects =& $document->object;
		for ($i=0, $c = count($objects); $i<$c; $i++ )
		{
			//get object
			$object =& $objects[$i];
			//get name of object
			$name =& $object->attributes('name');
			//get darkperiod
			$darkperiods =& $object->darkperiod;
			for ($ii=0, $cc= count($darkperiods); $ii<$cc; $ii++)
			{
				$darkperiod =& $darkperiods[$ii];
				if ($busy =& $darkperiod->getElementByPath('busy'))
				{
					if ($busy->data() < 2)
					{
						if ($startdate =& $darkperiod->getElementByPath('startdate'))
						{
							if ($enddate =& $darkperiod->getElementByPath('enddate'))
							{
								$table =& $this->getTable(darkperiod);
								$start_date = new JDate($startdate->data());
								$end_date = new  JDate($enddate->data());
									
								$record['name'] = $name;
								$record['start_date'] = $start_date->toMySQL();
								$record['end_date'] = $end_date->toMySQL();
								$record['busy'] = $busy->data();
								if ($remark =& $darkperiod->getElementByPath('remark'))
								{
									$record['remarks'] = $remark->data();
								}
								$table->reset();
								// Bind the data to the table
								if( !$table->bind($record))
								{
									$this->setError( $this->_db->getErrorMsg());
									return false;
								}

								// Validate the data
								if( !$table->check())
								{
									$this->setError( $this->_db->getErrorMsg());
									return false;
								}

								// Store the revue
								if( !$table->store())
								{
									// An error occurred, update the model error message
									$this->setError( $table->getErrorMsg());
									return false;
								}
							}
						}
					}
				}
			}
		}

		return TRUE;
	}
	function deleteFile($dest)	
	{
		if (JFile::delete($dest))	{
			return true;		
		} else {
			return false;
		}		
	}
}

