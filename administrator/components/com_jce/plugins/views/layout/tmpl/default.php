<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::script( 'sortables.js', 'administrator/components/com_jce/js/' );?>
<?php JHTML::stylesheet( 'layout.css', 'administrator/components/com_jce/css/' );?>
<?php
	
?>
<style type="text/css">
	.editor { width: <?php echo $this->dimensions['width'];?>px; }
</style>
<form action="index.php" method="post" name="adminForm">
    <fieldset>
        <div style="float: right">
            <button type="button" onclick="submitbutton();"><?php echo JText::_( 'Save' );?></button>
            <button type="button" onclick="window.parent.document.getElementById('sbox-window').close();"><?php echo JText::_( 'Cancel' );?></button>
        </div>
        <div class="configuration" >
            <?php echo JText::_( 'JCE LAYOUT EDITOR' );?>
        </div>
    </fieldset>
    <fieldset>
        <table class="admintable">
            <tr>
                <td><?php echo JText::_('JCE LAYOUT');?></td>
            </tr>
            <tr>
                <td><?php echo JText::_('JCE PLUGINS LAYOUT');?></td>
            </tr>
            <tr>
                <td><div class="editor">
                <?php 
                $width 	= $this->dimensions['width'] + 100;
				$sortid = array();
				for( $i=0; $i<count( $this->items ); $i++ ){
					$r = $i + 1;
					$sortid[] = "'row". $r ."'";
				?>
					<ul class="sortGroup" id="row<?php echo $r;?>" style="width:<?php echo $width;?>px">
                <?php
					foreach( $this->items[$i] as $item ){
						$n = "row_li_". $item->id;
						switch( $item->type ){
							case 'command' :
							?>
								<li class="sortItem" id="<?php echo $n;?>"><img src="../plugins/editors/jce/tiny_mce/themes/advanced/img/<?php echo $item->layout;?>.gif" alt="<?php echo $item->title;?>" /></li>
							<?php
                            break;
							case 'plugin' :
							?>
							<li class="sortItem" id="<?php echo $n;?>"><img src="../plugins/editors/jce/tiny_mce/plugins/<?php echo $item->name;?>/img/<?php echo $item->layout;?>.gif" alt="<?php echo $item->title;?>" /></li>
							<?php
                            break;
						}
					}
					?>
                    </ul>
				<?php }?>
				<input type="hidden" id="row<?php echo $r;?>_out" name="row<?php echo $r;?>_out" />
            	</div></td>
            </tr>
        </table>
    </fieldset>		
	<script type="text/javascript">
        var form = document.adminForm;
        function submitbutton(){
            var res = sortables.serialize(false, function(element){
                return element.getParent().getProperty('id') + '[]=' + element.getProperty('id').replace(/[^0-9]/gi, '');
            }).join('&').replace(',', '&', 'gi');
            form.layout_data.value = res;
            form.task.value = 'layout_save';
            form.submit();
        }
       var sortables = new Sortables([<?php echo implode( ',', $sortid );?>], {revert: true});
    </script>
    <span id="debug"></span>
    <input type="hidden" name="layout_data" value="" />
    <input type="hidden" name="option" value="com_jce" />
    <input type="hidden" name="client" value="<?php echo $this->client; ?>" />
    <input type="hidden" name="type" value="plugin" />
    <input type="hidden" name="task" value="" />
    <?php echo JHTML::_( 'form.token' ); ?>
</form>