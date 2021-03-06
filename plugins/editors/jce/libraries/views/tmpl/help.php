<?php
/**
* @version help.php 2008-02-22 Ryan Demmer $
* @package JCE
* @copyright Copyright (C) 2005 - 2007 Ryan Demmer. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* JCE is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
*/
defined( '_JEXEC' ) or die( 'Restricted access' );

$version = "1.5.0";

JLoader::import( 'classes.jce', JCE_LIBRARIES );

$help =& JContentEditor::getInstance();

$params = $help->getEditorParams();	
$help->loadLanguages();

$help->script( array( 
	'tiny_mce_popup'
), 'tiny_mce' );
$help->script( array( 'mootools' ) );
$help->css( array(
	'common',
	'help'
) );

$url = strval( $params->get( 'help', 'http://www.cellardoor.za.net' ) ) . '/index2.php?option=com_content&task=findkey&pop=1&lang=' . $help->getLanguageTag() . '&keyref=';

?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $help->getLanguageTag();?>" lang="<?php echo $help->getLanguageTag();?>" dir="<?php echo $help->getLanguageDir();?>" >
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo JText::_('PLUGIN HELP');?></title>
<?php
$help->printScripts();
$help->printCss();	
?>
	<script type="text/javascript">
		window.addEvent('domready', function(){
			$('help-left').makeResizable({
				handle: 'help-middle',
				modifiers: {x: 'width', y: false}
			});
			helpDialog.loadFrame();
		})
		var helpDialog = {		
			url : '<?php echo $url;?>',
			plugin : '<?php echo $help->getPlugin();?>',
			node : null,
			loadFrame : function(node){
				this.node = node || this.plugin + '.about';
				document.getElementById(this.node).className = 'loader-on';
				document.getElementById('help-iframe').src = this.url + this.node;
			},
			frameLoaded : function(){
				if(document.getElementById(this.node)){
					document.getElementById(this.node).className = '';
				}
			}
		};
    </script>
</head>
<body>
	<fieldset>
    <legend><?php echo JText::_('PLUGIN HELP');?></legend>
    <table border="0" cellpadding="0" cellspacing="0">
    	<tr>
        	<td id="help-left"><div><?php echo $help->getHelpTopics();?></div></td>
            <td id="help-middle">&nbsp;</td>
            <td id="help-right"><iframe id="help-iframe" onload="helpDialog.frameLoaded();" src="about:blank" scrolling="auto" frameborder="0"></iframe></td>
        </tr>
    </table>
    </fieldset>
    <div class="mceActionPanel">
		<div style="float: right">
			<input type="button" id="cancel" name="cancel" value="<?php echo JText::_('Cancel');?>" onClick="tinyMCEPopup.close();" />
		</div>
	</div>
</body>
</html>
