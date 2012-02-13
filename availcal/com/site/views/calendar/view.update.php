<?php
/**
 * Availability Calendar Site view
 *
 * @package    	com_availcal
 * @subpackage 	components
 * @link
 * @license			GNU/GPL
 */
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla view library
jimport('joomla.application.component.view');

/**
 * HTML View class for the AvailCal Component
 * HTML Request View
 */
class AvailcalViewCalendar extends JView
{
	// Overwriting JView display method
	function display($tpl = null)
	{


		//Get current date
		$dateNow = new JDate();
		$currentYear= $dateNow->Format('Y');
		$currentMonth =(int)$dateNow->Format('m');
		//Get request input
		$month = JRequest::getVar( 'month', $currentMonth);
		$year = JRequest::getVar('year', $currentYear);
		$id = JRequest::getVar( 'id');
		$y = JRequest::getVar( 'y');
		//Determin month to display
		if ($month == 13)
		{
			$month = 1;
			$year = $year + 1;
		}
		if ($month == 0)
		{
			if ($year <= $currentYear)	{
				$year =$currentYear;
				$month = 1;
			}else {
				$month = 12;
				$year =$year -1;
			}
		}
		if ($month < $currentMonth AND $year == $currentYear)	{
			$month = $currentMonth;
		}
		$dayofMonth = $dateNow->Format('d');
		$first_of_month = mktime (0,0,0, $month, 1, $year);
		$maxdays   = date('t', $first_of_month);
		$date_info = getdate($first_of_month);
		//Array for the dark periods
		$dark_days = array();
		//Load language file
		$language = JFactory::getLanguage();
		$language->load('plg_content_availcal', JPATH_ADMINISTRATOR, null, true);
		$month_name = JTEXT::_('month_'.$month);
		$week_firstday = JRequest::getVar('week_firstday', 0);

		//Get dark periods
		$items = $this->get('Items');
		$calendar = "";
			
		foreach ($items as $i => $item)
		{
			$dark_days[$i]['start'] = $item->start_date;
			$dark_days[$i]['end'] = $item->end_date;
			$dark_days[$i]['busy'] = $item->busy;
		}

		$calendar  .="<table class=\"cal_main\" celpadding=\"2\" cellspacing=\"1\">";
		$calendar .= '<tr>';
		if ($week_firstday == 0) {
			$weekday = $date_info['wday'];
		}
		else {
			$weekday = $date_info['wday'] - 1;
			if ($weekday == -1)	{
				$weekday = 6;
			}
		}
		$day = 1;
		if($weekday > 0){
			$calendar .= "<td colspan=\"$weekday\">&nbsp;</td>\n";
		}
		$teller = 0;

		while ($day <= $maxdays){

			if($weekday == 7){
				$calendar .= "</tr>\n<tr>";
				$weekday = 0;
				$teller++;
			}

			$linkDate =  mktime (0,0,0, $month, $day, $year);
			if (($day == $dayofMonth) and ($year == $currentYear) and ($month == $currentMonth)){
				$class='cal_today';
			} else {
				$d = date('m/d/Y', $linkDate);
				$darken = 3;
				foreach($dark_days as $dark){

					if( ($linkDate <= $dark['end']) and ($linkDate >= $dark['start']) ){
						$darken = $dark['busy']	;
					}
				}

				if ($darken == '1'){
					$class = 'cal_post';
					$darken = 3;
				} elseif ($darken == '0'){
					$class = 'cal_part';
					$darken = 3;
				} else {
					$class = 'cal_empty';
					$darken = 3;
				}
			}
			$calendar .= "<td class=\"$class\">$day<br /></td>\n";
			$day++;
			$weekday++;
		}
			
		if($weekday != 7){
			$calendar .= '<td colspan="' . (7 - $weekday) . '">&nbsp;</td>';
		}
		$space = " &nbsp; ";
		$calendar .= "</tr>\n";
		if ($teller < 5)	{
			$calendar .= "<tr><td colspan=\"7\">". $space . "</td></tr>";
		}
		$calendar .= "<tr><td class=\"cal_post\">". $space . "</td> <td colspan=\"2\">"
		. JTEXT::_('BUSY') ."</td>
		<td class=\"cal_part\">". $space . "</td><td colspan=\"3\">"
		. JTEXT::_('PART') ."</td>
		</tr>\n";

		$calendar .= "</table>\n";//End class table_pos
		//$functionpar = $month . ", " . $month_name . ", " . $year;
		$calendar .= "<script type = \"text/javascript\">updatemonth($month ,'$month_name' , $year , '$id' );</script>";

		echo $calendar;

	}
}
