<?php

defined ( '_JEXEC') or die ('Restricted access');
require_once( JApplicationHelper::getPath( 'admin_html') );
JTable::addIncludePath (JPATH_COMPONENT.DS.'tables');
switch ($task) {
	case 'edit':
	case 'add':
		editBio( $option);
		break;
	case 'apply':
	case 'save':
		saveBio( $option, $task);
		break;
	case 'remove':
		removeBio( $option, $task);
		break;
	case 'publish':
		publishBio( $option, $task);
		break;
	case 'unpublish':
		unpublishBio( $option, $task);
		break;
	default:
		showBios( $option);
		break;


}
function publishBio ($option)
{
	global $mainframe;
	$row =& JTable::getInstance( 'Bio', 'Table');	
	$cid =JRequest::getVar('cid',array(), '', 'array');
	$db =& JFactory::getDBO();	

	if (count ($cid))
	{
		$cids = implode( ',', $cid);
		
		$query = "UPDATE #__bios SET published=1 WHERE id IN ( $cids)";
		$db->setQuery( $query);
		if ( !$db->query())
		{
			echo "<script>alert('".$db->getErrorMsg(). "');
				
					window.history.go(-1); </script>\n";
		}
	}

	$mainframe->redirect('index.php?option='.  $option);

}
function unpublishBio ($option)
{
	global $mainframe;
	$row =& JTable::getInstance( 'Bio', 'Table');	
	$cid =JRequest::getVar('cid',array(), '', 'array');
	$db =& JFactory::getDBO();	

	if (count ($cid))
	{
		$cids = implode( ',', $cid);
		
		$query = "UPDATE #__bios SET published=0 WHERE id IN ( $cids)";
		$db->setQuery( $query);
		if ( !$db->query())
		{
			echo "<script>alert('".$db->getErrorMsg(). "');
				
					window.history.go(-1); </script>\n";
		}
	}

	$mainframe->redirect('index.php?option='.  $option);

}
function editBio ($option)
{
	$row =& JTable::getInstance( 'Bio', 'Table');
	$cid = JRequest::getVar('cid', array(0), '', 'array');
	$id = $cid[0];
	$row->load($id);
		
	$lists = array();
	
	
	$lists['published'] = JHTML::_('select.booleanlist', 'published', 'class="inputbox"', $row->published);
	HTML_bios::editBio($row, $lists, $option);

}

function saveBio ($option, $task)
{
	global $mainframe;
	$row =& JTable::getInstance( 'Bio', 'Table');	


	if (!$row->bind(JRequest::get('post')))
	{
		echo "<script>alert('".$row->getError(). "');
			
				window.history.go(-1); </script>\n<br />\n";
		exit();
	}
	
	
	
	$row->lastname  = JRequest::getVar('lastname','','post', 'string', JREQUEST_ALLOWRAW);
	$row->firstname  = JRequest::getVar('firstname','','post', 'string', JREQUEST_ALLOWRAW);
	$row->description  = JRequest::getVar('description','','post', 'string', JREQUEST_ALLOWRAW);
	
	/* Check for valid inputs */
	if ( ( empty( $row->lastname))  || ( empty( $row->firstname)) || ( empty( $row->description)) )
		{
		echo "<script>alert('Please fill in all the fields in the form');
				window.history.go(-1); </script>\n<br />\n";
		exit();
	
	}
	
	
	$row->published =JRequest::getVar('published',0, 'post');
	
	
	if (! $row->store())
	{
		echo "<script>alert('".$row->getError(). "');
			
				window.history.go(-1); </script>\n<br />\n";
		exit();
	
	}
	
	switch ($task)
	{
		case 'apply':
			$msg = 'Changes to Bio saved';
			$link = 'index.php?option=' . $option . '&task=edit&cid[]=' . $row->id;
			break;
		
		case 'save':		
		default:
			$msg = 'Bio saved';
			$link = 'index.php?option=' . $option;
			break;
	
	}
	$mainframe->redirect($link, $msg);
}

function showBios ($option)
{
	$db =& JFactory::getDBO();	

	$query = "SELECT * FROM #__bios ORDER BY lastname ASC";
	$db->setQuery( $query);
	$rows = $db->loadObjectList();
	if ( $db->getErrorNum())
	{
		echo $db->stderr();
		return false;
	}
	HTML_bios::showBios( $rows, $option);

}

function removeBio ($option, $task)
{
	global $mainframe;
	$cid =JRequest::getVar('cid',array(), '', 'array');
	$db =& JFactory::getDBO();	

	if (count ($cid))
	{
		$cids = implode( ',', $cid);
		
		$query = "DELETE FROM #__bios WHERE id IN ( $cids)";
		$db->setQuery( $query);
		if ( !$db->query())
		{
			echo "<script>alert('".$db->getErrorMsg(). "');
				
					window.history.go(-1); </script>\n";
		}
	}
	$mainframe->redirect('index.php?option='.  $option);
}
?>