<?php
/**
* @version $Id: brower.php 2005-12-27 09:23:43Z Ryan Demmer $
* @package JCE
* @copyright Copyright (C) 2005 Ryan Demmer. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* JCE is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
*/
defined( '_JEXEC' ) or die( 'Restricted access' );

$version = "1.5.0";

require_once( JCE_LIBRARIES .DS. 'classes' .DS. 'plugin.php' );
require_once( JCE_LIBRARIES .DS. 'classes' .DS. 'utils.php' );
require_once( JCE_LIBRARIES .DS. 'classes' .DS. 'manager.php' );

require_once( dirname( __FILE__ ) .DS. 'classes' .DS. 'browser.php' );

$manager =& Browser::getInstance();

// Process any XHR requests
$manager->processXHR();
// Set javascript file array
$manager->script( array( 
	'browser'
), 'plugins' );
$manager->css( array( 
	'browser'
), 'plugins' );

$manager->_debug = false;
$session = &JFactory::getSession();
$version .= $manager->_debug ? ' - debug' : '';

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $manager->getLanguageTag();?>" lang="<?php echo $manager->getLanguageTag();?>" dir="<?php echo $manager->getLanguageDir();?>" >
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo JText::_('PLUGIN TITLE').' : '.$version;?></title>
<?php
$manager->printScripts();
$manager->printCss();
?>
<script type="text/javascript">
	function initManager(src){
		var browser = new Browser(src, {
			// Global parameters
			actions: <?php echo $manager->getActions();?>,
			buttons: <?php echo $manager->getButtons();?>,
			lang: '<?php echo $manager->getLanguage();?>',
			upload: '<?php echo $manager->getEditorOption('upload'); ?>',
			tree: <?php echo $manager->getEditorOption('tree'); ?>,
			// Plugin parameters
			params: {
				base: '<?php echo $manager->getBase(); ?>',
				viewable: '<?php echo $manager->getViewable(); ?>'
			}
		});		
		return browser;
	}
</script>
</head>
<body lang="<?php echo $manager->getLanguage(); ?>" id="browser" style="display: none;">
    <input type="hidden" id="src" value="" />
	<?php $manager->loadBrowser();?>
	<div class="mceActionPanel">
		<div style="float: right">
    		<input type="button" class="button "id="refresh" name="refresh" value="<?php echo JText::_('Refresh');?>" />
			<input type="button" id="insert" name="insert" value="<?php echo JText::_('Insert');?>" onClick="BrowserDialog.insert();" />
			<input type="button" id="cancel" name="cancel" value="<?php echo JText::_('Cancel');?>" onClick="tinyMCEPopup.close();" />
		</div>
	</div>
</body> 
</html>