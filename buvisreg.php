<?php
/**
Plugin Name: Visual Regression Test - Demo
Plugin URI: http://davidjd.com/buvisreg
Description: This wordpress plugin is used to help generate a manageable list of URLs that would be used to run visual regression tests using <a href="https://garris.github.io/BackstopJS/">BackstopJS </a>. You can access the visual regression tool under Tools > Visual Regression Test.
Author: David Delonnay
Version: Theta 0.0.1
Author URI: http://davidjd.com/
*/

defined( 'ABSPATH' ) or die( '' );
define( 'BUVR', __FILE__ );
define( 'BUVR_DIR', untrailingslashit( dirname( BUVR ) ) );

// Call in functions
require BUVR_DIR .'/functions.php';

