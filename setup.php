<?php
// The Visual regression class

class BUVisReg

{
	function __construct(){

	}


	function activate_plugin(){
		// Call in database generator function
		require_once BUVR_DIR . '/inc/visreg_data_table.php';
		echo "your database has been created";
	}


	// Not yet!
	/*function deactivate_plugin(){

	}

	function uninstall_plugin(){

	}*/

	

} 

if (class_exists('BUVisReg')){
	$buvisreg = new BUVisReg;
}


