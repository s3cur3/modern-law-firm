<?php



// Create the Attorneys custom post type
add_action('init', 'ciCreateAttorneyType');
if( !function_exists('ciCreateAttorneyType') ) {
    function ciCreateAttorneyType() {
        $args = array(
            'labels' => array(
                'name' => 'Attorneys',
                'all_items' => 'All Attorneys',
                'singular_name' => 'Attorney',
                'add_new' => 'New Attorney',
                'add_new_item' => 'Add New Attorney',
                'new_item' => 'New Attorney',
                'edit_item' => 'Edit Attorney',
                'view_item' => 'View Attorney'
            ),
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'menu_icon' => 'dashicons-businessman', // A Dashicon: http://melchoyce.github.io/dashicons/
            'show_in_menu' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'attorney'),
            'capability_type' => 'post',
            'has_archive' => false,
            'hierarchical' => false,
            'menu_position' => 50,
            'supports' => array(
                'title',
                'editor',
                'thumbnail',
            ),
            //'taxonomies' => array('category')
        );

        register_post_type( CI_ATTORNEY_TYPE, $args );

        if ( function_exists( 'add_image_size' ) ) {
            add_image_size( CI_ATTORNEY_IMG, 400, 400 );
            add_image_size( CI_ATTORNEY_IMG_SM, 300, 300 );
        }
    }
}
/**
 * Adds a note about the sizes of images we need
 */
if( !function_exists('ciAddAttyImgSizeNote') ) {
    function ciAddAttyImgSizeNote() {
        add_meta_box(
            'ci_image_size_note',
            '<strong>Note</strong>: Featured Image Sizes',
            'ciPrintAttyImgSizeNote',
            CI_ATTORNEY_TYPE,
            'side',
            'low'
        );
    }
}
add_action( 'add_meta_boxes', 'ciAddAttyImgSizeNote' );

if( !function_exists('ciPrintAttyImgSizeNote') ) {
    function ciPrintAttyImgSizeNote() {
        echo "<p>Recommended size for attorney photos:<br />400&times;400</p>";
    }
}



add_filter('post_updated_messages', 'ciAttorneyTypeUpdatedMessages');
if( !function_exists('ciAttorneyTypeUpdatedMessages') ) {
    function ciAttorneyTypeUpdatedMessages( $messages ) {
        global $post, $post_ID;

        $messages[CI_ATTORNEY_TYPE] = array(
            0 => '', // Unused. Messages start at index 1.
            1 => sprintf( __('Attorney updated. <a href="%s">View attorney</a>'), esc_url( get_permalink($post_ID) ) ),
            2 => __('Custom field updated.', CI_TEXT_DOMAIN),
            3 => __('Custom field deleted.', CI_TEXT_DOMAIN),
            4 => __('Attorney updated.', CI_TEXT_DOMAIN),
            /* translators: %s: date and time of the revision */
            5 => isset($_GET['revision']) ? sprintf( __('Attorney restored to revision from %s', CI_TEXT_DOMAIN), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
            6 => sprintf( __('Attorney published. <a href="%s">View attorney</a>'), esc_url( get_permalink($post_ID) ) ),
            7 => __('Attorney saved.', CI_TEXT_DOMAIN),
            8 => sprintf( __('Attorney submitted. <a target="_blank" href="%s">Preview attorney</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
            9 => sprintf( __('Attorney scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview attorney</a>'),
                // translators: Publish box date format, see http://php.net/date
                          date_i18n( 'M j, Y @ G:i', strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
            10 => sprintf( __('Attorney draft updated. <a target="_blank" href="%s">Preview attorney</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
        );

        return $messages;
    }
}


 