<?php
add_action('init', 'mlfSetBlogOptions');
function mlfSetBlogOptions() {
    if ( function_exists( 'add_image_size' ) ) {
        add_image_size( MLF_FULL_WIDTH_WITH_SIDEBAR_IMG, 690, 9999 );
        add_image_size( MLF_THUMBNAIL_IMG, 275, 9999 );
    }
}