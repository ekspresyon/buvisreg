<?php
/**
 * PART 2. Defining Custom Table List
 * ============================================================================
 *
 * In this part you are going to define custom table list class,
 * that will display your database records in nice looking table
 *
 * http://codex.wordpress.org/Class_Reference/WP_List_Table
 * http://wordpress.org/extend/plugins/custom-list-table-example/
 */

if (!class_exists('WP_List_Table')) {
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}

class VisReg_url_List_Table extends WP_List_Table {

	function __construct()
    {
        global $status, $page;

        parent::__construct(array(
            'singular' => 'link',
            'plural' => 'links',
        ));
    }

	/**
     * [REQUIRED] this is a default column renderer
     *
     * @param $item - row (key, value array)
     * @param $column_name - string (key)
     * @return HTML
     */
    function column_default($item, $column_name)
    {
        return $item[$column_name];
    }

    /**
     * Returns an associative array containing the bulk action
     *
     * @return array
     */
    public function get_bulk_actions() {
      $actions = [
        //'bulk-delete' => 'Delete',
        'bulk-test' => 'Test'
      ];

      return $actions;
    }

    /**
     * [REQUIRED] this is how checkbox column renders
     *
     * @param $item - row (key, value array)
     * @return HTML
     */

    function column_cb($item)
    {
        return sprintf(
            '<input type="checkbox" name="id[]" value="%s" />',
            $item['id']
        );
    }

    /**
     * [REQUIRED] This method return columns to display in table
     * you can skip columns that you do not want to show
     * like content, or description
     *
     * @return array
     */
    function get_columns()
    {
        $columns = array(
            'cb' => '<input type="checkbox" />', //Render a checkbox instead of text
            'post_title' => __('Title'),
		    'guid'      => __('URL'),
		    'post_type' => __('Post type'),
		    'post_last_test' => __('Last tested')
        );
        return $columns;
    }

    function get_sortable_columns() {
        $sortable_columns = array(
        'action'  => array('action',false),
        );
        return $sortable_columns;
    }

    /**
     * [REQUIRED] This is the most important method
     *
     * It will get rows from database and prepare them to be showed in table
     */
    function prepare_items(){

    	global $wpdb;
		$visregTabl = $wpdb->prefix . 'visreg';
        
        // constant, how much records will be shown per page
        $per_page = 5; 
        $current_page = $this->get_pagenum();
        if ( 1 < $current_page ) {
            $offset = $per_page * ( $current_page - 1 );
        } else {
            $offset = 0;
        }

        //Retrieve $customvar for use in query to get items.
        $search = '';
        $customvar = ( isset($_REQUEST['customvar']) ? $_REQUEST['customvar'] : '');
        if($customvar != '') {
            $search_custom_vars= "AND action LIKE '%" . esc_sql( $wpdb->esc_like( $customvar ) ) . "%'";
        } else  {
            $search_custom_vars = '';
        }
        if ( ! empty( $_REQUEST['s'] ) ) {
            $search = "AND email LIKE '%" . esc_sql( $wpdb->esc_like( $_REQUEST['s'] ) ) . "%'";
        }

        /** Process bulk action */
        //$this->process_bulk_action();


        // here we configure table headers, defined in our methods
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();
        $this->_column_headers = array($columns, $hidden, $sortable);

        // will be used in pagination settings
        $total_items = $wpdb->get_var("SELECT COUNT(id) FROM $visregTabl");

        // prepare query params, as usual current page, order by and order direction
        $paged = isset($_REQUEST['paged']) ? max(0, intval($_REQUEST['paged'] - 1) * $per_page) : 0;

        $count = $wpdb->get_var( "SELECT COUNT(id) FROM visregTabl WHERE 1 = 1 {$search} {$search_custom_vars}" );

        // [REQUIRED] define $items array
        // notice that last argument is ARRAY_A, so we will retrieve array
        $this->items = $wpdb->get_results("SELECT * FROM $visregTabl", ARRAY_A);

        // [REQUIRED] configure pagination
        $this->set_pagination_args(array(
             'total_items' => $total_items, // total items defined above
             'per_page' => $per_page, // per page constant defined at top of method
             'total_pages' => ceil($total_items / $per_page) // calculate pages count
         ));
    }

}
