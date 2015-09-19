<?php

add_action('ci_meta', 'loadGoogleFonts');
function loadGoogleFonts() {
    function filterVariants($listOfVariants) {
        $selected = array();
        if( is_array($listOfVariants) && count($listOfVariants) > 0 ) {
            foreach( $listOfVariants as $variant => $checked ) {
                if( $checked ) {
                    $selected[] = $variant;
                }
            }
        }
        return $selected;
    }

    $fonts = array();

    $fontLocations = array(
        'title' => "Bree+Serif",
        'heading' => "Bree+Serif",
        'widget_title' => "Open+Sans",
        'body' => "Open+Sans"
    );
    foreach( $fontLocations as $location => $default ) {
        $optionID = $location . '_font_family';

        $fontFamily = of_get_option($optionID, $default);
        if( $fontFamily ) {
            $variants = filterVariants(of_get_option($location . '_font_variants'));
            if( array_key_exists($fontFamily, $fonts) ) {
                $fonts[$fontFamily] = array_unique( array_merge($fonts[$fontFamily], $variants) );
            } else {
                $fonts[$fontFamily] = $variants;
            }
        }
    }


    $fontCalls = array();
    foreach( $fonts as $family => $variantList ) {
        $variants = "";
        if( count($variantList) > 0 ) {
            $variants = array_pop($variantList);
            foreach( $variantList as $variant ) {
                $variants .= "," . $variant;
            }
        }
        if( strlen($variants) ) $variants = ":{$variants}";

        $fontCalls[] = "{$family}{$variants}";
    }

    $url = "http://fonts.googleapis.com/css?family=" . array_pop($fontCalls);
    foreach( $fontCalls as $call ) {
        $url .= "|{$call}";
    }

    echo "\n<link rel=\"stylesheet\" type=\"text/css\" href=\"{$url}\">";
}