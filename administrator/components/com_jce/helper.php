<?php
class JCEHelper {
	function checkEditorInstall(){
		$db	=& JFactory::getDBO();
		
		$query = 'SELECT id'
		. ' FROM #__plugins'
		. ' WHERE element = "jce" AND folder = "editors"'
		;
		$db->setQuery( $query );	
		return $db->loadResult();
	}
	function checkEditorPath(){
		$path = JPATH_PLUGINS .DS. 'editors';
		if( file_exists( $path .DS. 'jce.php' ) && file_exists( $path .DS. 'jce.xml' ) && is_dir( $path .DS. 'jce' ) ){
			return true;
		}
		return false;
	}
	function checkPlugins(){
		$db =& JFactory::getDBO();
		$query = 'SELECT *'
		. ' FROM #__jce_plugins'
		;
		$db->setQuery( $query );
		$result = $db->loadResult();
		
		return $result ? true : false;
	}
	function fixPlugins(){
		global $mainframe;
		$db =& JFactory::getDBO();
		
		$query = 'DROP TABLE IF EXISTS `#__jce_plugins`';
		$db->setQuery( $query );
		
		if( !$db->query() ){
			$mainframe->enqueueMessage( JText::_('Unable to remove Plugins Table!'), 'alert' );
		}
		
		$query = "CREATE TABLE `#__jce_plugins` (
		`id` int(11) NOT NULL auto_increment,
		`title` varchar(100) NOT NULL default '',
		`name` varchar(100) NOT NULL,
		`type` varchar(100) NOT NULL default 'plugin',
		`icon` varchar(255) NOT NULL default '',
		`layout` varchar(255) NOT NULL,
		`access` tinyint(3) NOT NULL default '18',
		`row` int(11) NOT NULL default '0',
		`ordering` int(11) NOT NULL default '0',
		`published` tinyint(3) NOT NULL default '0',
		`editable` tinyint(3) NOT NULL default '0',
		`elements` varchar(255) NOT NULL default '',
		`iscore` tinyint(3) NOT NULL default '0',
		`client_id` tinyint(3) NOT NULL default '0',
		`checked_out` int(11) NOT NULL default '0',
		`checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
		`params` text NOT NULL,
		`variables` text NOT NULL,
		PRIMARY KEY  (`id`),
		UNIQUE KEY `plugin` (`name`)
		) TYPE=MyISAM";
		$db->setQuery( $query );
		
		if( !$db->query() ){
			$mainframe->enqueueMessage( JText::_('Unable to create Plugins Table!'), 'alert' );
		}else{
			$mainframe->enqueueMessage( JText::_('Plugins Table created successfully.') );
		}
		
		$query = "INSERT INTO `#__jce_plugins` (`id`, `title`, `name`, `type`, `icon`, `layout`, `access`, `row`, `ordering`, `published`, `editable`, `elements`, `iscore`, `client_id`, `checked_out`, `checked_out_time`, `params`, `variables`) VALUES
		(1, 'Context Menu', 'contextmenu', 'plugin', '', '', 19, 0, 4, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', '', ''),
		(2, 'Directionality', 'directionality', 'plugin', 'ltr,rtl', 'directionality', 19, 3, 10, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', '', ''),
		(3, 'Emotions', 'emotions', 'plugin', 'emotions', 'emotions', 19, 3, 8, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', '', ''),
		(4, 'Fullscreen', 'fullscreen', 'plugin', 'fullscreen', 'fullscreen', 19, 3, 11, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', '', ''),
		(5, 'Paste', 'paste', 'plugin', 'pasteword,pastetext', 'paste', 19, 2, 2, 1, 1, '', 1, 0, 0, '0000-00-00 00:00:00', '', ''),
		(6, 'Preview', 'preview', 'plugin', 'preview', 'preview', 19, 3, 12, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', '', ''),
		(7, 'Tables', 'table', 'plugin', 'tablecontrols', 'buttons', 19, 3, 1, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', '', ''),
		(8, 'Print', 'print', 'plugin', 'print', 'print', 19, 3, 9, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', '', ''),
		(9, 'Search Replace', 'searchreplace', 'plugin', 'search,replace', 'searchreplace', 19, 2, 3, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', '', ''),
		(10, 'Styles', 'style', 'plugin', 'styles', 'styles', 19, 4, 2, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', '', ''),
		(11, 'Non-Breaking', 'nonbreaking', 'plugin', 'nonbreaking', 'nonbreaking', 19, 4, 5, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', '', ''),
		(12, 'Visual Characters', 'visualchars', 'plugin', 'visualchars', 'visualchars', 19, 4, 4, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', '', ''),
		(13, 'XHTML Xtras', 'xhtmlxtras', 'plugin', 'cite,abbr,acronym,del,ins,attribs', 'xhtmlxtras', 19, 4, 3, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', '', ''),
		(14, 'Image Manager', 'imgmanager', 'plugin', '', 'imgmanager', 19, 4, 18, 1, 1, '', 1, 0, 62, '2008-02-29 17:51:18', '', ''),
		(15, 'Advanced Link', 'advlink', 'plugin', '', 'advlink', 19, 4, 20, 1, 1, '', 1, 0, 0, '0000-00-00 00:00:00', '', ''),
		(16, 'Spell Checker', 'spellchecker', 'plugin', 'spellchecker', 'spellchecker', 19, 4, 6, 1, 1, '', 1, 0, 0, '0000-00-00 00:00:00', '', ''),
		(17, 'Layers', 'layer', 'plugin', 'insertlayer,moveforward,movebackward,absolute', 'layer', 19, 4, 1, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', '', ''),
		(18, 'Font ForeColour', 'forecolor', 'command', 'forecolor', 'forecolor', 19, 2, 17, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', '', ''),
		(19, 'Bold', 'bold', 'command', 'bold', 'bold', 19, 1, 2, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', '', ''),
		(20, 'Italic', 'italic', 'command', 'italic', 'italic', 19, 1, 3, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', '', ''),
		(21, 'Underline', 'underline', 'command', 'underline', 'underline', 19, 1, 4, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', '', ''),
		(22, 'Font BackColour', 'backcolor', 'command', 'backcolor', 'backcolor', 19, 2, 18, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', '', ''),
		(23, 'Unlink', 'unlink', 'command', 'unlink', 'unlink', 19, 2, 11, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', '', ''),
		(24, 'Font Select', 'fontselect', 'command', 'fontselect', 'fontselect', 19, 1, 12, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', '', ''),
		(25, 'Font Size Select', 'fontsizeselect', 'command', 'fontsizeselect', 'fontsizeselect', 19, 1, 13, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', '', ''),
		(26, 'Style Select', 'styleselect', 'command', 'styleselect', 'styleselect', 19, 1, 10, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', '', ''),
		(27, 'New Document', 'newdocument', 'command', 'newdocument', 'newdocument', 19, 1, 1, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', '', ''),
		(28, 'Help', 'help', 'command', 'help', 'help', 19, 2, 15, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', '', ''),
		(29, 'StrikeThrough', 'strikethrough', 'command', 'strikethrough', 'strikethrough', 19, 1, 5, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', '', ''),
		(30, 'Indent', 'indent', 'command', 'indent', 'indent', 19, 2, 7, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', '', ''),
		(31, 'Outdent', 'outdent', 'command', 'outdent', 'outdent', 19, 2, 6, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', '', ''),
		(32, 'Undo', 'undo', 'command', 'undo', 'undo', 19, 2, 8, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', '', ''),
		(33, 'Redo', 'redo', 'command', 'redo', 'redo', 19, 2, 9, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', '', ''),
		(34, 'Horizontal Rule', 'hr', 'command', 'hr', 'hr', 19, 3, 2, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', '', ''),
		(35, 'HTML', 'html', 'command', 'code', 'code', 19, 2, 16, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', '', ''),
		(36, 'Numbered List', 'numlist', 'command', 'numlist', 'numlist', 19, 2, 5, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', '', ''),
		(37, 'Bullet List', 'bullist', 'command', 'bullist', 'bullist', 19, 2, 4, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', '', ''),
		(38, 'Clipboard Actions', 'clipboard', 'command', 'cut,copy,paste', 'clipboard', 19, 2, 1, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', '', ''),
		(39, 'Subscript', 'sub', 'command', 'sub', 'sub', 19, 3, 5, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', '', ''),
		(40, 'Superscript', 'sup', 'command', 'sup', 'sup', 19, 3, 6, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', '', ''),
		(41, 'Visual Aid', 'visualaid', 'command', 'visualaid', 'visualaid', 19, 3, 4, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', '', ''),
		(42, 'Character Map', 'charmap', 'command', 'charmap', 'charmap', 19, 3, 7, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', '', ''),
		(43, 'Justify Full', 'full', 'command', 'justifyfull', 'justifyfull', 19, 1, 8, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', '', ''),
		(44, 'Justify Center', 'center', 'command', 'justifycenter', 'justifycenter', 19, 1, 7, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', '', ''),
		(45, 'Justify Left', 'left', 'command', 'justifyleft', 'justifyleft', 19, 1, 6, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', '', ''),
		(46, 'Justify Right', 'right', 'command', 'justifyright', 'justifyright', 19, 1, 9, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', '', ''),
		(47, 'Remove Format', 'removeformat', 'command', 'removeformat', 'removeformat', 19, 3, 3, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', '', ''),
		(48, 'Anchor', 'anchor', 'command', 'anchor', 'anchor', 19, 2, 12, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', '', ''),
		(49, 'Format Select', 'formatselect', 'command', 'formatselect', 'formatselect', 19, 1, 11, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', '', ''),
		(50, 'Image', 'image', 'command', 'image', 'image', 19, 2, 13, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', '', ''),
		(51, 'Link', 'link', 'command', 'link', 'link', 19, 2, 10, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', '', ''),
		(52, 'Browser', 'browser', 'plugin', '', '', 19, 0, 12, 1, 1, '', 1, 0, 0, '0000-00-00 00:00:00', '', ''),
		(53, 'Inline Popups', 'inlinepopups', 'plugin', '', '', 19, 0, 1, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', '', ''),
		(54, 'Read More', 'readmore', 'plugin', 'readmore', 'readmore', 19, 4, 7, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', '', ''),
		(55, 'Media', 'media', 'plugin', '', '', 19, 0, 0, 1, 1, '', 1, 0, 0, '0000-00-00 00:00:00', '', ''),
		(56, 'Code Cleanup', 'cleanup', 'command', 'cleanup', 'cleanup', 19, 2, 14, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', '', ''),
		(57, 'Safari Browser Support', 'safari', 'plugin', '', '', 19, 0, 1, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', '', ''),
		(58, 'TinyMCE 2.x Compatability', 'compat2x', 'plugin', '', '', 19, 0, 1, 1, 0, '', 1, 0, 0, '0000-00-00 00:00:00', '', '')";
		$db->setQuery( $query );
		
		if( !$db->query() ){
			$mainframe->enqueueMessage( JText::_('Unable to insert Plugins Table data!'), 'alert' );
		}else{
			$mainframe->enqueueMessage( JText::_('Plugins Table updated successfully.') );
		}
		
		$query = 'DROP TABLE IF EXISTS `#__jce_extensions`';
		$db->setQuery( $query );
		
		if( !$db->query() ){
			$mainframe->enqueueMessage( JText::_('Unable to remove Extensions Table!'), 'alert' );
		}
		
		$query = "CREATE TABLE `#__jce_extensions` (
		`id` int(11) NOT NULL auto_increment,
		`pid` int(11) NOT NULL,
		`name` varchar(100) NOT NULL,
		`extension` varchar(255) NOT NULL,
		`folder` varchar(255) NOT NULL,
		`published` tinyint(3) NOT NULL,
		PRIMARY KEY  (`id`)
		) TYPE=MyISAM";
		$db->setQuery( $query );
		
		if( !$db->query() ){
			$mainframe->enqueueMessage( JText::_('Unable to create Extensions Table!'), 'alert' );
		}else{
			$mainframe->enqueueMessage( JText::_('Extensions Table created successfully.') );
		}
		
		$query = "INSERT INTO `#__jce_extensions` (`id`, `pid`, `name`, `extension`, `folder`, `published`) VALUES
		(2, 15, 'Joomla Links for Advanced Link', 'joomlalinks', 'links', 1)";
		$db->setQuery( $query );
		
		if( !$db->query() ){
			$mainframe->enqueueMessage( JText::_('Unable to insert Extensions Table data!'), 'alert' );
		}else{
			$mainframe->enqueueMessage( JText::_('Extensions Table updated successfully.') );
		}
		
		$query = "INSERT INTO `#__modules` (`id`, `title`, `content`, `ordering`, `position`, `checked_out`, `checked_out_time`, `published`, `module`, `numnews`, `access`, `showtitle`, `params`, `iscore`, `client_id`, `control`) VALUES
		('', 'JCE News Feed', '', 0, 'jce_cpanel', 0, '0000-00-00 00:00:00', 1, 'mod_feed', 0, 0, 1, 'cache=1\ncache_time=15\nmoduleclass_sfx=\nrssurl=http://www.joomlacontenteditor.net/index.php?option=com_rss&feed=RSS2.0&type=com_frontpage&Itemid=1\nrssrtl=0\nrsstitle=0\nrssdesc=0\nrssimage=0\nrssitems=3\nrssitemdesc=1\nword_count=0\n\n', 0, 1, ''),
		('', 'JCE Admin Menu', '', 0, 'jce_icon', 0, '0000-00-00 00:00:00', 1, 'mod_jcequickicon', 0, 0, 1, '', 0, 1, '')";
		$db->setQuery( $query );
		
		if( !$db->query() ){
			$mainframe->enqueueMessage( JText::_('Unable to insert Modules data!'), 'alert' );
		}else{
			$mainframe->enqueueMessage( JText::_('Modules data updated successfully.') );
		}	
		$mainframe->redirect( 'index.php?option=com_jce&redirected=1' );
	}
	function fixEditor(){
		global $mainframe;
		$path = JPATH_PLUGINS .DS. 'editors';
		if( file_exists( $path .DS. 'jce.php' ) && file_exists( $path .DS. 'jce.xml' ) ){	
			// Sourced from various Joomla! core files including the installer plugin adapter			
			$xml =& JFactory::getXMLParser('Simple');
			$ini = '';		
			if( $xml->loadFile( $path .DS. 'jce.xml' ) ){
				$root =& $xml->document;				
				// Get the element of the tag names
				$element =& $root->getElementByPath('params');
				if (!is_a($element, 'JSimpleXMLElement') || !count($element->children())) {
					// Either the tag does not exist or has no children therefore we return zero files processed.
					return null;
				}			
				// Get the array of parameter nodes to process
				$params = $element->children();
				if (count($params) == 0) {
					// No params to process
					return null;
				}			
				// Process each parameter in the $params array.
				$ini = null;
				foreach ($params as $param) {
					if (!$name = $param->attributes('name')) {
						continue;
					}			
					if (!$value = $param->attributes('default')) {
						continue;
					}		
					$ini .= $name."=".$value."\n";
				}
			}
			
			$row =& JTable::getInstance('plugin');
			$row->name 		= 'JCE Editor 1.5.x';
			$row->ordering 	= 0;
			$row->folder 	= 'editors';
			$row->iscore 	= 0;
			$row->access 	= 0;
			$row->published = 1;
			$row->client_id = 0;
			$row->element 	= 'jce';
			$row->params 	= $ini;
			if (!$row->store()) {
			// Install failed, roll back changes
				$mainframe->redirect( 'index.php', JText::_('Plugin').' '.JText::_('Install').': '.$db->stderr(true) );
				return false;
			}
		}else{
			$mainframe->redirect( 'index.php', JText::_('Plugin files missing') );
			return false;
		}
		$mainframe->redirect( 'index.php?option=com_jce', JText::_('Editor successfully installed') );	
	}	
	function getOrderArray( $input, $listname, $itemKeyName = 'element', $orderKeyName = 'order' ) {
		parse_str( $input, $inputArray );
		$inputArray = $inputArray[$listname];
		$orderArray = array();
		for( $i=0; $i<count( $inputArray ); $i++ ) {
			$orderArray[] = array( $itemKeyName => $inputArray[$i], $orderKeyName => $i +1 );
		}
		return $orderArray;
	}
	function getAccessName( $id ){
		$db =& JFactory::getDBO();
		// get list of Groups for dropdown filter
		$query = 'SELECT name'
		. ' FROM #__core_acl_aro_groups'
		. ' WHERE id = '. $id
		. ' AND name != "ROOT"'
		. ' AND name != "USERS"'
		;
		$db->setQuery( $query );
		return $db->loadResult();
	}
	function accessList( $name, $access, $size=1, $onchange='' ){
		$db =& JFactory::getDBO();
		// get list of Groups for dropdown filter
		$query = 'SELECT id AS value, name AS text'
		. ' FROM #__core_acl_aro_groups'
		. ' WHERE name != "ROOT"'
		. ' AND name != "USERS"'
		;
		$db->setQuery( $query );
		$types[] 		= JHTML::_('select.option',  '0', '- '. JText::_( 'Select Access' ) .' -' );
		$i = '-';
		foreach( $db->loadObjectList() as $obj )
		{
			$types[] = JHTML::_('select.option', $obj->value, $i . JText::_( $obj->text ) );
			$i .= '-';
		}
		if( $onchange ){
			$onchange = 'onchange='. $onchange;
		}
		return JHTML::_('select.genericlist', $types, $name, 'class="inputbox" size="'. $size .'"'. $onchange, 'value', 'text', $access );
	}
	function quickiconButton( $link, $image, $text, $disabled=false ){
		global $mainframe;
		$lang		=& JFactory::getLanguage();
		$template	= $mainframe->getTemplate();
		
		if( $disabled ){
			$link = '#';
		}				
		?>
		<div style="float:<?php echo ($lang->isRTL()) ? 'right' : 'left'; ?>;">
			<div class="icon">
				<a href="<?php echo $link; ?>">
					<?php echo JHTML::_('image.site',  $image, '/templates/'. $template .'/images/header/', NULL, NULL, $text ); ?>
					<span><?php echo $text; ?></span>
				</a>
			</div>
		</div>
        <?php
	}
	function limitText($text, $wordcount){
		if(!$wordcount) {
			return $text;
		}

		$texts = explode( ' ', $text );
		$count = count( $texts );

		if ( $count > $wordcount )
		{
			$text = '';
			for( $i=0; $i < $wordcount; $i++ ) {
				$text .= ' '. $texts[$i];
			}
			$text .= '...';
		}

		return $text;
	}   
}
class jceToolbarHelper extends JToolbarHelper {
	function access( $alt = 'Plugin Access' ){
		$bar = & JToolBar::getInstance('toolbar');
		$bar->appendButton( 'Popup', 'lock', $alt, "index.php?option=com_jce&tmpl=component&type=plugin&task=access_popup", 400, 150 );
	}
	function layout( $alt = 'Editor Layout' ){		
		$bar = & JToolBar::getInstance('toolbar');
		$bar->appendButton( 'Popup', 'move', $alt, "index.php?option=com_jce&tmpl=component&type=plugin&task=layout_edit", 750, 400 );
	}
	function config( $alt = 'Editor Config' ){
		$bar = & JToolBar::getInstance('toolbar');
		$bar->appendButton( 'Popup', 'config', $alt, "index.php?option=com_jce&tmpl=component&type=config&task=view", 700, 560 );
	}
	function help( $type, $alt='Help' ){
		$bar = & JToolBar::getInstance('toolbar');
		$bar->appendButton( 'Popup', 'help', $alt, "http://www.cellardoor.za.net/index2.php?option=com_content&task=findkey&pop=1&keyref=admin.". $type .".view", 700, 560 );
	}
}
?>