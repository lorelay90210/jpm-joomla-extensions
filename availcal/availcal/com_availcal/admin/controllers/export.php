<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla controllerform library
jimport('joomla.application.component.controlleradmin');

/**
 * XML Export Controller
 */
class AvailCalControllerExport extends JControllerAdmin
{

	public function export()
	{
		// Check for request forgeries
		JRequest::checkToken() or die(JText::_('JINVALID_TOKEN'));
		// Get items to remove from the request.
		$cid	= JRequest::getVar('cid', array(), '', 'array');
		if (!is_array($cid) || count($cid) < 1) {
			JError::raiseWarning(500, JText::_($this->text_prefix.'_NO_ITEM_SELECTED'));
		} else {

			// Make sure the item ids are integers
			jimport('joomla.utilities.arrayhelper');
			JArrayHelper::toInteger($cid);


			// Get the model.
			$model = $this->getModel('export');
			$items = $model->getItems($cid);
			//Set filename
			$filename = "availcalexport.xml";
			foreach ($items as $item) {
				$test = $item[name];
				$objects[$item[name]][] =Array('busy' => $item[busy],
												'start_date' => $item[start_date],
												'end_date' => $item[end_date],
												'remarks' => $item[remarks]);
			}
			//Generate xml output
			// Output XML header.
			$output =  '<?xml version="1.0" encoding="UTF-8" ?>' . "\n";

			// Output root element.
			$output .=  '<objects>'."\n";
				//Output objects
				foreach ($objects as  $key => $value) {
					$output .= "\t" . '<object name="' . $key .'">' . "\n";
						foreach ($value as $key2 => $darkperiod)
						{
							$output .= "\t\t" . '<darkperiod>' . "\n";
							$output .= "\t\t\t" . '<startdate>' . $darkperiod[start_date] . '</startdate>' . "\n" ;
							$output .= "\t\t\t" . '<enddate>' . $darkperiod[end_date] . '</enddate>' . "\n" ;
							$output .= "\t\t\t" . '<busy>' . $darkperiod[busy] . '</busy>' . "\n" ;
							$output .= "\t\t\t" . '<remark>' . $darkperiod[remarks] . '</remark>' . "\n" ;
							$output .= "\t\t" . '</darkperiod>' . "\n";
						}
					
					$output .= "\t". '</object>' . "\n";
				}
			
			// Terminate root element.
			$output .=  '</objects>'."\n";

			// activate download
			$mimeType = 'text/x-csv';
			header( 'Content-Disposition: attachment; filename=' . $filename );
			header( 'Content-Transfer-Encoding: UTF-8' );
			header( 'Content-Type: ' . $mimeType );

			/* Make the download non-cacheable. */
			header( 'Expires: ' . gmdate('D, d M Y H:i:s') . ' GMT' );
			header( 'Cache-control: private' );
			header( 'Pragma: private' );

			echo $output;
			flush();
			$app = JFactory::getApplication();
			$app->close();
		}
	}

}


