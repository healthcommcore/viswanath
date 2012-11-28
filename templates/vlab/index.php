<?php
defined( '_JEXEC' ) or die( 'Restricted index access' );
jimport('joomla.environment.browser');

$browser = JBrowser::getInstance();

$name = $browser->getBrowser();
$version =$browser->getVersion(); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" >
<head>
<jdoc:include type="head" />
<link rel="stylesheet" href="templates/system/css/system.css" type="text/css" />
<link rel="stylesheet" href="templates/system/css/general.css" type="text/css" />
<link rel="stylesheet" href="templates/<?php echo $this->template?>/css/template.css" type="text/css" />
<?php 
if (  ($name != 'msie'))
{
?>
<link rel="stylesheet" href="templates/<?php echo $this->template?>/css/non-ie.css" type="text/css" />
<?php
}

else
{
?>
<link rel="stylesheet" href="templates/<?php echo $this->template?>/css/ie.css" type="text/css" />
<?php

}
// Left nav rollover safari browser differences
if (  ($name == 'konqueror'))
{
?>
<link rel="stylesheet" href="templates/<?php echo $this->template?>/css/safari.css" type="text/css" />
<?php
} else {
?>
<link rel="stylesheet" href="templates/<?php echo $this->template?>/css/non-safari.css" type="text/css" />


<?php
}
?>
<link rel="shortcut icon" href="favicon.ico" />
</head>

<body>
<div id="wrapper">
<div id="containerhome">
<div id="header" align="right">
								<!--jdoc:include type="modules" name="header" style="raw" /-->
  <div class="main" align="left"><a href="http://viswanathlab.org"><img src="templates/vlab/images/2level_banner_reds.jpg" border="0"></a></div>
</div><!-- end header -->

<div id="navlist">
		<jdoc:include type="modules" name="top" style="raw" />
</div>

<div id="main">
	
    
    <?php  if ($this->countModules('left')) : ?>
    <div id="leftbox2">
            <!--div id="inside"-->
                <jdoc:include type="modules" name="left" style="xhtml" />
            <!--/div-->
    </div>
    <?php endif; ?>

    <div id="midbox2home">
      <div class="main" align="left">
		<?php
        $contentwidth= "80";
        ?>
        
        <div id="content<?php echo $contentwidth; ?>">
                <!--div id="inside"-->
                    <jdoc:include type="component" />
                <!--/div-->
        </div>
 
      </div>
    </div><!-- end midbox2home -->
<div id="footerhome"><img src="templates/vlab/images/footer_home.gif" alt="footer" usemap="#Map" align="bottom" border="0">
<map name="Map" id="Map"><area shape="rect" coords="692,3,848,34" href="http://www.dfci.org/" target="external"><area shape="rect" coords="491,3,673,32" href="http://www.hsph.harvard.edu/" target="external">

</map></div>

<div id="footer" align="center">
								<jdoc:include type="modules" name="footer" style="raw" />
</div>

</div><!-- end header -->

</div><!-- end main -->
</div><!-- end containerhome -->



<?php // echo $mainframe->getCfg('sitename');?>

</div><!-- end wrapper -->
</body>
</html>
