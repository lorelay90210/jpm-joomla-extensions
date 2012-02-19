<?php
/**
 * @copyright	Copyright (C) 2011 Jan Maat. All rights reserved.
 * @license		GNU/GPL, see http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

require_once (JPATH_SITE.DS.'components'.DS.'com_content'.DS.'helpers'.DS.'route.php');

class modGoogleCalendarHelper
{
	public static function getCode($params)
	{
		$mainframe = JFactory::getApplication();
		$code = $params->get('code');	
		return $code;
	}
}
