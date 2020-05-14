<?php

/* Generate menu link */
function buvis_reg_menu()
{

    global $buvis_reg_menu_hook;
    // Place under tools with "add_management_page" hook
    // For placement as top menu link use "add_menu_page" hook
    $buvis_reg_menu_hook = add_management_page(
        'VisReg overview', // page title
        'Visual Regression Test', // page name
        'manage_options', // admin permission
        'bu-visreg-test', //slug
        'bu_visreg_admin_page' // call back for page layout
    );
    add_action('admin_enqueue_scripts', 'upload_links_form_script'); // pull scripts to be loaded
}

// "network_admin_menu" hook does not give permission to super admin
// using "admin_menu" hook for now
add_action('admin_menu', 'buvis_reg_menu');

// scripts for admin page
function upload_links_form_script($hook)
{
    global $buvis_reg_menu_hook;

    if ($hook != $buvis_reg_menu_hook) {
        return;
    }
        wp_enqueue_script('wp_api');
        wp_register_style('visreg-tab-css', plugin_dir_url(__FILE__).'assets/css/visreg.css', array(), false, false);
        // wp_register_script('vr-links-upload-toggle', plugin_dir_url(__FILE__).'assets/js/links-upload-toggle.js', array(), false, true);
        wp_register_script('vr-admin-page-tabl', plugin_dir_url(__FILE__).'assets/js/vr_data_table.js', array(), false, true);
        wp_enqueue_style('visreg-tab-css');
        wp_enqueue_script(array('vr-links-upload-toggle',
                                'vr-admin-page-tabl'
                                ));
}
//add_action('admin_enqueue_scripts','upload_links_form_script');

/* Generate visual regression URL management page */
function bu_visreg_admin_page()
{
    
    // Block users with wrong clearance level
    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.'));
    } ?>
    <div class="wrap">
        <h1>Visual regression test</h1>
        <!-- <hr> -->
        <em>To use this tool, select a post type that you wish to test and add filtering options if necessary. Click on the "<strong>Generate list</strong>" button to see a list of the different post contained within you selection.</em>
        <hr>
        <!-- The buttons on top of the page to pen the tabs -->
        <button class="tablink" onclick="opnVrOptnTab('vrlinksgen', this, '#0073aa')" id="defaultOpen">Routes</button>
        <button class="tablink" onclick="opnVrOptnTab('vrpresets', this, '#0073aa')">Presets</button>
        <button class="tablink" onclick="opnVrOptnTab('vrcustom', this, '#0073aa')" >Custom search</button>
        <button class="tablink" onclick="opnVrOptnTab('vrupload', this, '#0073aa')">Manual upload</button>
        <button disabled class="tablink" onclick="opnVrOptnTab('vrrandom', this, '#0073aa')">Random</button>

        <!-- The tabs that have been loade by the buttons -->
        <div id="vrlinksgen" class="tabcontent">
            <?php require BUVR_DIR .'/inc/tabs/linksgen.php';?>
        </div>
        <div id="vrpresets" class="tabcontent">
            <h1>Under development</h1>
            <?php require BUVR_DIR .'/inc/tabs/presets.php';?>
        </div>

        <div id="vrcustom" class="tabcontent">
            <h1>Under development</h1>
            <?php require BUVR_DIR .'/inc/tabs/custom-search.php';?>
        </div>

        <div id="vrupload" class="tabcontent">

            <h1>Under development</h1>
          <?php 
            require BUVR_DIR .'/inc/tabs/manual-uploads.php';
            vr_manual_uploads();
          ?>

          <!-- <p>Please choose a list to add the link into. You can type a new list mane or leave it blank do add to the <strong>Default</strong> list</p>
          <input type="text" name="" value="" maxlength="15"> -->
            
        </div>

        <div id="vrrandom" class="tabcontent">
            <h1>Under development</h1>
          <?php //require BUVR_DIR .'/inc/tabs/manual-uploads.php'?>
        </div>
        
        <div id="cpReqUrl" class="tablenav hide">
                <span class="req-url-tag">API request link: </span>
                <code id="vrapiRoute"></code>
                <button id="copyUrlbtn" class="url-copy-btn" onclick="vrAPIurlcopy()">
                    Copy
                </button>
        </div>
        <div id="vrlinks">
            
        </div>
        <?php
            // $request = new WP_REST_Request( 'GET', '/wp/v2/posts' );
            // // Set one or more request query parameters
            // $request->set_param( 'per_page', 20 );
            // $response = rest_do_request( $request );
            // echo $response;
        ?>
    </div>
<?php
}