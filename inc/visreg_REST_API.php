<?php
/**
 * These custom endpoints are still in development. the current available options are
 * intended fro demo purposes and will mostlikely have to be more elaborate or deleted
 * if found to be redundent
 */

// Request endpoint for "Posts" FOR TEST
function visreg_reqst_pst(){
  $args = array(
      'post_type'=> 'post'
  );
  $posts = get_posts($args);
  $data = [];
  $i = 0;

  foreach ($posts as $post) {
    $data[$i]['id'] = $post ->ID;
    $data[$i]['post_type'] = get_post_type($post->ID);
    $data[$i]['title'] = get_the_title($post->ID);
    $data[$i]['permalink'] = get_permalink($post ->ID);
    $i++;
  }
  return $data;
}
add_action( 'rest_api_init', function () {
  register_rest_route( 'visreg/v1', 'posts', array(
    'methods' => 'GET',
    'callback' => 'visreg_reqst_pst',
  ) );
} );

// Request endpoint for "Pages" FOR TEST
function visreg_reqst_pg(){
  $args = array(
      'post_type'=> 'page'
  );
  $posts = get_posts($args);
  $data = [];
  $i = 0;

  foreach ($posts as $post) {
    $data[$i]['id'] = $post->ID;
    $data[$i]['post_type'] = get_post_type($post->ID);
    $data[$i]['title'] = get_the_title($post->ID);
    $data[$i]['permalink'] = get_permalink($post->ID);
    $i++;
  }
  return $data;
}
add_action( 'rest_api_init', function () {
  register_rest_route( 'visreg/v1', 'pages', array(
    'methods' => 'GET',
    'callback' => 'visreg_reqst_pg',
  ) );
} );

// Request endpoint for "flagged Pages and Posts" FOR TEST
function visreg_reqst_flagged(){
  $args = array(
      'post_type' => 'any',
      'meta_key' => '_vr_status_key',
      'meta_value' => 1,
      'numberposts' => -1
    );
  $posts = get_posts($args);
  $data = [];
  $i = 0;

  foreach ($posts as $post) {
    $data[$i]['id'] = $post->ID;
    $data[$i]['post_type'] = get_post_type($post->ID);
    $data[$i]['title'] = get_the_title($post->ID);
    $data[$i]['permalink'] = get_permalink($post->ID);
    $i++;
  }
  return $data;
}
add_action( 'rest_api_init', function () {
  register_rest_route( 'visreg/v1', 'flagged', array(
    'methods' => 'GET',
    'callback' => 'visreg_reqst_flagged'
  ) );
} );


// Request endpoint for "all post types"
function visreg_reqst_all(){
  $args = array(
      'post_type' => 'any',
      'numberposts' => -1
    );
  $posts = get_posts($args);
  $data = [];
  $i = 0;

  foreach ($posts as $post) {
    $data[$i]['id'] = $post->ID;
    $data[$i]['post_type'] = get_post_type($post->ID);
    $data[$i]['title'] = get_the_title($post->ID);
    $data[$i]['permalink'] = get_permalink($post->ID);
    $data[$i]['modified'] = get_the_modified_date($post->ID);
    $i++;
  }
  return $data;
}
add_action( 'rest_api_init', function () {
  register_rest_route( 'visreg/v1', 'everything', array(
    'methods' => 'GET',
    'callback' => 'visreg_reqst_all'
  ) );
} );