<?php
/**
 * @copyright	Copyright (C) 2011 Jan Maat. All rights reserved.
 * @license		GNU/GPL, see http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

require_once (JPATH_SITE.DS.'components'.DS.'com_content'.DS.'helpers'.DS.'route.php');

class modArticleTipsHelper
{
	public static function getList($params)
	{
		$mainframe = JFactory::getApplication();

		$db			=JFactory::getDBO();
		$count		=(int)$params->get('count');

		//get article id's to display
		$articleIdList =array();
		$modParams = $params->ToArray();
		foreach($modParams as $key => $value) {
			$test = strpos($key, 'article');
			if  ($test !== false)
			{
				$articleIdList[] = $value;
			}
		}
		//Get article title's
		$lists	= array();
	 $i		= 0;
	 for($k=0;$i<count($articleIdList);$k++)
	 {
	 	// Content Items only
	 	$query = 'SELECT a.title, ' .
			' CASE WHEN CHAR_LENGTH(a.alias) THEN CONCAT_WS(":", a.id, a.alias) ELSE a.id END as slug,'.
			' CASE WHEN CHAR_LENGTH(cc.alias) THEN CONCAT_WS(":", cc.id, cc.alias) ELSE cc.id END as catslug'.
			' FROM #__content AS a' .
			' LEFT JOIN #__categories AS cc ON cc.id = a.catid' .			
			' WHERE 1=1 AND a.id ='.$articleIdList[$k].' ';

	 	$db->setQuery($query);
	 	$rows = $db->loadObjectList();
	 	if ($rows)
	 	{	
	 	$lists[$i] =   new stdClass(); 
	 	$lists[$i]->link = 'index.php?option=com_content&view=article&tip=1&id=' . $articleIdList[$k];
	 	$lists[$i]->text = htmlspecialchars( $rows[0]->title );
	 	}
		$i++;
		if ($i == $count)
		{
			break;
		}
	 }
		return $lists;
	}
}
