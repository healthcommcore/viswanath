<?php

defined ( '_JEXEC') or die ('Restricted access');
class HTML_bios

{
	function editBio( $row, $lists, $option)
	
	{
		$editor =& JFactory::getEditor();
		?>
        
        <form action="index.php" method="post" name="adminForm" id="adminForm">
        <fieldset class="adminForm">
        
        <legend>Details</legend>
        
        <table class="admintable">
        <tr>
        <td width="100" align="right" class="key">
        	First Name:
        </td>
        
        <td>
        	<input class="text_area" type="text"
 name="firstname" id="firstname" size="50" maxlength="100" value="<?php echo $row->firstname; ?>" >
 		</td>
               
        </tr>

        <tr>
        <td width="100" align="right" class="key">
        	Last Name:
        </td>
        
        <td>
        	<input class="text_area" type="text"
 name="lastname" id="lastname" size="50" maxlength="100" value="<?php echo $row->lastname; ?>" >
 		</td>
               
        </tr>

        <tr>
        <td width="100" align="right" class="key">
        	Description:
        </td>
        
        <td>
        	<?php
			echo $editor->display( 'description', $row->description, '100%', '250', '40', '10');
			?>
 		</td>
               
        </tr>


        <tr>
        <td width="100" align="right" class="key">
        	Published:
        </td>
        
        <td>
        	<?php
			echo $lists['published'];
			?>
 		</td>
               
        </tr>
        
        </table>
       
       
       	</fieldset>
        <input type="hidden" name="id"  value="<?php echo $row->id; ?>" />
        <input type="hidden" name="option"  value="<?php echo $option; ?>" />
        <input type="hidden" name="task"  value="" />
        
        </form>
        
        
        <?php
	
	}
	// List of bios - default view
	function showBios( $rows, $option)
	{
		?>
        
        <form action="index.php" method="post"
 name="adminForm">
 		<table class="adminlist">
        <thead>
        <tr>
        	<th width="20">
            	<input type="checkbox" name="toggle" value="" onClick="checkAll(<?php echo count($rows);?> );" />
            
            </th>
            <th class="title">Name</th>
            <th width="5%" nowrap="nowrap">Published</th>
        </tr>
        </thead>
        
        <?php
		jimport('joomla.filter.filteroutput');
		$k = 0;
		for ($i = 0, $n = count($rows); $i < $n; $i++)
		
		{
		$row = &$rows[$i];
		$checked = JHTML::_('grid.id', $i, $row->id);
		$published = JHTML::_('grid.published', $row, $i);
		$link = JFilterOutput::ampReplace( 'index.php?option=' . $option . '&task=edit&cid[]=' . $row->id);
		?>
        <tr class="<?php echo "row$k"; ?> ">
        <td>
        	<?php echo $checked; ?>
        </td>
        <td>
        	<a href="<?php echo $link; ?>">
        	<?php echo $row->firstname . ' ' . $row->lastname; ?></a>
        </td>


        <td align="center">
        	<?php echo $published; ?>
        </td>
        
        </tr>
		
		<?php
        $k = 1 - $k;
		
		}
		?>
        
        </table>
        <input type="hidden" name="option"  value="<?php echo $option; ?>" />
        <input type="hidden" name="task"  value="" />
        <input type="hidden" name="boxchecked"  value="0" />
		
 		</form>
        <?php 
		
	}


}

?>