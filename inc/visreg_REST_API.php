<?php
/**
 * Grab latest post title by an author!
 *
 * @param array $data Options for the function.
 * @return string|null Post title for the latest,  * or null if none.
 */
function visreg_reqst_pst(){
	$args = array(
			'post_type'=> 'post'
	);
 	$posts = get_posts($args);
 	$data = [];
 	$i = 0;

 	foreach ($posts as $post) {
 		$data[$i]['id'] = $post ->ID;
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

function visreg_reqst_pg(){
	$args = array(
			'post_type'=> 'page'
	);
 	$posts = get_posts($args);
 	$data = [];
 	$i = 0;

 	foreach ($posts as $post) {
 		$data[$i]['id'] = $post->ID;
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