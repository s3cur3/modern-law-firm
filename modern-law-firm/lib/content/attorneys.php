<?php
// Create the Attorneys custom post type
add_action('init', 'mlfCreateAttorneyType');
if( !function_exists('mlfCreateAttorneyType') ) {
    function mlfCreateAttorneyType() {
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

        register_post_type( MLF_ATTORNEY_TYPE, $args );

        if ( function_exists( 'add_image_size' ) ) {
            add_image_size( MLF_ATTORNEY_IMG, 400, 400 );
            add_image_size( MLF_ATTORNEY_IMG_SM, 300, 300 );
        }
    }
}
/**
 * Adds a note about the sizes of images we need
 */
if( !function_exists('mlfAddAttyImgSizeNote') ) {
    function mlfAddAttyImgSizeNote() {
        add_meta_box(
            'mlf_image_size_note',
            '<strong>Note</strong>: Featured Image Sizes',
            'mlfPrintAttyImgSizeNote',
            MLF_ATTORNEY_TYPE,
            'side',
            'low'
        );
    }
}
add_action( 'add_meta_boxes', 'mlfAddAttyImgSizeNote' );

if( !function_exists('mlfPrintAttyImgSizeNote') ) {
    function mlfPrintAttyImgSizeNote() {
        echo "<p>Recommended size for attorney photos:<br />400&times;400</p>";
    }
}



