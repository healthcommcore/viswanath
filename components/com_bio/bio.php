<?php

defined ( '_JEXEC') or die ('Restricted access');

jimport('joomla.application.helper');
require_once( JApplicationHelper::getPath( 'html') );
JTable::addIncludePath (JPATH_ADMINISTRATOR.DS.'components'.DS.$option.DS.'tables');
switch ($task) {
	default:
		showPublishedBios($option);
		break;

}

function showPublishedBios( $option) 
{
	$query = "SELECT * FROM #__bios WHERE published = 1 ORDER BY lastname ASC";
	$db =& JFactory::getDBO();
	$db->setQuery( $query);
	$rows = $db->loadObjectList();
	if ( $db->getErrorNum())
	{
		echo $db->stderr();
		return false;
	}
	HTML_bio::showBios( $rows, $option);

}
?>