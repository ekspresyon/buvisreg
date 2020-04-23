<?php


// Call the visual regression metaslot
require BUVR_DIR .'/inc/visreg_post_metaslot.php';

// Call tool menu page
require BUVR_DIR .'/inc/admin_page.php';


// Call Custom API endpoints
require BUVR_DIR .'/inc/visreg_REST_API.php';

// Call API filter 
require BUVR_DIR .'/inc/post_type_rest_filter.php';

// Call WP API filter activater Plugin
require BUVR_DIR .'/inc/wp_rest_api_filter_plugin.php';