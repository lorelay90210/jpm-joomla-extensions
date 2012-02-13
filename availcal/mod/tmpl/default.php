<?php
/**
 * @version		$Id: default.php 21322 2011-05-11 01:10:29Z dextercowley $
 * @package		Joomla.Site
 * @subpackage	mod_login
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
JHtml::_('behavior.keepalive');
//include css file
$document = JFactory::getDocument();
$document->addStyleSheet( JURI::base().'administrator/components/com_availcal/assets/plg_css.css' );
//Get parameters
$name = $params->get('name');
$week_firstday = $params->get('week_firstday', 0);
//Get current date
$dateNow = new JDate();
$currentYear = $dateNow->Format('Y');
$currentMonth = (int)$dateNow->Format('m');
$dayofMonth = $dateNow->Format('d');
$month = $currentMonth;
$year = $currentYear;
$month_name = JTEXT::_('month_'.$month);
$first_of_month = mktime (0,0,0, $month, 1, $year);
$maxdays   = date('t', $first_of_month);
$date_info = getdate($first_of_month);
$space = "&nbsp; ";
?>
<div class="availcal">
	<div class="table_pos">
		<table class="cal_main" celpadding="2" cellspacing="0">
			<tr class=\"cal_title\">
				<th><a href="#" id="makeRequest"><&nbsp;</a></th>
				<th colspan="5" class="cal_month"><div id="header">
				<?php echo $month_name ." , " . $year?>
					</div></th>
				<th><a href="#" id="makeRequest2">>&nbsp;</a></th>
			</tr>
			<?php if ($week_firstday == 0) :?>
			<tr class="cal_days">
				<td><?php echo JTEXT::_('zo')?></td>
				<td><?php echo JTEXT::_('ma')?></td>
				<td><?php echo JTEXT::_('di')?></td>
				<td><?php echo JTEXT::_('wo')?></td>
				<td><?php echo JTEXT::_('do')?></td>
				<td><?php echo JTEXT::_('vr')?></td>
				<td><?php echo JTEXT::_('za')?></td>
			</tr>
			<?php $weekday = $date_info['wday'];?>
			<?php else : ?>
			<tr class="cal_days">
				<td><?php echo JTEXT::_('ma')?></td>
				<td><?php echo JTEXT::_('di')?></td>
				<td><?php echo JTEXT::_('wo')?></td>
				<td><?php echo JTEXT::_('do')?></td>
				<td><?php echo JTEXT::_('vr')?></td>
				<td><?php echo JTEXT::_('za')?></td>
				<td><?php echo JTEXT::_('zo')?></td>
			</tr>

			<?php $weekday = $date_info['wday'] - 1;?>
			<?php endif;?>
		</table>
	</div>
	<div id="result">
		<table class="cal_main" celpadding="2" cellspacing="1">
			<tr>
			<?php
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
			?>
			<?php if($weekday > 0): ?>
				<td colspan="<?php echo $weekday ;?>">&nbsp;</td>
				<?php endif; ?>
				<?php $teller = 0;?>
				<?php while ($day <= $maxdays): ?>
				<?php if($weekday == 7): ?>
			</tr>
			<tr>
			<?php
			$weekday = 0;
			$teller++;
			?>
			<?php endif;?>
			<?php
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
			?>
				<td class="<?php echo $class;?>"><?php echo $day;?><br /></td>
				<?php
				$day++;
				$weekday++;
				?>
				<?php endwhile; ?>
				<?php if($weekday != 7): ?>

				<td colspan="<?php echo (7 - $weekday) ;?>">&nbsp;</td>
				<?php endif;?>
			</tr>
			<?php if ($teller < 5)	: ?>
			<tr>
				<td colspan="7"><?php echo $space ; ?></td>
			</tr>
			<?php endif; ?>

			<tr>
				<td class="cal_post"><?php echo $space ; ?></td>
				<td colspan="2"><?php echo JTEXT::_('BUSY') ; ?></td>
				<td class="cal_part"><?php echo  $space ; ?></td>
				<td colspan="3"><?php echo JTEXT::_('PART') ; ?></td>
			</tr>


			<?php	$functionpar = $month . ", " . $month_name . ", " . $year; ?>
			<script type="text/javascript">updatemonth(<?php echo ($month . ", '" . $month_name . "' ," . $year);?> )</script>


		</table>
	</div>
</div>
			<?php
			// add mootools
			JHTML::_('behavior.mootools');
			$js = "
		var id  = '" . $name . "';		
		var monthplus = '" . $monthplus ."';
		var monthmin = '" . $monthmin ."';
		var year = '" . $year ."';
		var week_firstday	 = '" . $week_firstday ."';	
		
	window.addEvent('domready', function(){
	var req  = 	new Request.HTML({
					url: 'index.php',        
		        	method: 'get', 
		        	data: {
		        	    option: 'com_availcal'
		        	    },  
		            onComplete: function(response){
		                $('result').empty().adopt(response);
		            }            
		        })		

    $('makeRequest').addEvent('click', function(event){
        event.stop();		
        req.send('option=com_availcal&format=update&id=' + id + '&month=' + monthmin + '&year=' + year + '&week_firstday=' + week_firstday);
    });
	
    $('makeRequest2').addEvent('click', function(event){
       event.stop();	       
       req.send('option=com_availcal&format=update&id=' + id + '&month=' + monthplus + '&year=' + year + '&week_firstday=' + week_firstday);
    });
    
	});
		function updatemonth (month, monthname, xx){		
		monthmin = month - 1;
		monthplus = month +1;	
		year = xx;	
		header = monthname + ' , ' + year;			
		document.getElementById('header').innerHTML = header;
		
		}
		";

			// add JavaScript to the page
			$document->addScriptDeclaration($js);


			?>