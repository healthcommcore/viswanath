<?php

class HTML_bio 
{
	function showBios( $rows, $option) {
	
	
	global $mainframe;

$document = &JFactory::getDocument();
echo '<div class="componentheading">'. $document->getTitle(). '</div>';

		?><a name="top" id="top"><?php
		$count = 0;	// Display back to top link after every 3, and at end of list
		foreach ($rows as $row) {
			echo
			
			'<div class="bio"><p><a name="bio'. $row->id.'"></a>' . $row->description. '</p>
				';
			$count++;
			//if ($count >= 3) {
				?>
		        <br /><!--<a href="#top">BACK TO TOP </a>--></div>
                <?php
				//$count = 0;
			//}

		}
	
	}
}

?>