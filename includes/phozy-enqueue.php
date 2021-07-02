<?php
// This files enqueues scripts and styles for Phozy's React application

// If ABSPATH is defined continue script, else stop script
defined( 'ABSPATH' ) || die( 'Direct script access disallowed.' );

// Run scripts parsing during 'init' phase of WordPress load process (after theme and other plugins are loaded)
function phozy_parser() {
    add_filter( 'script_loader_tag', function( $tag, $handle ) {
        if( !preg_match( '/^phozy-/', $handle ) ) {
            return $tag;
        }
        // Rewrite script tag to load scripts asynchronously
        return str_replace( ' src', ' async defer src', $tag );
    }, 10, 2 );
}

add_action( 'init', phozy_parser() );