<?php
/**
* @copyright	Copyright (C) 2011 Jan Maat. All rights reserved.
* @license		GNU/GPL, see http://www.gnu.org/copyleft/gpl.html
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

// Include the syndicate functions only once
require_once (dirname(__FILE__).DS.'helper.php');

$list = modArticleTipsHelper::getList($params);
require(JModuleHelper::getLayoutPath('mod_articletips'));