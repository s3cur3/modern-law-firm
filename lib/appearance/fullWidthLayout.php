<?php

function ciGetContainerClass(){
    $fullWidthContainerSpecified = of_get_option( 'full_width_container' );

    // Override with GET parms
    if( isset($_GET['layout']) && $_GET['layout'] == "full" ) {
        $fullWidthContainerSpecified = true;
    } else {
        if( isset($_GET['layout']) && $_GET['layout'] == "normal" ) {
            $fullWidthContainerSpecified = false;
        }
    }
    $needsFullWidthContainer = $fullWidthContainerSpecified && !roots_display_sidebar();

    $containerClass = "container";
    if( $needsFullWidthContainer ) {
        $containerClass .= "-fluid";
    }
    if( $fullWidthContainerSpecified ) {
        $containerClass .= " pseudo-fluid";
    }
    return $containerClass;
}



 