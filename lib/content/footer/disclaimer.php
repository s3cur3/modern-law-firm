<?php

function mlfPrintDisclaimer() {
    $disclaimer = of_get_option("disclaimer");
    if( $disclaimer ) {
        $disclaimer = apply_filters('the_content', $disclaimer);
        echo "<div class=\"disclaimer-footer\">$disclaimer</div>";
    }
}