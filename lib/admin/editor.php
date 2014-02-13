<?php

function mlfEditorButtonHooks() {
    // Only add hooks when the current user has permissions AND is in Rich Text editor mode
    if ( ( current_user_can('edit_posts') || current_user_can('edit_pages') ) && get_user_option('rich_editing') ) {
        add_filter("mce_external_plugins", "mlfEditorRegisterTinyMCEJavascript");
        add_filter('mce_buttons', 'mlfEditorRegisterButtons');
    }
}
// init process for button control
add_action('init', 'mlfEditorButtonHooks');


function mlfEditorRegisterButtons( $buttons ) {
    array_push($buttons, '|', "columns", 'columns_adv', "coloredband", 'cta', 'attorney', 'carousel');
    return $buttons;
}


// Load the TinyMCE plugin
function mlfEditorRegisterTinyMCEJavascript( $plugin_array ) {
    // Make sure the thickbox modal (dialog box) is available
    add_thickbox();

    $plugin_array['editor'] = get_template_directory_uri() . "/assets/js/admin/editor.js";
    return $plugin_array;
}


/**
 * Register meta boxes
 *
 * @param $meta_boxes void
 * @return array The filled meta boxes
 */
function mlfRegisterMetaBoxes( $meta_boxes )
{
    /**
     * Prefix of meta keys (optional)
     * Use underscore (_) at the beginning to make keys hidden
     * Alt.: You also can make prefix empty to disable it
     */
    // Better has an underscore as last sign
    $prefix = 'mlf_';

    // 1st meta box
    $meta_boxes[] = array(
        // Meta box id, UNIQUE per meta box. Optional since 4.1.5
        'id' => 'standard',

        // Meta box title - Will appear at the drag and drop handle bar. Required.
        'title' => __( 'The Modern Law Firm theme options', 'rwmb' ),

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
                'name' => __( 'Show page title?', 'rwmb' ),
                'id'   => "{$prefix}show_page_title",
                'type' => 'checkbox',
                // Value can be 0 or 1
                'std'  => 1,
            ),
            array(
                'name' => __( 'Show page sidebar?', 'rwmb' ),
                'id'   => "{$prefix}show_page_sidebar",
                'type' => 'checkbox',
                // Value can be 0 or 1
                'std'  => 1,
            ),
            // Top-of-page image slider
            array(
                'name' => __( 'Show giant image slider at top of page?', 'rwmb' ),
                'id'   => "{$prefix}top_img_slider",
                'type' => 'checkbox',
                // Value can be 0 or 1
                'std' => 0,
            ),
            // Taxonomy
            array(
                // Field name - Will be used as label
                'name'  => __( 'Show slides from this category at the top of the page (leave blank to show all)', 'rwmb' ),
                // Field ID, i.e. the meta key
                'id'    => "{$prefix}top_img_slider_cat_string",
                // Field description (optional)
                'desc'  => __( 'If you\'re showing an image slider at the top of the page. Note: give the category "slug."', 'rwmb' ),
                'type'  => 'text',
                // Default value (optional)
                'std'   => __( '', 'rwmb' ),
                // CLONES: Add to make the field cloneable (i.e. have multiple value)
                'clone' => false,
            ),
        ),
    );

    return $meta_boxes;
}
add_filter( 'rwmb_meta_boxes', 'mlfRegisterMetaBoxes' );







