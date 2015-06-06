<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<script type="text/javascript">

</script>
<div class="framr-widget-options">
	
	<ul>
	    <li><input name="framr-widget-display-price-checkbox" type="checkbox" <?php echo $instance["framr-widget-display-price-checkbox"] == 'on' ? ' checked' : '';?>>Display Price</input></li>
	    <li><input name="framr-widget-display-footage-checkbox" type="checkbox" <?php echo $instance["framr-widget-display-footage-checkbox"] == 'on' ? ' checked' : '';?>>Display Footage</input></li>
	    <li><input name="framr-widget-display-newsletter-checkbox" type="checkbox" <?php echo $instance["framr-widget-display-newsletter-checkbox"] == 'on' ? ' checked' : '';?>>Display Newsletter</input></li>
	 
	    <li>
	    	<label for="framr-widget-display-unit-type-select">Measurement Type:</label>
		    <select name="framr-widget-display-unit-type-select">
		    	<option value="Standard" <?php echo $instance["framr-widget-display-unit-type-select"] == 'Standard' ? ' selected="selected"' : '';?>>Standard</option>
		    	<option value="Metric" <?php echo $instance["framr-widget-display-unit-type-select"] == 'Metric' ? ' selected="selected"' : '';?>>Metric</option>
		    </select>
	    </li>
   
	</ul>
</div>
<div class="framr-widget-description">
	
	<p>For More widget customizations please see options menu in widgets menu</p>
</div>