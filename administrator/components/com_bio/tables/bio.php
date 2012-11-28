<?php

defined ( '_JEXEC') or die ('Restricted access');

class TableBio extends JTable

{
	var $id = null;
	var $lastname = null;
	var $firstname = null;
	var $description = null;
	var $published = null;
	
	function __construct (&$db)
	{
		parent::__construct ( '#__bios', 'id', $db);
	}
}
?>