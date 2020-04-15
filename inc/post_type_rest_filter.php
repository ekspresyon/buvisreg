<?php
/********************************
 Not sure if this is running yet 
 ********************************/



add_action( 'rest_api_init', 'wp_rest_filter_add_filters' );
 /**
  * Add the necessary filter to each post type
  **/
function wp_rest_filter_add_filters() {
    foreach ( get_post_types( array( 'show_in_rest' => true ), 'objects' ) as $post_type ) {
        add_filter( 'rest_' . $post_type->name . '_query', 'wp_rest_filter_add_filter_param', 10, 2 );
    }
}
/**
 * Add the filter parameter
 *
 * @param  array           $args    The query arguments.
 * @param  WP_REST_Request $request Full details about the request.
 * @return array $args.
 **/
function wp_rest_filter_add_filter_param( $args, $request ) {
    // Bail out if no filter parameter is set.
    if ( empty( $request['filter'] ) || ! is_array( $request['filter'] ) ) {
        return $args;
    }
    $filter = $request['filter'];
    if ( isset( $filter['posts_per_page'] ) && ( (int) $filter['posts_per_page'] >= 1 && (int) $filter['posts_per_page'] <= 100 ) ) {
        $args['posts_per_page'] = $filter['posts_per_page'];
    }
    global $wp;
    $vars = apply_filters( 'rest_query_vars', $wp->public_query_vars );
    function allow_meta_query( $valid_vars )
    {
        $valid_vars = array_merge( $valid_vars, array( 'meta_query', 'meta_key', 'meta_value', 'meta_compare' ) );
        return $valid_vars;
    }
    $vars = allow_meta_query( $vars );

    foreach ( $vars as $var ) {
        if ( isset( $filter[ $var ] ) ) {
            $args[ $var ] = $filter[ $var ];
        }
    }
    return $args;
}

/*
Callback that checks if each post type is registered and marked as available to be shown in the REST API
*/
add_action( 'rest_post_query', function( $args, $request ){
    $post_types = $request->get_param( 'type' );
    if( ! empty( $post_types ) ){
        if( is_string( $post_types ) ){
            $post_types = array( $post_types );
            foreach ( $post_types as $i => $post_type ){
                $object=  get_post_type_object( $post_type );
                if( ! $object || ! $object->show_in_rest   ){
                    unset( $post_types[ $i ] );
                }
            }


        }
        $post_types[] = $args[ 'post_type' ];
        $args[ 'post_type' ] = $post_types;
    }
    return $args;
}, 10, 2 );


/*
This filter exposes an array, which is keyed by endpoint. 
*/
add_action( 'rest_endpoints', function( $endpoints ){

    if( isset( $endpoints[ 'wp/v2/posts' ] ) ){
        foreach( $endpoints[ 'wp/v2/posts' ] as &$post_endpoint ){
            if( 'GET' == $post_endpoint[ 'METHOD' ] ){
                $post_endpoint[ 'args' ][ 'type' ] = array(
                    'description' => 'Post types',
                    'type' => 'array',
                    'required' => false,
                    'default' => 'post'
                );
            }
        }
    }
    return $endpoints;
}, 15 );
