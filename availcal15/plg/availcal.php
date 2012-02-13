<?php
/**
 * Avalilability Calendar Plugin
 *
 * Author			:Jan Maat
 * Date				: 20 october 2010
 * email			: jan.maat@hetnet.nl
 * copyright		: Jan Maat 2010
 * @license			: GNU/GPL
 * Description		: Displays the availability Calendar in an article on the position {availcal="name"}
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// Import the JPlugin class
jimport('joomla.event.plugin');

/**
 *  Availability Calendar event listener
 *
 */
class plgContentAvailcal extends JPlugin
{
	/**
	 * The regular expression used to detect if LQM has been embedded into the article
	 *
	 * @var		string Regular Expression
	 * @access	protected
	 * @since	1.0
	 */
	protected $_regex1	= '/{availcal.*?}/i';
	/**
	 * The regular expression used to parse the argument
	 *
	 * @var		string Regular Expression
	 * @access	protected
	 * @since	1.0
	 */
	protected $_regex2	= '/{availcal="(.+)"}/i';

	//Constructor
	function plgContentAvailcal( &$subject, $params  )
	{
		parent::__construct( $subject, $params  );


	}
	/**
	 *  Handle onPrepareAvailcal
	 *
	 */

	function onPrepareContent(&$row, &$params, $page) {

		// just startup
		global $mainframe;

		// Only render in the HTML format
		$document	= JFactory::getDocument();
		$type		= $document->getType();
		$html		= ( $type == 'html' );

		//include css file
		$css = JURI::base(). 'administrator/components/com_availcal/assets/plg_css.css';
		$document->addStyleSheet($css);

		// Check if the Availcal Component is installed and enabled
		$enabled	= JComponentHelper::isEnabled('com_availcal', true);

		// Should we proceed
		if ( ! $enabled || ! $html) {
			// Remove any availcal tags from the content
			$row->text = preg_replace( $this->_regex1, '', $row->text );
			return true;
		}



		// find all instances of plugin and put in $matches
		preg_match_all( $this->_regex1, $row->text, $declarations );

		// Return if there are no matches
		if ( ! count($declarations[0]) ) {
			return true;
		}
		JPlugin::loadLanguage('plg_content_availcal', JPATH_ADMINISTRATOR);

		//Get the params
		$nbr_months = $this->params->get('nbr_months');



		

		//Array for the dark periods
		$dark_days = array();

		//Get the database
		$db =& JFactory::getDBO();


		//Loop to place the replacement of all matches
		foreach ( $declarations[0] as $declaration )
		{

			//Get current date
			$dateNow = JFactory::getDate();
			$year = $dateNow->toFormat('%Y');
			$currentYear = $year;
			$month = (int)$dateNow->toFormat('%m');
			$currentMonth = $month;
			$dayofMonth = $dateNow->toFormat('%d');

		
			preg_match_all( $this->_regex2, $declaration, $matches );
			$calendar = '';

			// Get the query id
			if (  $name	= $matches[1][0]  ) {
				$regex3 = '/' . $matches[0][0] . '/';



				//Get Darkperiods
				$query = 'SELECT unix_timestamp(start_date),unix_timestamp(end_date),busy FROM' . $db->nameQuote('#__avail_calendar'). 'WHERE' . $db->nameQuote('name') . ' = ' . $db->Quote($name) ;
				$db->setQuery($query);
				$db->query();

				//Check of object has one or more darkperiods
				if ($num_rows = $db->getNumRows()	){
					$counter = 0;
					$line = $db->loadAssocList();
					while ($counter < $num_rows )
					{
						$dark_days[$counter]['start'] = $line[$counter]['unix_timestamp(start_date)'];
						$dark_days[$counter]['end'] = $line[$counter]['unix_timestamp(end_date)'];
						$dark_days[$counter]['busy'] = $line[$counter]['busy'];
						$counter++;
					}
				}
				$calendar	= "<div class=\"availcal\">";

				for ($i=0; $i < $nbr_months; $i++, $month++)	{
					if ($month ==13)	{
						$month = 1;
						$year++;
					}
					$month_name = JTEXT::_('month_'.$month);
					$first_of_month = mktime (0,0,0, $month, 1, $year);
					$maxdays   = date('t', $first_of_month);
					$date_info = getdate($first_of_month);
					$calendar  .="<div class=\"table_pos\">";
					$calendar  .= "<table class=\"cal_main\"  celpadding=\"2\" cellspacing=\"0\"  >\n";
					$calendar .= "<tr class=\"cal_title\"><th colspan=\"7\" class=\"cal_month\">$month_name, $year</th></tr>\n";
					$calendar .= "<tr class=\"cal_days\"><td>".JTEXT::_('zo'). "</td><td>".JTEXT::_('ma'). "</td><td>".JTEXT::_('di'). "</td><td>".JTEXT::_('wo'). "</td><td>".JTEXT::_('do'). "</td><td>".JTEXT::_('vr'). "</td><td>".JTEXT::_('za'). "</td></tr>\n";
					$calendar .= '<tr>';
					$weekday = $date_info['wday'];
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
							}
						}
						$calendar .= "<td class=\"$class\">$day<br /></td>\n";
						$day++;
						$weekday++;
					}
					if($weekday != 7){
						$calendar .= '<td colspan="' . (7 - $weekday) . '">&nbsp;</td>';
					}
					$calendar .= "</tr>\n";
					if ($teller < 5)	{
						$calendar .= "<tr><td colspan=\"7\"> &nbsp</td></tr>";
					}
					$calendar .= "<tr><td class=\"cal_post\">$nbsp</td> <td colspan=\"2\">"
					. JTEXT::_('BUSY') ."</td>
								<td class=\"cal_part\">$nbsp</td><td colspan=\"3\">"
					. JTEXT::_('PART') ."</td>
								</tr>\n";

					$calendar .= "</table></div>\n";//End class table_pos
				}
				$calendar .= "</div>";//End class availcal

				//replace the calendar data
				$row->text = preg_replace( $regex3, $calendar, $row->text );


			}else {
				$row->text = preg_replace( $this->_regex1, '', $row->text );
			}
		} // end foreach
	}
}
?>
