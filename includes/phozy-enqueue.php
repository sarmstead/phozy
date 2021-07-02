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

// Enqueue React scripts from asset-manifest.json
$phozy_manifest_json = json_decode( file_get_contents( PHOZY_ASSET_MANIFEST ), true )['files']; // Decode asset-manifest.json and access values at the key 'files'

# Enqueue main.css if exists in asset-manifest.json
if ( isset( $phozy_manifest_json[ 'main.css' ] ) ){
    wp_enqueue_style( 'phozy', get_site_url() . $phozy_manifest_json[ 'main.css' ] );
}