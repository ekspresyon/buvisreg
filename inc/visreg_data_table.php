<?php 
/* 	create a data table
*	that will contain all the necessary data 
*	to manage and run visual repgression tests
*/
	global $visreg_table_version;
	$visreg_table_version = '0.3';

	function create_visreg_data_table(){
		global $wpdb;
		global $visreg_table_version;

		$VrTableName = $wpdb->prefix . "visreg";
		$charset_collate = $wpdb->get_charset_collate();

		if ($wpdb->get_var('SHOW TABLES LIKE ' . $VrTableName) != $VrTableName ){

			// This is for testing purposes. Will need adustment
			$sql = "CREATE TABLE $VrTableName (
					id integer NOT NULL AUTO_INCREMENT,
					post_id integer UNSIGNED NOT NULL,
					post_title text NULL,
					guid varchar (200) DEFAULT '' NOT NULL,
					PRIMARY KEY  (id)
			)$charset_collate;";
		
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $sql );

			add_option( 'visreg_table_version', $visreg_table_version );
		}
	}
	
	