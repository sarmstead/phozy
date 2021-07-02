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

# Decode asset-manifest.json and access values at the key 'files'
$phozy_manifest_json = json_decode( file_get_contents( PHOZY_ASSET_MANIFEST ), true )[ 'files' ];

# Enqueue main.css if exists in asset-manifest.json
if ( isset( $phozy_manifest_json[ 'main.css' ] ) ){
    wp_enqueue_style( 'phozy', get_site_url() . $phozy_manifest_json[ 'main.css' ] );
}

# Enqueue runtime-main.js
wp_enqueue_script( 'phozy-runtime', get_site_url() . $phozy_manifest_json[ 'runtime-main.js' ], array(), null, true );

# Enqueue main.js and register runtime script as dependency
wp_enqueue_script( 'phozy-main', get_site_url() . $phozy_manifest_json[ 'main.js' ], array( 'phozy-runtime' ), null, true );

# Loop through $phozy_manifest_json array and enqueue chunk files programmatically 
foreach ( $phozy_manifest_json as $key => $value ) {
    // Parse asset-manifest.json for keys named static/js/<hash>.chunk.js. Enqueue these files after main.js.
    if ( preg_match( '@static/js/(.*)\.chunk\.js@', $key, $matches ) ) {
        if ( $matches && is_array( $matches ) && count( $matches ) === 2) {
            $chunk_file_name = "phozy-" . preg_replace( '/[^A-Za-z0-9_]/', '-', $matches[1] );
            wp_enqueue_script( $name, get_site_url() . $value, array( 'erw-main' ), null, true );
        }
    }

    // Parse asset-manifest.json for keys named static/css/<hash>.chunk.css. Enqueue these files after each static/js/<hash>.chunk.js.
    if ( preg_match( '@static/css/(.*)\.chunk\.css@', $key, $matches ) ) {
        if ( $matches && is_array( $matches ) && count( $matches ) === 2) {
            $chunk_file_name = "phozy-" . preg_replace( '/[^A-Za-z0-9_]/', '-', $matches[1] );
            wp_enqueue_style( $name, get_site_url() . $value, array( 'erw' ), null );
        }
    }
}