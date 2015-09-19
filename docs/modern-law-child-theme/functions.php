<?php

/*================================================================
 * NOTE: This code will be *added* to the the theme's
 * standard functions.php, rather than overriding it.
 *
 * That means you can add functionality here without worrying about
 * breaking existing functions.
 *================================================================*/


function childThemeScripts() {
    wp_enqueue_style('child-theme-style', get_stylesheet_directory_uri() . '/style.css', array());
}

// NOTE: Enqueue styles with priority 100 to ensure they override any
// stock styles.
add_action('wp_enqueue_scripts', 'childThemeScripts', 100);


function childThemeFunction() {
    echo "This function was called from the child theme.";
}