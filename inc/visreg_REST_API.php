<?php
/**
 * These custom endpoints are still in development. the current available options are
 * intended fro demo purposes and will mostlikely have to be more elaborate or deleted
 * if found to be redundent
 */



// Request endpoint for "Posts" FOR TEST
function visreg_reqst_pst(){
  $args = array(
      'post_type'=> 'post',
      'posts_per_page' => -1
  );
  $posts = get_posts($args);
  $data = [];
  $i = 0;

  foreach ($posts as $post) {
    $data[$i] = get_permalink($post->ID);
    $i++;
  }
  return $data;
}
add_action( 'rest_api_init', function () {

} );

// Request endpoint for "Pages" FOR TEST
function visreg_reqst_pg(){
  $args = array(
      'post_type'=> 'page',
      'posts_per_page'=> -1
  );
  $posts = get_posts($args);
  $data = [];
  $i = 0;

  foreach ($posts as $post) {
    $data[$i] = get_permalink($post->ID);
    $i++;
  }
  return $data;
}



// Request endpoint for "all post types"
function visreg_reqst_all(){
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

// Call API visreg filter class
require BUVR_DIR .'/inc/visreg_qwery_filters.php';

add_action( 'rest_api_init', function () {
  register_rest_route( 'visreg/v1', 'posts', array(
    'methods' => 'GET',
    'callback' => 'visreg_reqst_pst',
  ) );
  register_rest_route( 'visreg/v1', 'pages', array(
    'methods' => 'GET',
    'callback' => 'visreg_reqst_pg',
  ) );
  register_rest_route( 'visreg/v1/', 'allposts', array(
    'methods' => 'GET',
    'callback' => 'visreg_reqst_all'
  ) );
  register_rest_route( 'visreg/v1/', 'allarchives', array(
    'methods' => 'GET',
    'callback' => 'get_allarchives'
  ) );
  register_rest_route( 'visreg/v1/', 'allcategories', array(
    'methods' => 'GET',
    'callback' => 'get_allcats'
  ) );
} );