<?php
/**
* @copyright	Copyright (C) 2011 Jan Maayt All rights reserved.
* @license		GNU/GPL, see http://www.gnu.org/copyleft/gpl.html
*/
defined('_JEXEC') or die('Restricted access'); ?>
<ul class="latestnews<?php echo $params->get('moduleclass_sfx'); ?>">
<?php foreach ($list as $item) :  ?>
	<li class="latestnews<?php echo $params->get('moduleclass_sfx'); ?>">
		<a href="<?php echo $item->link; ?>" class="latestnews<?php echo $params->get('moduleclass_sfx'); ?>">
			<?php 
			    if(strlen($item->text)>45)
			    {
					echo htmlentities(substr($item->text,0,45)). '...'; 
			    }
			    else 
			    {
			    	echo htmlentities($item->text); 
			    }
			?>
		</a>
	</li>
<?php endforeach; ?>
</ul>

