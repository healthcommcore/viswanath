<?php
/**
 * @copyright	Copyright (C) 2005 - 2009 RocketTheme, LLC - All Rights Reserved.
 * @license		GNU/GPL, see LICENSE.php
**/
defined('_JEXEC') or die;
define( 'YOURBASEPATH', dirname(__FILE__) );
require(YOURBASEPATH . DS . "rt_styleswitcher.php");

$color_style			= $this->params->get("colorStyle", "dark");
$template_width 		= $this->params->get("templateWidth", "962");
$leftcolumn_width		= $this->params->get("leftcolumnWidth", "210");
$rightcolumn_width		= $this->params->get("rightcolumnWidth", "210");
$leftcolumn_color		= $this->params->get("leftcolumnColor", "color2");
$rightcolumn_color		= $this->params->get("rightcolumnColor", "color1");
$mootools_enabled       = ($this->params->get("mootools_enabled", 1)  == 0)?"false":"true";
$caption_enabled        = ($this->params->get("caption_enabled", 1)  == 0)?"false":"true";
$rockettheme_logo       = ($this->params->get("rocketthemeLogo", 1)  == 0)?"false":"true";

require(YOURBASEPATH . DS . "rt_styleloader.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" >
<head>
<jdoc:include type="head" />
<?php
require(YOURBASEPATH . DS . "rt_utils.php");
$is_home = JRequest::getVar('Itemid') == 101;
?>
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/rt_afterburner/css/<?php echo $tstyle ?>.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/rt_afterburner/css/print.css" type="text/css" media="print" />
<!--[if lte IE 6]>
<script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/rt_afterburner/js/ie_suckerfish.js"></script>
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/rt_afterburner/css/styles.ie.css" type="text/css" />
<![endif]-->
<!--[if lte IE 7]>
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/rt_afterburner/css/styles.ie7.css" type="text/css" />
<![endif]-->
</head>
<body>
<div id="header_left" class="absolute"></div>
<div id="header_right" class="absolute"></div>
<div id="wrapper">
	<?php if($this->countModules('search')) : ?>
		<jdoc:include type="modules" name="search" style="xhtml" />
	<?php endif; ?>
<div id="header_graphic">
    		<jdoc:include type="modules" name="top" style="afterburner" />		
    	    <a href="<?php echo $this->baseurl ?>" id="logo"></a>
			</div>
</div>
<div id="main">
			
	<div id="wrapper" class="foreground">
	    
		<div id="nav">
		    <jdoc:include type="modules" name="nav" style="none" />
		</div>
		<div id="message">
		    <jdoc:include type="message" />
		</div>
		<?php if ($this->countModules('showcase') && !$_GET['searchword']) : ?>
		<div id="showcase" class="dp100">
			<div class="background"></div>
			<div class="foreground">
		    	<jdoc:include type="modules" name="showcase" style="none" />
		    </div>
		</div>
		<?php endif; ?>
		<jdoc:include type="modules" name="advertisement" style="afterburner" />
        <div id="main-content" class="<?php echo $col_mode; ?>">
            <div id="colmask" class="ckl-<?php echo $leftcolumn_color; ?>">
                <div id="colmid" class="cdr-<?php echo $rightcolumn_color; ?>">
                    <div id="colright" class="ctr-<?php echo $rightcolumn_color; ?>">
                        <div id="col1wrap">
							<div id="col1pad">
                            	<div id="col1">
									<?php if ($this->countModules('breadcrumb')) : ?>
                                    <div class="breadcrumbs-pad">
                                        <jdoc:include type="modules" name="breadcrumb" />
                                    </div>
									<?php endif; ?>
									<?php if ($this->countModules('user1 or user2 or user3')) : ?>
									<div id="mainmods" class="spacer<?php echo $mainmod_width; ?>">
										<jdoc:include type="modules" name="user1" style="afterburner" />
										<jdoc:include type="modules" name="user2" style="afterburner" />
										<jdoc:include type="modules" name="user3" style="afterburner" />
									</div>
									<?php endif; ?>
                                    <div class="component-pad">
                                        <jdoc:include type="component" />
                                    </div>
									<?php if ($this->countModules('user4 or user5 or user6')) : ?>
									<div id="mainmods2" class="spacer<?php echo $mainmod2_width; ?>">
										<jdoc:include type="modules" name="user4" style="afterburner" />
										<jdoc:include type="modules" name="user5" style="afterburner" />
										<jdoc:include type="modules" name="user6" style="afterburner" />
									</div>
									<?php endif; ?>
	                            </div>
							</div>
                        </div>
						<?php if ($leftcolumn_width != 0) : ?>
                        <div id="col2" class="<?php echo $leftcolumn_color; ?>">
													<div id="left_col_color">
														<jdoc:include type="modules" name="left" style="xhtml" />
													</div>
                        </div>
						<?php endif; ?>
						<?php if ($rightcolumn_width != 0) : ?>
							<?php //if($is_home): ?>
						<!--
								<div id="right_col_home">
						-->
							<?php //endif; ?>
                        <div id="col3" class="<?php echo $rightcolumn_color; ?>">
                        	<jdoc:include type="modules" name="right" style="rounded" />
                        </div>
							<?php //if($is_home): ?>
						<!--
								</div>
						-->
							<?php i//endif; ?>
						<?php endif; ?>
                    </div>
                </div>
            </div>
		<?php if ($this->countModules('user7 or user8 or user9')) : ?>
		<div id="mainmods3" class="spacer<?php echo $mainmod3_width; ?>">
			<jdoc:include type="modules" name="user7" style="afterburner" />
			<jdoc:include type="modules" name="user8" style="afterburner" />
			<jdoc:include type="modules" name="user9" style="afterburner" />
		</div>
		<?php endif; ?>
		<?php if ($this->countModules('bottom')) : ?>
		<div id="footer">
			<div class="footer-pad">
                <jdoc:include type="modules" name="bottom" style="none" />
            </div>
		</div>
		<?php endif; ?>
		<?php if ($rockettheme_logo=="true") : ?>
		<a href="http://www.rockettheme.com"><span id="logo2"></span></a>
		<?php endif; ?>
		<jdoc:include type="modules" name="footer" style="afterburner" />
		<jdoc:include type="modules" name="debug" style="none" />
	</div>
</div>
</body>
</html>
