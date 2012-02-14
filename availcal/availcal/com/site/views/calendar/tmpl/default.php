<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php
$id = 'p0101a';


$mainframe = JFactory::getApplication();

// Only render in the HTML format
$document	= JFactory::getDocument();
//include css file
$css = JURI::base(). 'administrator/components/com_availcal/assets/plg_css.css';
$document->addStyleSheet($css);


//Get current date
$dateNow = new JDate();
$year = $dateNow->Format('Y');
$currentYear = $year;
$currentMonth =(int)$dateNow->Format('m');
$dayofMonth = $dateNow->Format('d');
$month = $currentMonth;
$monthplus = $month + 1;
$monthmin = $month - 1;
$first_of_month = mktime (0,0,0, $month, 1, $year);
$maxdays   = date('t', $first_of_month);
$date_info = getdate($first_of_month);
//Get Plugin Params
$enabled = JPluginHelper::isEnabled('content', 'availcal');
if ($enabled)
{
	$plugin = JPluginHelper::getPlugin('content', 'availcal');
	$pluginParams = new JRegistry();
	$pluginParams->loadString($plugin->params);
	$week_firstday = $pluginParams->get('week_firstday',0);
}
else
{
	$week_firstday = 0;
}
//Array for the dark periods
$dark_days = array();
//Load language file
$language = JFactory::getLanguage();
$language->load('plg_content_availcal', JPATH_ADMINISTRATOR, null, true);
$month_name = JTEXT::_('month_'.$month);
?>

<div class="table_pos">
	<table class="cal_main" celpadding="2" cellspacing="1">
		<tr class="cal_title">
			<th><a href="#" id="makeRequest"><&nbsp;</a></th>
			<th colspan="5" class="cal_month"><div id="header">
			<?php echo $month_name." , ".$year?>
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
	</table>





</div>


		<?php
		// add mootools
		JHTML::_('behavior.mootools');
		$js = "
		var id  = '" . $id . "';		
		var monthplus = '" . $monthplus ."';
		var monthmin = '" . $monthmin ."';
		var year = '" . $year ."';		
		
	window.addEvent('domready', function(){
	var req  = 	new Request.HTML({
					url: 'index.php',        
		        	method: 'get', 
		        	data: {
		        	    option: 'com_availcal'
		        	    },  	
		            onRequest: function(){
		                $('result').set('text', 'loading...');
		            },
		
		            onComplete: function(response){
		                $('result').empty().adopt(response);
		            }            
		        })		

    $('makeRequest').addEvent('click', function(event){
        event.stop();		
        req.send('option=com_availcal&format=update&id=' + id + '&month=' + monthmin + '&year=' + year  );
    });
	
    $('makeRequest2').addEvent('click', function(event){
       event.stop();	       
       req.send('option=com_availcal&format=update&id=' + id + '&month=' + monthplus + '&year=' + year );
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
		$document =& JFactory::getDocument();
		$document->addScriptDeclaration($js);

		?>