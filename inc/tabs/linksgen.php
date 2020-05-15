

<div id="visred-pt-list" class="pt-list-wrap">
<h3>Select the post types to be tested</h3>
	<?php
		$args = array(
	    'public'   => true,
	    '_builtin'   => 0,
	);?>

	<label><input type="checkbox" name="" value="page">Pages</label>
	<label><input type="checkbox" name="" value="post">Posts</label>

	<?php	
	$vrpostTypes = get_post_types($args, 'objects');
		foreach ( $vrpostTypes  as $vrpostType ) {
	       echo '<label><input type="checkbox" name="" value="'. $vrpostType->name.'">';
	       echo $vrpostType->labels->name;
	       echo '</label>';
	    }
    ?>
</div>