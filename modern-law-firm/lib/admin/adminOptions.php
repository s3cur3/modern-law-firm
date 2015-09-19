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
    // Better has an underscore as last sign
    $prefix = THEME_PREFIX . '_';

    // 1st meta box
    $meta_boxes[] = array(
        // Meta box id, UNIQUE per meta box. Optional since 4.1.5
        'id' => 'standard',

        // Meta box title - Will appear at the drag and drop handle bar. Required.
        'title' => __( 'The Modern Law Firm theme options', MLF_TEXT_DOMAIN ),

        // Post types, accept custom post types as well - DEFAULT is array('post'). Optional.
        'pages' => array( 'post', 'page' ),

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

    // Meta box for the slides custom post type
    $meta_boxes[] = array(
        // Meta box id, UNIQUE per meta box. Optional since 4.1.5
        'id' => 'slides-only',

        // Meta box title - Will appear at the drag and drop handle bar. Required.
        'title' => __( 'Slide options', MLF_TEXT_DOMAIN ),

        // Post types, accept custom post types as well - DEFAULT is array('post'). Optional.
        'pages' => array( MLF_SLIDE_TYPE ),

        // Where the meta box appear: normal (default), advanced, side. Optional.
        'context' => 'normal',

        // Order of meta box: high (default), low. Optional.
        'priority' => 'high',

        // Auto save: true, false (default). Optional.
        'autosave' => true,

        // List of meta fields
        'fields' => array(
            // Caption position
            array(
                'name' => __( 'Position of caption:', 'rwmb' ),
                'id' => "{$prefix}caption_position",
                'type' => 'select',
                // Array of 'value' => 'Label' pairs for select box
                'options' => array(
                    'center' => __( 'Center', 'rwmb' ),
                    'left' => __( 'Left', 'rwmb' ),
                    'right' => __( 'Right', 'rwmb' ),
                    'none' => __( 'Not displayed', 'rwmb' ),
                ),
                // Select multiple values, optional. Default is false.
                'multiple' => false,
                'std' => 'center',
                'desc' => '<strong>Note:</strong> On very small screens, all captions will be centered, with a transparent background.'
            ),
            // Caption background color
            array(
                'name' => __( 'Caption background color', 'rwmb' ),
                'id' => "{$prefix}caption_bg",
                'type' => 'color',
                'desc' => '<strong>Only</strong> applies to left- or right-positioned captions. Defaults to the secondary background color.'
            ),
        ),
    );


    return $meta_boxes;
}
add_filter( 'rwmb_meta_boxes', 'mlfRegisterMetaBoxes' );







