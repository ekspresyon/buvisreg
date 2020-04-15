<?php
/**
 * Since we are developing in ordeer to bring earlier versions of wordpress to gutenberg,
 * we will use legacy method to create check boxes for visual regression
 * Ultimately this checkbox will have to be moved to the "Status & visibility"
 * segment of the side bar
 * Register meta box(es).
 *
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
        //visreg_add_link();
    } else {
        update_post_meta( $post_id, '_vr_status_key', '0' );
        //visreg_drop_link();
    }
}
add_action('save_post', 'visreg_save_status');


/* 
 *   Add or remove link from Visual regression custom table
 */

// Add link

function visreg_add_link($post){
    global $wpdb;
    $vrPostId = $post->ID;
    $visregLink = get_permalink( $vrPostId );
    $vrPstTitl = get_the_title( $vrPostId );
    $visregTabl = $wpdb->prefix . 'visreg';

    $recID = $wpdb->get_var( "SELECT id FROM ". $visregTabl ." WHERE post_id LIKE ".$vrPostId );
    $wpdb->replace( $visregTabl , array(
                                        'id'=> $recID, 
                                        'post_id' => $vrPostId,
                                        'post_title' => $vrPstTitl, 
                                        'guid' => $visregLink), 
                                        array('%d', '%d', '%s', '%s')
                                    );

}
// Remove link
function visreg_drop_link($post){
    global $wpdb;
    $vrPostId = $post->ID;
    $visregTabl = $wpdb->prefix . 'visreg';
    $wpdb->delete( $visregTabl, array( "post_id" => $vrPostId ) );
}

/*
* Register metakey for REST use
*/
$meta_args = array(
    'type'         => 'boolean',
    'description'  => 'Meta key associated with the visual regression flagging of posts',
    'single'       => true,
    'show_in_rest' => true,
);
register_post_meta( '', '_vr_status_key', $meta_args );
