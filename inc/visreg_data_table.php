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
					post_title text NULL,
					post_id integer UNSIGNED NULL,
					guid varchar (200) NOT NULL,
					PRIMARY KEY  (id)
			)$charset_collate;";
		
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $sql );

			add_option( 'visreg_table_version', $visreg_table_version );
		}
	}
	
	/* Keeps being triggered every time values are changed for a column.
	Needs to be fixed. Currently deactivated.
	*/
	function visreg_update_db_check() {
		global $wpdb;
    	global $visreg_table_version;

    	$VrTableName = $wpdb->prefix . "visreg";
    	$installed_ver = get_option( "visreg_table_version" );
    	$charset_collate = $wpdb->get_charset_collate();


	    if ( get_site_option( 'visreg_table_version' ) != $installed_ver ) {
				$sql = "CREATE TABLE $VrTableName (
					id integer NOT NULL AUTO_INCREMENT,
					post_id integer UNSIGNED NOT NULL,
					post_status varchar(20),
					guid varchar (200) DEFAULT '' NOT NULL,
					post_title text,
					post_name varchar(100),
					submited_by integer(10) UNSIGNED,
					submit_date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
					post_type varchar(20),
					site_name text,
					home_url varchar(100) DEFAULT '' NOT NULL,
					post_last_test datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
					PRIMARY KEY  (id)
				)$charset_collate;";

				require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
				dbDelta( $sql );

				update_option( "visreg_table_version", $visreg_table_version );
		}
	    
	}
	//add_action( 'plugins_loaded', 'visreg_update_db_check' );

	/* Needs further development 

	- Add an Upgrade Function

	*/