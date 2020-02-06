<?php
/**
 * Since we are developing in ordeer to bring earlier versions of wordpress to gutenberg,
 * we will use legacy method to create check boxes for visual regression
 *
 * Register meta box(es).
 */
function visreg_meta_box(){
    add_meta_box(   'visreg_checker',
                    'Visual regression test',
                    'visreg_meta_box_callback',
                    array('post', 'page'),
                    'side',
                    'high'
    );
}

add_action('add_meta_boxes', 'visreg_meta_box');
/*
 * visreg_meta_box Metabox content layout.
 */
function visreg_meta_box_callback($post){ 
    $vrStatus = get_post_meta($post->ID, '_vr_status_key', true);
    
    ?>

    <label for="visreg_checker">
        <input type="checkbox" name="visreg_checker" id="visreg_checker" value='1' <?php checked($vrStatus, 1, 'checked'); ?>>
    <em>Submit for visual regression test</em>

    </label>


<?php
}

function visreg_save_status($post_id){
    if( isset( $_POST[ 'visreg_checker' ] ) ) {
        update_post_meta( $post_id, '_vr_status_key', '1' );
        visreg_add_link();
    } else {
        update_post_meta( $post_id, '_vr_status_key', '0' );
        visreg_drop_link();
    }
}
add_action('save_post', 'visreg_save_status');


/* 
 *   Add or remove link from Visual regression custom table
 */

// Add link
function visreg_add_link(){
    global $wpdb;
    $vrPostId = $post->ID;
    $visregLink = get_permalink( $vrPostId );
    $visregTabl = $wpdb->prefix . 'visreg';
    //$recID = $wpdb->get_var( "SELECT ID FROM ". $visregTabl ." WHERE post_id LIKE ".$vrPostId."'");
    $wpdb->replace( $visregTabl , array('post_id' => $vrPostId, 'guid' => $visregLink), array('%d', '%s',));
}

// Remove link
function visreg_drop_link(){
    global $wpdb;
    $vrPostId = $post->ID;
    $visregTabl = $wpdb->prefix . 'visreg';
    $wpdb->delete( $visregTabl, array( "post_id" => $vrPostId ) );
}

/* Currently not active To be deveoped for later adatation to Gutenberg

function visreg_metaslot_enqueue() {
    wp_enqueue_script( 
    					'visreg-slot-js', 
    					plugin_dir_url( __FILE__ ) . '/slots/visreg_slot.js', // JS file Location
    				// Dependencies	
    				  array( 	'wp-plugins', 
    							'wp-edit-post',
    							'wp-element',
    							'wp-i18n', // For translation purposes
    							'wp-components'
    						),
    					true 
    );
}
add_action( 'enqueue_block_editor_assets', 'visreg_metaslot_enqueue' );

*/


//( ! ) Notice: Undefined variable: post in /Users/dd/mamp_content/wp_sandbox/app/public/wp-content/plugins/buvisreg/inc/visreg_post_metaslot.php on line 23
