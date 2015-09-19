<?php

/**
 * Register meta boxes
 *
 * For a demo of available options, see https://github.com/rilwis/meta-box/blob/master/demo/demo.php
 *
 * @param $meta_boxes void
 * @return array The filled meta boxes
 */
function mlfRegisterMetaBoxes( $meta_boxes ) {
    global $ciSidebars;
    reset($ciSidebars);
    /**
     * Prefix of meta keys (optional)
     * Use underscore (_) at the beginning to make keys hidden
     * Alt.: You also can make prefix empty to disable it
     */
    // Better have an underscore as the last character!
    $prefix = MLF_THEME_PREFIX . '_';

    // 1st meta box
    $meta_boxes[] = array(
        // Meta box id, UNIQUE per meta box. Optional since 4.1.5
        'id' => 'standard',

        // Meta box title - Will appear at the drag and drop handle bar. Required.
        'title' => __( 'The Modern Law Firm theme options', MLF_TEXT_DOMAIN ),

        // Post types, accept custom post types as well - DEFAULT is array('post'). Optional.
        'pages' => array( 'post', 'page', 'modern-law-attorney', 'modern-law-practice' ),

        // Where the meta box appear: normal (default), advanced, side. Optional.
        'context' => 'normal',

        // Order of meta box: high (default), low. Optional.
        'priority' => 'high',

        // Auto save: true, false (default). Optional.
        'autosave' => true,

        // List of meta fields
        'fields' => array(
            // Show page title
            array(
                'name' => __( 'Show page title?', MLF_TEXT_DOMAIN ),
                'id'   => "{$prefix}show_page_title",
                'type' => 'checkbox',
                // Value can be 0 or 1
                'std'  => 1,
            ),
            array(
                'name' => __( 'Show page sidebar?', MLF_TEXT_DOMAIN ),
                'id'   => "{$prefix}show_page_sidebar",
                'type' => 'checkbox',
                // Value can be 0 or 1
                'std'  => 1,
            ),
            array(
                'name' => __( 'Show featured image?', MLF_TEXT_DOMAIN ),
                'id'   => "{$prefix}show_featured_img",
                'type' => 'checkbox',
                // Value can be 0 or 1
                'std'  => 1,
            ),
            array(
                'name'     => __( 'Which sidebar should we use?', MLF_TEXT_DOMAIN ),
                'id'       => "{$prefix}sidebar",
                'type'     => 'select',
                // Array of 'value' => 'Label' pairs for select box
                'options'  => $ciSidebars,
                // Select multiple values, optional. Default is false.
                'multiple'    => false,
                'std'         => key($ciSidebars),
                'placeholder' => __( 'Select an Item', MLF_TEXT_DOMAIN ),
            ),
            // Top-of-page image slider
            array(
                'name' => __( 'Show giant image slider at top of page?', MLF_TEXT_DOMAIN ),
                'id'   => "{$prefix}top_img_slider",
                'type' => 'checkbox',
                // Value can be 0 or 1
                'std' => 0,
            ),
            array(
                'name' => __( 'Slider delay', MLF_TEXT_DOMAIN ),
                'desc' => __( 'Wait this many seconds before moving from one slide to the next (for the slider at the top of page)', MLF_TEXT_DOMAIN),
                'id'   => "{$prefix}top_img_slider_interval",
                'type' => 'text',
                'std' => 5,
            ),
            // Taxonomy
            array(
                // Field name - Will be used as label
                'name'  => __( 'Show slides from this category at the top of the page (leave blank to show all)', MLF_TEXT_DOMAIN ),
                // Field ID, i.e. the meta key
                'id'    => "{$prefix}top_img_slider_cat_string",
                // Field description (optional)
                'desc'  => __( 'If you\'re showing an image slider at the top of the page. Note: give the category "slug."', MLF_TEXT_DOMAIN ),
                'type'  => 'text',
                // Default value (optional)
                'std'   => __( '', MLF_TEXT_DOMAIN ),
                // CLONES: Add to make the field cloneable (i.e. have multiple value)
                'clone' => false,
            ),
        ),
    );

    // Meta box for the attorneys custom post type
    $meta_boxes[] = array(
        // Meta box id, UNIQUE per meta box. Optional since 4.1.5
        'id' => 'attorneys-only',

        // Meta box title - Will appear at the drag and drop handle bar. Required.
        'title' => __( 'Individual attorney options', MLF_TEXT_DOMAIN ),

        // Post types, accept custom post types as well - DEFAULT is array('post'). Optional.
        'pages' => array( MLF_ATTORNEY_TYPE ),

        // Where the meta box appear: normal (default), advanced, side. Optional.
        'context' => 'normal',

        // Order of meta box: high (default), low. Optional.
        'priority' => 'high',

        // Auto save: true, false (default). Optional.
        'autosave' => true,

        // List of meta fields
        'fields' => array(
            // Show page title
            array(
                'name' => __( 'Show page title?', MLF_TEXT_DOMAIN ),
                'id'   => "{$prefix}show_page_title",
                'type' => 'checkbox',
                // Value can be 0 or 1
                'std'  => 1,
            ),
            array(
                'name' => __( 'Show page sidebar?', MLF_TEXT_DOMAIN ),
                'id'   => "{$prefix}show_page_sidebar",
                'type' => 'checkbox',
                // Value can be 0 or 1
                'std'  => 1,
            ),
            array(
                'name'     => __( 'Which sidebar should we use?', MLF_TEXT_DOMAIN ),
                'id'       => "{$prefix}sidebar",
                'type'     => 'select',
                // Array of 'value' => 'Label' pairs for select box
                'options'  => $ciSidebars,
                // Select multiple values, optional. Default is false.
                'multiple'    => false,
                'std'         => key($ciSidebars),
                'placeholder' => __( 'Select an Item', MLF_TEXT_DOMAIN ),
            ),
            // Top-of-page image slider
            array(
                'name' => __( 'Show giant image slider at top of page?', MLF_TEXT_DOMAIN ),
                'id'   => "{$prefix}top_img_slider",
                'type' => 'checkbox',
                // Value can be 0 or 1
                'std' => 0,
            ),
            // Slider
            array(
                'name'  => __( 'Show slides from this category at the top of the page (leave blank to show all)', MLF_TEXT_DOMAIN ),
                'id'    => "{$prefix}top_img_slider_cat_string",
                'desc'  => __( 'If you\'re showing an image slider at the top of the page. Note: give the category "slug."', MLF_TEXT_DOMAIN ),
                'type'  => 'text',
                // Default value (optional)
                'std'   => __( '', MLF_TEXT_DOMAIN ),
                // CLONES: Add to make the field cloneable (i.e. have multiple value)
                'clone' => false,
            ),
            array(
                'type' => 'heading',
                'name' => __( 'Social media links for this attorney', MLF_TEXT_DOMAIN ),
                'id'   => 'fake_id', // Not used but needed for plugin
            ),
            // FB
            array(
                'name'  => __( 'Facebook URL', MLF_TEXT_DOMAIN ),
                // Field ID, i.e. the meta key
                'id'    => "{$prefix}facebook",
                'desc'  => "Leave blank to hide the Facebook link",
                'type'  => 'text',
                'std'   => __( '', MLF_TEXT_DOMAIN ),
                'clone' => false,
            ),
            // Twitter
            array(
                'name'  => __( 'Twitter URL', MLF_TEXT_DOMAIN ),
                // Field ID, i.e. the meta key
                'id'    => "{$prefix}twitter",
                'desc'  => "Leave blank to hide the Twitter link",
                'type'  => 'text',
                'std'   => __( '', MLF_TEXT_DOMAIN ),
                'clone' => false,
            ),
            // LI
            array(
                'name'  => __( 'LinkedIn URL', MLF_TEXT_DOMAIN ),
                // Field ID, i.e. the meta key
                'id'    => "{$prefix}linkedin",
                'desc'  => "Leave blank to hide the LinkedIn link",
                'type'  => 'text',
                'std'   => __( '', MLF_TEXT_DOMAIN ),
                'clone' => false,
            ),
            // G+
            array(
                'name'  => __( 'Google+ URL', MLF_TEXT_DOMAIN ),
                // Field ID, i.e. the meta key
                'id'    => "{$prefix}google-plus",
                'desc'  => "Leave blank to hide the Google+ link",
                'type'  => 'text',
                'std'   => __( '', MLF_TEXT_DOMAIN ),
                'clone' => false,
            ),
        ),
    );

    return $meta_boxes;
}
add_filter( 'rwmb_meta_boxes', 'mlfRegisterMetaBoxes' );







