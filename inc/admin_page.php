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
    <p id="vrsiteUrl"><?php echo site_url();?></p>
    <div class="wrap">
        <h1>Visual regression test</h1>
        <!-- <hr> -->
        <em>To use this tool, select a post type that you wish to test and add filtering options if necessary. Click on the "<strong>Generate list</strong>" button to see a list of the different post contained within you selection.</em>
        <hr>

        <!-- The tabs that have been loade by the buttons -->
        
            <?php require BUVR_DIR .'/inc/tabs/linksgen.php';?>
       
        
        <div id="cpReqUrl" class="tablenav">
            <hr>
            <span class="req-url-tag">API route: </span>
                <code id="vrapiRoute"></code>
                <button id="copyUrlbtn" class="url-copy-btn" onclick="vrAPIurlcopy()">
                    Copy
                </button>
                <br><br>
                <span class="req-url-tag">API bash: </span>
                <code id="vrapiBash"></code>
                <button id="copyUrlbtn" class="url-copy-btn" onclick="vrAPIbshcopy()">
                    Copy
                </button>
                
        </div>
        <div id="vrlinks">
            
        </div>

    </div>
<?php
}