add_filter('post_updated_messages', 'mlfAttorneyTypeUpdatedMessages');
if( !function_exists('mlfAttorneyTypeUpdatedMessages') ) {
    function mlfAttorneyTypeUpdatedMessages( $messages ) {
        global $post, $post_ID;

        $messages[MLF_ATTORNEY_TYPE] = array(
            0 => '', // Unused. Messages start at index 1.
            1 => sprintf( __('Attorney updated. <a href="%s">View attorney</a>'), esc_url( get_permalink($post_ID) ) ),
            2 => __('Custom field updated.'),
            3 => __('Custom field deleted.'),
            4 => __('Attorney updated.'),
            /* translators: %s: date and time of the revision */
            5 => isset($_GET['revision']) ? sprintf( __('Attorney restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
            6 => sprintf( __('Attorney published. <a href="%s">View attorney</a>'), esc_url( get_permalink($post_ID) ) ),
            7 => __('Attorney saved.'),
            8 => sprintf( __('Attorney submitted. <a target="_blank" href="%s">Preview attorney</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
            9 => sprintf( __('Attorney scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview attorney</a>'),
                // translators: Publish box date format, see http://php.net/date
                date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
            10 => sprintf( __('Attorney draft updated. <a target="_blank" href="%s">Preview attorney</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
        );

        return $messages;
    }
}


/**
 * @param $maxNumAttorneys int Maximum number of attorneys to return
 * @param $maxCharLength int The maximum length of the content, in characters
 * @return array All the attorney data you need. Keys are 'content', 'title', 'url', 'imgURL', 'imgWidth', and 'imgHeight'
 */
if( !function_exists('mlfGetAllAttorneys') ) {
    function mlfGetAllAttorneys( $maxNumAttorneys = 100, $maxCharLength = -1 ) {
        $query = new WP_Query('showposts=' . $maxNumAttorneys . '&post_type=' . MLF_ATTORNEY_TYPE);

        $attorneyArray = array();
        while( $query->have_posts() ) {
            $query->next_post();

            $attachment = wp_get_attachment_image_src( get_post_thumbnail_id($query->post->ID), MLF_ATTORNEY_IMG );

            $attorneyArray[] = array(
                'id' => $query->post->ID,
                'content' => mlfFilterToMaxCharLength($query->post->post_content, $maxCharLength),
                'fullContent' => $query->post->post_content,
                'title' => $query->post->post_title,
                'imgURL' => ($attachment ? $attachment[0] : ''),
                'imgWidth' => ($attachment ? $attachment[1] : -1),
                'imgHeight' => ($attachment ? $attachment[2] : -1),
                'url' => get_permalink($query->post->ID),
                'socialURLs' => getAttorneySocialURLs($query->post->ID)
            );
        }

        wp_reset_postdata();
        return $attorneyArray;
    }
}


/**
 * Returns the HTML to display an image+text slider
 * @param $attorneysPerRow int Number of attorneys to print per row (in columns)
 * @param $numAttorneys int The max number of attorneys to display.
 * @param $headingLevel int The "level" of heading to apply to the attorney's name. E.g., 2 gives H2, 3 gives H3, etc.
 * @param $maxCharLength int The maximum length for each attorney's content. If -1, there will be no limit.
 * @param $listOnly boolean True if we should return a list of names only; false if we should show images + excerpt
 * @return string The HTML to be output
 */
if( !function_exists('mlfGetAttorneysHTML') ) {
    function mlfGetAttorneysHTML( $attorneysPerRow = 1, $numAttorneys = 100, $headingLevel = 3, $maxCharLength = -1, $listOnly = false ) {
        function getAttorneyInnerHTML( $attorney, $headingLevel, $floatImg="right", $listOnly) {
            $imgClass = "attorney-img";
            if( $floatImg == "right" ) {
                $imgClass .= " alignright ml20";
            } else if( $floatImg == "left" ) {
                $imgClass .= " alignleft mr20";
            }

            $out = "";
            if( strlen ($attorney['imgURL']) > 0 ) {
                $out  .= "    <a href=\"{$attorney['url']}\"><img alt=\"{$attorney['title']}\" src=\"{$attorney['imgURL']}\" width=\"{$attorney['imgWidth']}\" height=\"{$attorney['imgHeight']}\" class=\"{$imgClass}\" itemprop=\"image\"></a>\n";
            }

            $a = "<a href=\"{$attorney['url']}\" itemprop=\"name\">{$attorney['title']}</a>";
            if( $listOnly ) {
                return $a;
            }

            $out .= "    <h{$headingLevel}>{$a}</h{$headingLevel}>\n";
            $out .= "    {$attorney['content']}\n";
            $out .= "";
            return $out;
        }


        $attorneys = mlfGetAllAttorneys( $numAttorneys, $maxCharLength );

        if( count($attorneys) == 0 ) {
            return "";
        }

        $divClass = "attorneys";
        $liClass = "attorney";
        if( $attorneysPerRow > 1 ) {
            $divClass .= " row";
            $colWidth = 12 / $attorneysPerRow;
            $liClass .= " col-sm-{$colWidth}";
        }


        $out = "<div class=\"{$divClass}\">";
        if( count($attorneys) > 1 ) {
            $out .= "<ul>\n";
            for( $i = 0; $i < count($attorneys); $i++ ) {
                $out .= "<li class=\"{$liClass}\" itemscope itemtype=\"http://schema.org/Person\">\n";
                $out .= getAttorneyInnerHTML($attorneys[$i], $headingLevel, "none", $listOnly);
                $out .= "</li>\n";
            }
            $out .= "</ul>\n";
        } else {
            $out .= getAttorneyInnerHTML($attorneys[0], $headingLevel, "right", $listOnly);
        }
        $out .= "</div>";
        return $out;
    }
}


/**
 * Wrapper for the getSliderHTML() function, to be used by the Wordpress Shortcode API
 * @param $atts array containing optional 'category' field.
 * @return string The HTML that will display a slider on page
 */
if( !function_exists('mlfAttorneyHTMLShortcode') ) {
    function mlfAttorneyHTMLShortcode($atts) {
        $columns = 1; // Defined for the sake of the IDE's error-checking
        $length = 250;
        $list = false;
        extract(
            shortcode_atts(
                array(
                    'columns' => 1,
                    'length'  => 250,
                    'list'    => $list
                ), ciNormalizeShortcodeAtts($atts) ), EXTR_OVERWRITE /* overwrite existing vars */ );

        return mlfGetAttorneysHTML(intval($columns), 100, 3, intval($length), $list);
    }
}

if( !function_exists('mlfRegisterAttorneyShortcode') ) {
    function mlfRegisterAttorneyShortcode() {
        add_shortcode('attorneys', 'mlfAttorneyHTMLShortcode');
    }
}

add_action( 'init', 'mlfRegisterAttorneyShortcode');


