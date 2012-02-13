<?php
/**
 * Avalilability Calendar Plugin
 *
 * Author			: Jan Maat
 * Date				: 20 october 2010
 * email			: jan.maat@hetnet.nl
 * copyright		: Jan Maat 2010
 * 1.6 migration    : Jan Maat, Pedro Manuel Baeza
 * Migration date	: 8 september 2011
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
		$this->loadLanguage();
	}
	/**
	 *  Handle onPrepareAvailcal
	 *
	 */

	public function onContentPrepare($context, &$article, &$params, $page = 0 ) {

		// just startup
		$mainframe = JFactory::getApplication();

		// Only render in the HTML format
		$document	= JFactory::getDocument();
		$type		= $document->getType();
		$html		= ( $type == 'html' );
		$text       = &$article->text;

		//include css file
		$css = JURI::base(). 'administrator/components/com_availcal/assets/plg_css.css';
		$document->addStyleSheet($css);

		// Check if the Availcal Component is installed and enabled
		$enabled	= JComponentHelper::isEnabled('com_availcal', true);

		// Should we proceed
		if ( ! $enabled || ! $html) {
			// Remove any availcal tags from the content
			$article->text = preg_replace( $this->_regex1, '', $article->text );
			return true;
		}




		// find all instances of plugin and put in $matches
		preg_match_all( $this->_regex1, $article->text, $declarations );

		// Return if there are no matches
		if ( ! count($declarations[0]) ) {
			return true;
		}


		JPlugin::loadLanguage('plg_content_availcal', JPATH_ADMINISTRATOR);

		//Get the params
		$nbr_months = $this->params->def('nbr_months', 1);
		$week_firstday = $this->params->def('week_firstday', 0);
		$one_month_display = $this->params->def('one_month_display', 0);

		//Get current date
		$dateNow = JFactory::getDate();
		$currentYear = $dateNow->Format('Y');		 
		$currentMonth = (int)$dateNow->Format('m');		 
		$dayofMonth = $dateNow->Format('d');

		//Array for the dark periods
		$dark_days = array();

		//Get the database
		$db =& JFactory::getDBO();


		//Loop to place the replacement of all matches
		foreach ( $declarations[0] as $x => $declaration )
		{
			/*
			if (($one_month_display == 1) AND ($x > 0))
			{
				$article->text = preg_replace( $this->_regex1, '', $article->text );
				break;
			}
			*/
			preg_match_all( $this->_regex2, $declaration, $matches );
			$calendar = '';

			// Get the query id
			if (  $name	= $matches[1][0]  ) {
				$regex3 = '/' . $matches[0][0] . '/';
				$namearray[$x] = $name;								
				$month = $currentMonth;
				$year = $currentYear;

				//Get Darkperiods
				$query = 'SELECT unix_timestamp(start_date),unix_timestamp(end_date),busy FROM' . $db->nameQuote('#__avail_calendar'). 'WHERE' . $db->nameQuote('name') . ' = ' . $db->Quote($name) ;
				$db->setQuery($query);
				$db->query();

				//Check of object has one or more darkperiods				
				$dark_days = array();
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
				$nbr_months = ($one_month_display == 1) ? 1 :$nbr_months ;
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
					if ($one_month_display == 0)
					{
						$calendar .= "<tr class=\"cal_title\"><th colspan=\"7\" class=\"cal_month\">$month_name, $year</th></tr>\n";
					} else
					{
						$calendar .= "<div class=\"hidden\"><div id=\"m$name\">$month</div></div>
										<tr class=\"cal_title\">
										<th><a href=\"#\" id=\"makeRequest$x\"><&nbsp;</a></th>
										<th colspan=\"5\" class=\"cal_month\"><div id=\"$name\">$month_name</div><div id=\"y$name\">$year</div></th>		
										<th><a href=\"#\" id=\"makeRequest2$x\">>&nbsp;</a></th></tr>\n";
					}

					if ($week_firstday == 0) {
						$calendar .= "<tr class=\"cal_days\"><td>".JTEXT::_('zo'). "</td><td>".JTEXT::_('ma'). "</td><td>".JTEXT::_('di'). "</td><td>".JTEXT::_('wo'). "</td><td>".JTEXT::_('do'). "</td><td>".JTEXT::_('vr'). "</td><td>".JTEXT::_('za'). "</td></tr>\n";
						$weekday = $date_info['wday'];
					}
					else {
						$calendar .= "<tr class=\"cal_days\"><td>".JTEXT::_('ma'). "</td><td>".JTEXT::_('di'). "</td><td>".JTEXT::_('wo'). "</td><td>".JTEXT::_('do'). "</td><td>".JTEXT::_('vr'). "</td><td>".JTEXT::_('za'). "</td><td>".JTEXT::_('zo'). "</td></tr>\n";
						$weekday = $date_info['wday'] - 1;
						if ($weekday == -1)	{
							$weekday = 6;
						}
					}
					if ($one_month_display == 1)
					{
						$calendar .= "</table><div id=\"result$x\"><table class=\"cal_main\" celpadding=\"2\" cellspacing=\"1\">";
					}
					$calendar .= '<tr>';
					//$weekday = $date_info['wday'];
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

								$calendar .= "</table></div>\n";//End class table_pos
				}
				if ($one_month_display == 1)
				{
					$calendar .= "</div>";
				}
				$calendar .= "</div>";//End class availcal

				//replace the calendar data
				$article->text = preg_replace( $regex3, $calendar, $article->text );


			}else {
				$article->text = preg_replace( $this->_regex1, '', $article->text );
			}
		} // end foreach
		// add mootools
		JHTML::_('behavior.mootools');
		$uri = JFactory::getURI();
		$path = $uri->getPath();
		$js .="
		
		var year = 0;	
		var month = 0;
		"; 
		
		$js .="
		var week_firstday	 = '" . $week_firstday ."';		
		window.addEvent('domready', function(){";
	foreach ( $namearray as $y => $id ) { 
		$js .= "		
	    $('makeRequest$y').addEvent('click', function(event){
	        event.stop();
	        var id  = '" . $id . "';
	        month =   document.getElementById('m' + id).innerHTML ;
	        month--;
	        year = document.getElementById('y' + id).innerHTML;
	        var req  = 	new Request.HTML({
						url: 'index.php',        
			        	method: 'get', 
			        	
			            onComplete: function(response){
			                $('result$y').empty().adopt(response);
			            }            
			        })				
	        req.send('option=com_availcal&format=update&id=' + id + '&month=' + month + '&year=' + year + '&week_firstday=' + week_firstday);
	    });
		
	    $('makeRequest2$y').addEvent('click', function(event){
	       event.stop();
	       var id  = '" . $id . "';	
	       month =   document.getElementById('m' + id).innerHTML ;
	       month++;
	       year = document.getElementById('y' + id).innerHTML ;
	       
	       var req  = 	new Request.HTML({
						url: 'index.php',        
			        	method: 'get', 
			        	
			            onComplete: function(response){
			                $('result$y').empty().adopt(response);
			            }            
			        })			       
	       req.send('option=com_availcal&format=update&id=' + id + '&month=' + month + '&year=' + year + '&week_firstday=' + week_firstday);
	    });
	    ";
	 }  
	 $js .= "	
		});
		function updatemonth (month, monthname, xx, id){
							
		document.getElementById(id).innerHTML = monthname;
		document.getElementById('y' + id).innerHTML = xx ;
		document.getElementById('m' + id).innerHTML = month ;
		
		}
		";

		// add JavaScript to the page
		$document->addScriptDeclaration($js);
	}
}

?>
