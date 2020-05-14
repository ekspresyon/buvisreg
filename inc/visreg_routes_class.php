<?php

class visreg_routes_controller extends WP_REST_Posts_Controller{
	
	public function __construct( ) {
        $this->namespace = 'visreg/v1';
		$this->all_posts = 'allposts';
		$this->all_cats = 'allcategories';
		$this->all_archvs = 'allarchives';
		$this->all_tags = 'alltags';
		$this->some_posts = 'someposts';
    }

    /**
     * Registers the routes for the objects of the controller.
     */
    public function register_routes() {
 
        register_rest_route( $this->namespace,'/' . $this->all_posts,
                array(
                    'methods'             => WP_REST_Server::READABLE,
                    'callback'            => array( $this, 'get_allposts' ),
                )
            );
        register_rest_route( $this->namespace,'/' . $this->all_cats,
                array(
                    'methods'             => WP_REST_Server::READABLE,
                    'callback'            => array( $this, 'get_allcats' ),
                )
            );
        register_rest_route( $this->namespace,'/' . $this->all_archvs,
                array(
                    'methods'             => WP_REST_Server::READABLE,
                    'callback'            => array( $this, 'get_allarchives' ),
                )
            );
        register_rest_route( $this->namespace,'/' . $this->all_tags,
                array(
                    'methods'             => WP_REST_Server::READABLE,
                    'callback'            => array( $this, 'get_alltags' ),
                )
            );
        register_rest_route( $this->namespace,'/' . $this->some_posts,
                array(
                    'methods'             => WP_REST_Server::READABLE,
                    'callback'            => array( $this, 'get_some_posts' ),
                )
            );

    }

    function get_allposts(){
		// Request endpoint for "all public post types"
		  $args = array(
		      'post_type' => 'any',
		      'posts_per_page' => -1
		    );
		  $posts = get_posts($args);
		  $data = [];
		  $i = 0;

		  foreach ($posts as $post) {
		    $data[$i] = get_permalink($post->ID);
		    $i++;
		  }
		  if ( empty( $data ) ) {
		    return null;
		  }
		   return $data;
	}

	function get_allcats(){
		return "under development";
	}

	function get_allarchives(){
	    $args = array(
	                    'public'   => true,
	                    '_builtin'   => false,
	                );
	    $post_achvs = get_post_types($args, 'objects');
	    $archv_lnk = get_post_type_archive_link( $post_achvs );
	    $data = [];
	    $i = 0;

	    foreach ( $post_achvs as $post_achv ){
	      if($archv_lnk == false){
	        return;
	      }
	      $data[$i] = $archv_lnk;
	        $i++;
	    }
	    if ( empty( $data ) ) {
	        return null;
	    }
	      return $data;
	}

    function get_alltax(){
		return "under development";
	}
	

	function get_alltags(){
		return "under development";
	}  

	/* 
	*	Same as wp_parse list. Not available until version 5.1.0
	*/
	function vr_parse_list($list){
		if ( ! is_array( $list ) ) {
            return preg_split( '/[\s,]+/', $list, -1, PREG_SPLIT_NO_EMPTY );
            }	
        	return $list;
    }
	function get_some_posts($request){
		// Request endpoint for "all requested public post types"
		$somevrptypes = 'any';
		$requested_vrtypes = $this->vr_parse_list($request['ptselect']);

		if ( ! isset( $request['ptselect'] ) ) {
			$somevrptypes = 'any';
		}
		elseif ( 0 === count( $requested_vrtypes ) ) {
			$somevrptypes = 'any';
		}
		else{
			$somevrptypes = $requested_vrtypes;
		}

		  $args = array(
		      'post_type' => $somevrptypes,
		      'posts_per_page' => -1
		    );
		  $posts = get_posts($args);
		  $data = [];
		  $i = 0;

		  foreach ($posts as $post) {
		    $data[$i] = get_permalink($post->ID);
		    $i++;
		  }
		  if ( empty( $data ) ) {
		    return "got nothing";
		  }
		   return $data;
	}
    
}
// Function to register our new routes from the controller.
function visreg_register_posts_rest_routes() {
    $visregController = new visreg_routes_controller();
    $visregController->register_routes();
}
 
add_action( 'rest_api_init', 'visreg_register_posts_rest_routes' );