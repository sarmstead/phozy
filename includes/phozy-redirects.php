<?php
// This file blocks Phozy's source file access from bad actors

// Redirect React src directory to 404 page
function phozy_src_checker() {
    // Find Phozy React source code directory
    $is_src_directory = preg_match("/phozy-react\/src\/(.*)/", $_SERVER['REQUEST_URI'] );
	
    if ( $is_src_directory === 1 ) {
        status_header(404);
    }
}

add_action('template_redirect', 'phozy_src_checker');