<?php
/*
 * Loads the Options Panel
 *
 * If you're loading from a child theme use stylesheet_directory
 * instead of template_directory
 */
define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/inc/' );
require_once dirname( __FILE__ ) . '/inc/options-framework.php';


/**
 * Roots includes
 */
// Miscellaneous constants
require_once locate_template('/lib/theme/constants.php');
// Utility functions
require_once locate_template('/lib/utils.php');
// Initial theme setup and constants
require_once locate_template('/lib/theme/init.php');
// Theme wrapper class
require_once locate_template('/lib/theme/wrapper.php');
// Sidebar class
require_once locate_template('/lib/content/sidebar/sidebar.php');
// Configuration
require_once locate_template('/lib/theme/config.php');
// Theme activation
require_once locate_template('/lib/theme/activation.php');
// Page titles
require_once locate_template('/lib/content/titles.php');
// Cleanup
require_once locate_template('/lib/theme/cleanup.php');
// Custom nav modifications
require_once locate_template('/lib/header/nav.php');
// Custom favicon
require_once locate_template('/lib/header/favicon.php');
// Breadcrumbs in the page headers
require_once locate_template('/lib/header/breadbrumbs.php');
// Custom post type framework
require_once locate_template('/lib/content/cptFramework.php');
// Boilerplate Google Privacy Policy
require_once locate_template('/lib/content/google-privacy-policy.php');
// Custom [gallery] modifications
require_once locate_template('/lib/content/gallery.php');
// Custom comments modifications
require_once locate_template('/lib/content/comments.php');
// Root relative URLs
require_once locate_template('/lib/theme/relative-urls.php');
// Sidebars and widgets
require_once locate_template('/lib/content/sidebar/widgets.php');
// Scripts and stylesheets
require_once locate_template('/lib/scripts.php');


/**
 * Lawyer theme includes
 */
// Blog configuration
require_once locate_template('/lib/content/blog.php');
// Custom excerpt function
require_once locate_template('/lib/content/excerpt.php');
// Color pickers
require_once locate_template('/lib/appearance/colors.php');
// Social media icon widget
require_once locate_template('/lib/content/sidebar/social.php');
// Print credits for the theme
require_once locate_template('/lib/content/footer/credit.php');
// Create slides post type
require_once locate_template('/lib/content/slider.php');
// Create attorneys post type
require_once locate_template('/lib/content/attorneys.php');
// Create practice areas post type
require_once locate_template('/lib/content/practiceAreas.php');
// Enables special features of the TinyMCE editor
require_once locate_template('/lib/admin/editor.php');
// Add custom meta boxes to the admin site
require_once locate_template('/lib/admin/adminOptions.php');
// Prints a disclaimer
require_once locate_template('/lib/content/footer/disclaimer.php');
// Adds prettyPhoto support to images
require_once locate_template('/lib/content/prettyPhoto.php');
// Enables shortcode use in places they aren't normally allowed
require_once locate_template('/lib/content/enableShortcodes.php');
// Modifies widgets as needed
require_once locate_template('/lib/content/footer/footer-widgets.php');
// The plugin recommender system
require_once locate_template('/lib/admin/plugin-recommender.php');
// The Featured Image attribution box
require_once locate_template('/lib/content/featured-image-attribution/featured-image-attribution.php');




//Initialize the update checker.
require_once 'lib/theme/theme-updates/theme-update-checker.php';
$example_update_checker = new ThemeUpdateChecker(
    MLF_SLUG,
    'http://conversioninsights.net/downloads/themes/mlf_version_metadata.json'
);




/**
 * A wrapper for getting settings created by the Meta Box plugin.
 * @param $fieldID string The ID (sans our theme's prefix) of the meta value you want to retrieve.
 *                         E.g., to get the "show page title" setting, pass in "show_page_title", not
 *                         "mlf_show_page_title".
 * @param $valueIfNotSet mixed Whatever you want to use as the default (in the event the
 *                             requested key is not set for the current post/page)
 * @param int $overridePostID Force us to look up the meta for a post with a specific ID
 * @return mixed The stored meta value, or $valueIfNotSet
 */
function mlfGetNormalizedMeta( $fieldID, $valueIfNotSet, $overridePostID=null ) {
    if( function_exists('rwmb_meta') ) {
        $field = rwmb_meta( THEME_PREFIX . "_{$fieldID}", array(), $overridePostID );
        if( $field === "" ) {
            $field = $valueIfNotSet;
        }
        return $field;
    } else {
        return $valueIfNotSet;
    }

}


// Disable extra columns for Yoast SEO plugin
add_filter( 'wpseo_use_page_analysis', '__return_false' );

