<?php


// Call the visual regression metaslot
require BUVR_DIR .'/inc/visreg_post_metaslot.php';



// Call tool menu page
require BUVR_DIR .'/inc/admin_page.php';


// Call Custom API endpoints
require BUVR_DIR .'/inc/visreg_REST_API.php';


// function get_vrflagged_link(){
// 	$args = array(	
//         		);

// 	$vsflagged = get_posts($args)

// 	foreach ($vsflagged as $post) {
		
// 	}
// }