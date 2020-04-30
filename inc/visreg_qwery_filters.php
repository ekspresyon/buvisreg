<?php

	function get_allposts(){

	}
	function get_alltax(){
		
	}
	function get_allcats(){
		
	}

	function get_alltags(){
		
	}

	function get_allarchives(){
	    $args = array(
	                    'public'   => true,
	                    '_builtin'   => false,
	                );
	    $post_types = get_post_types($args, 'objects');
	    $archv_lnk = get_post_type_archive_link( $post_type );
	    $data = [];
	    $i = 0;

	    foreach ( $post_types  as $post_type ){
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