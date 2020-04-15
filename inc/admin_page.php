<?php
//** For testin purpose option 1
//require_once BUVR_DIR. '/inc/url_list_table.php';

//** For testin purpose option 2
require_once BUVR_DIR. '/inc/visreg_url_list_table.php';



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
        wp_register_script('vr-links-upload-toggle', plugin_dir_url(__FILE__).'assets/js/links-upload-toggle.js', array(), false, true);
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
        <!-- <p>Below is a list table of the links selected by site managers to be tested when update/upgrades are scheduled. you can remove or add test URLs as needed.</p> -->
        <hr>
    
    
        <div class="api-links tablenav">
            
                <select id="linkselector"  onchange="vrOptndisp(this.value)">
                    <option value="0" data-url="http://wp.local/wp-json/visreg/v1/flagged">Flagged</option>
                    <option value="0" data-url="http://wp.local/wp-json/wp/v2/posts">Posts</option>
                    <option value="0" data-url="http://wp.local/wp-json/wp/v2/pages">Pages</option>
                    <option value="0" disabled>Random</option>
                    <option value="optnTrig" >more options</option>
                </select>

                <button id="listgenbtn" class="page-title-action button action">
                    Generate list
                </button>
            
            
        </div>
        <div id="vr-more-option" class="vr-more-option">
            <h3>More options</h3>
                <form id="apireqform" action="<?php echo site_url();?>" method="get" accept-charset="utf-8">
                    <div class="tablenav">

                        <select class="vrfltroptn">
                            <!-- <option value="0">All post types</option> -->
                            <?php
                                $post_types = get_post_types(array(), 'objects');
                                 
                                foreach ( $post_types  as $post_type ) {
                                   echo '<option value =' . $post_type->name .'s'. '>';
                                   echo $post_type->labels->singular_name;
                                   echo '</option>';
                                }
                            ?>
                        </select>
                        <select class="vrfltroptn">
                            <option value="0">All available links</option>
                            <option value="1">Flagged only</option>
                        </select>
                        <select class="vrdtfltroptn" onchange="vrdatepick(this.value)">
                            <option value="0">Any date</option>
                            <option value="7776000000">Last 90 days</option>
                            <option value="5184000000">Last 60 days</option>
                            <option value="2592000000">Last 30 days</option>
                            <option value="1">Date range</option>
                        </select>

                        <div id="datePicker" class="hide">
                            <label>From :<input type="date" class="vrdtfltroptn" name="startDate" value=""></label>
                            <label>to :<input type="date" class="vrdtfltroptn" name="endDate" value=""></label>
                        </div>
                        
                    </div>  <!-- end .tablenav -->

                    <button id="listgenbtnplus" class="page-title-action button action">
                        Generate list
                    </button>         
                </form>
                
            </div><!--end #vr-more-option --> 
            <div id="cpReqUrl" class="tablenav hide">
                <span class="req-url-tag">API request link: </span>
                <code id="vrapiRoute"></code>
                <button id="copyUrlbtn" class="url-copy-btn" onclick="vrAPIurlcopy()">
                    Copy
                </button>

            </div>
            
        <div id="vrlinks">
            
        </div>
    </div>
<?php
}