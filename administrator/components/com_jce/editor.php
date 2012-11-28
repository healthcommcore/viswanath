<?php
/**
* @version		editor.php 1.5.0 31 January 2008
* @package		JCE
* @subpackage	Admin Component
* @copyright	Copyright (C) 2006 - 2008 Ryan Demmmer. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* JCE is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

define( 'JCE_PATH', 		JPATH_PLUGINS .DS. 'editors' .DS. 'jce' );
define( 'JCE_PLUGINS', 		JCE_PATH .DS. 'tiny_mce' .DS. 'plugins' );
define( 'JCE_LIBRARIES', 	JCE_PATH .DS. 'libraries' );
define( 'JCE_CLASSES', 		JCE_LIBRARIES .DS. 'classes' );

function checkPlugin( $plugin ){
	$db	=& JFactory::getDBO();
	
	$query = "SELECT id"
	. "\n FROM #__jce_plugins"
	. "\n WHERE name = ". $db->Quote( $plugin ) 
	. "\n AND published = 1"
	. "\n AND type = 'plugin'"
	;
	$db->setQuery( $query );
	return $db->loadResult();
}
switch( $task ){
	case 'plugin':							
		$plugin = JRequest::getVar( 'plugin', 'cmd' );
		if( checkPlugin( $plugin ) ){
			$file = basename( JRequest::getVar( 'file', 'cmd' ) );
			$path = JCE_PLUGINS .DS. $plugin;		
			if( is_dir( $path ) && file_exists( $path .DS. $file . '.php' ) ){
				include_once $path .DS. $file . '.php';
			}else{
				JError::raiseError(500, JText::_('File '. $file .' not found!') );
			}
		}else{
			JError::raiseError(500, JText::_('Plugin not found!') );
		}
		exit();
		break;
	case 'help':					
		$plugin = JRequest::getVar( 'plugin', 'cmd' );
		if( checkPlugin( $plugin ) ){
			jimport('joomla.application.component.view');
			$help = new JView( $config = array(
				'base_path' 	=> JCE_LIBRARIES,
				'layout' 		=> 'help'
			) );
			$help->display();
		}else{
			JError::raiseError(500, JText::_('Plugin not found!') );
		}
		exit();
		break;
	case 'popup':
        showPopup();
    break; 
}
function showPopup(){
    global $mainframe;
	
	$image 	= JRequest::getVar( 'img' );
    $title 	= str_replace( '_', ' ', JRequest::getVar( 'title', 'Image' ) );
    $mode 	= JRequest::getVar( 'mode', '0' );
    $click 	= JRequest::getVar( 'click', '0' );
    $print 	= JRequest::getVar( 'print', '0' );
    $width 	= JRequest::getVar( 'w' );
    $height = JRequest::getVar( 'h' );

	$image = str_replace( $mainframe->getSiteURL(), '', $image );
    ?>
    <style type="text/css">
        body{
            margin: 0px;
            padding: 0px;
        }
    </style>
	<script type="text/javascript">
	var w = '<?php echo $width;?>';
	var h = '<?php echo $height;?>';   
	var x = (screen.width-parseInt(w))/2;
	var y = (screen.height-parseInt(h))/2;
		
	window.moveTo(x, y);
	</script>
    <?php if( $click ){?>
	<script type="text/javascript">
    function clickIE4(){
        if (event.button==2){
            return false;
        }
    }
    function clickNS4(e){
        if (document.layers||document.getElementById&&!document.all){
            if (e.which==2||e.which==3){
                return false;
            }
        }
    }
    if (document.layers){
        document.captureEvents(Event.MOUSEDOWN);
        document.onmousedown=clickNS4;
    }
    else if (document.all&&!document.getElementById){
        document.onmousedown=clickIE4;
    }
    document.oncontextmenu=new Function("return false");
	</script>
    <?php }
    switch( $mode ){
        case '0':
    ?>
            <img src="<?php echo $image;?>" width="<?php echo $width;?>" height="<?php echo $height;?>" title="<?php echo $title;?>" alt="<?php echo $title;?>" style="cursor:pointer;" onclick="window.close();" />
    <?php
        break;
        case '1':
    ?>
            <table align="center" cellspacing="0" cellpadding="0" border="0">
                <tr>
                    <td align="left" class="contentheading" style="width:<?php echo $width-18;?>px; margin-left: 5px;"><?php echo $title;?></td>
                    <td align="right" style="width:18px;" class="buttonheading">
				        <?php if( $print ){?>
                            <a href="javascript:;" onClick="window.print(); return false"><img src="<?php echo $mainframe->getSiteURL(); ?>images/M_images/printButton.png" width="16" height="16" alt="<?php echo JText::_('PRINT');?>" title="<?php echo JText::_('PRINT');?>" border="0" style="vertical-align:middle;"/></a>
                        <?php }?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><img src="<?php echo $image;?>" width="<?php echo $width;?>" height="<?php echo $height;?>" title="<?php echo $title;?>" alt="<?php echo $title;?>" style="cursor:pointer;" onclick="window.close();" /></td>
	           </tr>
            </table>
    <?php
        break;
    }
}
?>