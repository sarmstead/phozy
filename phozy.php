<?php
/**
 * Plugin Name:       Phozy
 * Plugin URI:        https://github.com/sarmstead/phozy/
 * Description:       Finally, an efficient way to upload your videos to YouTube directly from WordPress.
 * Version:           0.1.0
 * Requires at least: 5.7.2
 * Author:            Sunjay Armstead
 * Author URI:        https://github.com/sarmstead/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 */

 // If ABSPATH is defined continue script, else stop script
defined( 'ABSPATH' ) || die( 'Direct script access disallowed.' );

// Define path to React application directory
define( 'PHOZY_REACT_PATH', plugin_dir_path( __FILE__ ) . '/phozy-react' );

// Define path to React manifest file to access list of React JS and CSS files
define ( 'PHOZY_ASSET_MANIFEST', PHOZY_REACT_PATH . '/build/asset-manifest.json' );

// Define includes directory path for additional PHP files
define ( 'PHOZY_INCLUDES', plugin_dir_path( __FILE__ ) . '/includes' );