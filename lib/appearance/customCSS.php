<?php


function printCustomCSS() {
    $css = of_get_option('custom_css');

    if( $css ) {
        echo "\n\n<!-- Custom styles from the Theme Options admin menu --><style>\n";
        echo html_entity_decode($css);
        echo "</style>\n\n";
    }
}

add_action('ci_styles', 'printCustomCSS');




 