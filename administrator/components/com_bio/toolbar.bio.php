<?php

defined ( '_JEXEC') or die ('Restricted access');
require_once( JApplicationHelper::getPath('toolbar_html'));

switch($task)

{
	case 'edit':
	case 'add':
		TOOLBAR_bio::_NEW();
		break;
	default:
		TOOLBAR_bio::_DEFAULT();
		break;

}

?>