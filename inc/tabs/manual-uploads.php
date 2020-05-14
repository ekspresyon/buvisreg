<?php         


function vr_manual_uploads(){
	echo '<div class="vrlink-upload">
                <p class="vrlink-help"><em>Insert links to be tested here.</em></p>
                <form method="post" enctype="multipart/form-data" class="wp-upload-form" action="#">
                    <input type="url" id="vrtestlink" name="vrtestlink" placeholder="Example: '.site_url().'" size= 60>
                    <input type="submit" name="install-plugin-submit" id="install-plugin-submit" class="page-title-action button action" value="submit" disabled=""> 
                </form>
        	</div>';
}

function visreg_upload_link(){
    global $wpdb;
    $vrOptnTabl = $wpdb->prefix . 'options';

    $optnID = $wpdb->get_var( "SELECT option_id FROM ". $vrOptnTabl ." WHERE post_id LIKE ".$listID );
    // $wpdb->replace( $vrOptnTabl , array(
    //                                     'option_id'=> $listID,
    //                                     'option_name'=> $vrLinkList,
    //                                     'option_value' => $visregLink),
    //                                     'autoload' => 'no'), 
    //                                     array('%d', '%s', '%s', '%s')
    //                                 );

}
