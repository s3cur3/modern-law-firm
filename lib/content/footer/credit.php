<?php

function ciGetThemeCredit() {
    function getLinkWithText($url, $text) {
        return "<a href=\"$url\" target=\"_blank\">$text</a>";
    }
    
    // Print a different link based on the current page ID
    global $wp_query;
    $id = $wp_query->post->ID;

    $root = "http://conversioninsights.net";
    $me = $root . "/tyler-young/";
    $designServices = $root . "/services/web-design/";
    $themes = $root . "/free-wordpress-themes-law-firms/";
    $project = $themes;

    $choices = array(
        /* Project-specific */
        getLinkWithText($themes, "Free Wordpress Themes for Law Firms"),
        getLinkWithText($project, "Site created by Conversion Insights"),
        getLinkWithText($project, "Designed by Conversion Insights"),

        /* Law-firm specific */
        getLinkWithText($root, "Web Marketing for Law Firms") . " by Conversion Insights",
        getLinkWithText($root, "Law Firm Marketing Consultant"),
        getLinkWithText($root, "Web Marketing for Law Firms"),
        "Law firm marketing by " . getLinkWithText($root, "Conversion Insights"),
        getLinkWithText($themes, "Law Firm Theme") . " by Conversion Insights",
        getLinkWithText($themes, "Free WordPress themes for lawyers") . " by " . getLinkWithText($root, "Conversion Insights"),
        getLinkWithText($themes, "Free WordPress themes for law firms") . " by " . getLinkWithText($root, "Conversion Insights"),


        /* Kansas City-specific *
        getLinkWithText($designServices, "Kansas City Web Design"), */

        /* Generic */
        "WordPress theme created by " . getLinkWithText($me, "Tyler Young") . " of Conversion Insights",
        "WordPress theme by " . getLinkWithText($root, "Conversion Insights"),
        getLinkWithText($root, "Conversion Insights"),
        getLinkWithText($root, "Web Marketing") . " by Conversion Insights",
        "Web site created by " . getLinkWithText($me, "Tyler Young") . " of Conversion Insights",
        "By " .getLinkWithText($root, "Conversion Insights"),
        "Site created by " . getLinkWithText($root, "Conversion Insights"),
        "Designed by " . getLinkWithText($root, "Conversion Insights"),
        getLinkWithText($designServices, "Web Design") . " by Conversion Insights",
        getLinkWithText($designServices, "Web Design by Conversion Insights"),
        "Web design by " . getLinkWithText($me, "Tyler Young") . " of Conversion Insights",
    );

    return $choices[ $id % count($choices) ];
}

function ciPrintThemeCredit() {
    echo ciGetThemeCredit();
}