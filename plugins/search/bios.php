<?php

defined ( '_JEXEC') or die ('Restricted access');
$mainframe->registerEvent ( 'onSearch', 'botSearchBios');
$mainframe->registerEvent ( 'onSearchAreas', 'botSearchBioAreas');

function &botSearchBioAreas() {
	static $areas = array( 'bios' => 'Bios');
	return $areas;
}

function botSearchBios( $text, $phrase='', $ordering='', $areas=null)
{
	// No results if no search text
	if (!$text) {
		return array();
	}
	
	// if search area specified, only if it matches ours ('bios')
	if (is_array($areas) ) {
		if (!array_intersect( $areas, array_keys( botSearchBioAreas() ) )) {
			// no match, no results
			return array();
		}
	}
	
	$db =& JFactory::getDBO();
	//echo $phrase;
	if ($phrase == 'exact')
	{
		$where = "(LOWER(lastname) LIKE '%$text%')
			OR (LOWER(firstname) LIKE '%$text%')
			OR (LOWER(description) LIKE '%$text%') ";
	}
	else
	{
		$words = explode( ' ', $text);
		$wheres = array();
		foreach ($words as $word) {
			$wheres[] = "(LOWER(lastname) LIKE '%$word%')
			OR (LOWER(firstname) LIKE '%$word%')
			OR (LOWER(description) LIKE '%$word%') ";
		}
		if ($phrase == 'all')
		{
			$separator = 'AND';
		}
		else
		{
			$separator = 'OR';
		}
		$where = '(' . implode( ") $separator (", $wheres ) . ')';
	}
	$where .= ' AND published = 1';
	
	$order = 'lastname ASC';
	
	
	$query = "SELECT CONCAT( firstname, ' ', lastname ) AS title, description AS text, '' AS created, ".
		"\n 'Bios' AS section," .
		"\n '' AS category," .
		"\n CONCAT( 'index.php?option=com_bio&id=', id) AS href," .
		"\n '2' AS browsernav" .
		"\n FROM #__bios" .
		"\n WHERE $where" .
		"\n ORDER BY $order";
	//echo $query;
		$db->setQuery( $query );
		$rows = $db->loadObjectList();
		return $rows;
}
?>