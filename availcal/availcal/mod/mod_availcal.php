<?php
/**
 * @version		$Id: mod_login.php 20806 2011-02-21 19:44:59Z dextercowley $
 * @package		Joomla.Site
 * @subpackage	mod_availcal
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

// Include the syndicate functions only once
require_once dirname(__FILE__).'/helper.php';
// Check if the Availcal Component is installed and enabled
$enabled	= JComponentHelper::isEnabled('com_availcal', true);
// Should we proceed
if (  $enabled ) {
	$dark_days = modAvailcalHelper::getDarkperiods($params);
	require(JModuleHelper::getLayoutPath('mod_availcal'));
}
