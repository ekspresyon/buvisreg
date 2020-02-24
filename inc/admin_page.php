<?php
//** For testin purpose option 1
//require_once BUVR_DIR. '/inc/url_list_table.php';

//** For testin purpose option 2
require_once BUVR_DIR. '/inc/visreg_url_list_table.php';



/* Generate menu link */
function buvis_reg_menu() {

	global $buvis_reg_menu_hook;
	// Place under tools with "add_management_page" hook
	// For placement as top menu link use "add_menu_page" hook
	$buvis_reg_menu_hook = add_management_page( 
								'VisReg overview', // page title
								 'Visual Regression Test',// page name
								 'manage_options',// admin permission
								 'bu-visreg-test', //slug
								 'bu_visreg_admin_page' // call back for page layout
							);
	add_action('admin_enqueue_scripts','upload_links_form_script'); // pull scripts to be loaded
}

// "network_admin_menu" hook does not give permission to super admin
// using "admin_menu" hook for now
add_action( 'admin_menu', 'buvis_reg_menu' );

// scripts for admin page
function upload_links_form_script($hook){
	global $buvis_reg_menu_hook;

	if ( $hook != $buvis_reg_menu_hook ){
		return;
	}
		wp_register_style('visreg-tab-css', plugin_dir_url(__FILE__).'assets/css/visreg.css', array(), false, false);
		wp_register_script('vr-links-upload-toggle', plugin_dir_url(__FILE__).'assets/js/links-upload-toggle.js', array(), false, true);
		wp_register_script('vr-admin-page-tabl',plugin_dir_url(__FILE__).'assets/js/vr_data_table.js', array(), false, true );
		wp_enqueue_style('visreg-tab-css');
		wp_enqueue_script(array('vr-links-upload-toggle',
								'vr-admin-page-tabl'
								)
							);
}
//add_action('admin_enqueue_scripts','upload_links_form_script');

/* Generate visual regression URL management page */
function bu_visreg_admin_page() {
	
	// Block users with wrong clearance level
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	} ?>
	<div class="wrap">
		<h1>Visual regression test</h1>
		<hr>
		<em>Use this tool to run the comparative test between "before" and "after" states of you site.</em>
		<p>Below is a list table of the links selected by site managers to be tested when update/upgrades are scheduled. you can remove or add test URLs as needed.</p>
		<hr>
		
  <h1 class="wp-heading-inline">Test links</h1>
		<!-- <a href="#" class="upload-view-toggle page-title-action" role="button" aria-expanded="true">
			<span class="upload">Upload Links</span>
		</a> -->

		<!-- Bulk link upload -->
		
		<div class="upload-plugin-wrap">
			<div class="upload-plugin">
				<p class="install-help">If you have links to be tested in a .json format, you may submit them by uploading it here.</p>
				<form method="post" enctype="multipart/form-data" class="wp-upload-form" action="#">
					<label class="screen-reader-text" for="linksfile">Test links file</label>
					<input type="file" id="linksfile" name="linksfile">
					<input type="submit" name="install-plugin-submit" id="install-plugin-submit" class="button" value="Upload now" disabled="">	
				</form>
			</div>
		</div>
		<div class="api-links">
			
				<select id="linkselector">
					<option data-url="http://wp.local/wp-json/visreg/v1/flagged">Flagged</option>
					<option data-url="http://wp.local/wp-json/visreg/v1/posts">Posts</option>
					<option data-url="http://wp.local/wp-json/visreg/v1/pages">Pages</option>
					<option disabled>Random</option>
					<option disabled>more options</option>
				</select>

				<button id="listgenbtn" class="page-title-action">
					Generate list
				</button>
			
			<a id="listxprtbtn" class="page-title-action api-links-xprt" href="data:application/octet-stream,HELLO-WORLDDDDDDDD" download="test_urls.json">Export list</a>	
			
		</div>
		<div class="">
					
		</div>
  <?php
		// From "VisReg_url_List_Table" class - file : /inc/visreg_url_list_table.php

			//$vrListTable = new VisReg_url_List_Table();
			  //$vrListTable->prepare_items();
			  //$vrListTable->views();
			  //$vrListTable->search_box( 'search', 'search_id' );
			  //$vrListTable->display(); 

			//print_r ($vrListTable->fetch_visreg_table_data());
			//echo ($vrListTable->column_default($item, $column_name));
		?>	
		<div id="vrlinks">
			
		</div>
	</div>

	<?php
}

