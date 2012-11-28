<?php

defined ( '_JEXEC') or die ('Restricted access');

class TOOLBAR_bio {
	function _NEW() {
		JToolBarHelper::title( JText::_( 'Bio' ).': <small><small>[ Edit ]</small></small>', 'addedit.png' );
		JToolBarHelper::save();
		JToolBarHelper::apply();
		JToolBarHelper::cancel();
	}
	
	function _DEFAULT() {
		JToolBarHelper::title( JText::_('Bios'), 'generic.png');
		JToolBarHelper::publishList();
		JToolBarHelper::unpublishList();
		JToolBarHelper::editList();
		JToolBarHelper::deleteList();
		JToolBarHelper::addNew();
	
	}

}
?>