<?php

function mlfGetLinkWithText($url, $text) {
    return "<a href=\"$url\" target=\"_blank\">$text</a>";
}

function mlfPrintThemeCredit() {
    // Print a different link based on the current page ID
    global $wp_query;
    $id = $wp_query->post->ID;

    $mod = $id % 20;

    $root = "http://conversioninsights.net";
    $me = $root . "/tyler-young/";
    $themes = $root . "/free-wordpress-themes-law-firms/";
    switch ($mod) {
        case 0:
            echo "Theme by ", mlfGetLinkWithText($root, "Conversion Insights");
            break;
        case 1:
            echo mlfGetLinkWithText($themes, "Law Firm Theme"), " by Conversion Insights";
            break;
        case 2:
            echo "Theme created by ", mlfGetLinkWithText($me, "Tyler Young"), " of Conversion Insights";
            break;
        case 3:
            echo mlfGetLinkWithText($root, "Conversion Insights");
            break;
        case 4:
            echo mlfGetLinkWithText($themes, "Free Wordpress Themes for Law Firms");
            break;
        case 5:
            echo mlfGetLinkWithText($root, "Web Marketing for Law Firms"), " by Conversion Insights";
            break;
        case 6:
            echo mlfGetLinkWithText($root, "Web Marketing for Law Firms");
            break;
        case 7:
            echo mlfGetLinkWithText($themes, "Free Wordpress Themes for Lawyers"), " by ", mlfGetLinkWithText($root, "Conversion Insights");
            break;
        case 8:
            echo mlfGetLinkWithText($themes, "Free Wordpress Themes for Law Firms"), " from ", mlfGetLinkWithText($root, "Conversion Insights");
            break;
        case 9:
            echo "Theme created by ", mlfGetLinkWithText($root, "Conversion Insights");
            break;
        case 10:
            echo "Law firm marketing by ", mlfGetLinkWithText($root, "Conversion Insights");
            break;
        case 11:
            echo "Theme created by ", mlfGetLinkWithText($me, "Tyler Young"), " of Conversion Insights";
            break;
        case 12:
            echo "Theme by ", mlfGetLinkWithText($root, "Conversion Insights");
            break;
        case 13:
            echo mlfGetLinkWithText($themes, "Law Firm Theme"), " by Conversion Insights";
            break;
        case 14:
            echo "Theme created by ", mlfGetLinkWithText($me, "Tyler Young"), " of Conversion Insights";
            break;
        case 15:
            echo "Theme created by ", mlfGetLinkWithText($root, "Conversion Insights");
            break;
        case 16:
            echo mlfGetLinkWithText($themes, "Law Firm Theme"), " by Conversion Insights";
            break;
        case 17:
            echo "Theme created by ", mlfGetLinkWithText($me, "Tyler Young"), " of Conversion Insights";
            break;
        case 18:
            echo "Theme by ", mlfGetLinkWithText($root, "Conversion Insights");
            break;
        case 19:
            echo mlfGetLinkWithText($themes, "Law Firm Theme"), " by Conversion Insights";
            break;
        default:
            echo "Theme by ", mlfGetLinkWithText($root, "Conversion Insights");
            break;
    }


}