<?php
// Create the slides custom post type
add_action('init', 'mlfCreatePostType');
function mlfCreatePostType() {
    $args = array(
        'labels' => array(
            'name' => 'Slides',
            'singular_name' => 'Slide',
            'all_items' => 'All Slides',
            'add_new' => 'New Slide',
            'add_new_item' => 'Add New Slide',
            'new_item' => 'New Slide',
            'edit_item' => 'Edit Slide',
            'view_item' => 'View Slide'
        ),
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'menu_icon' => 'dashicons-format-gallery', // A Dashicon: http://melchoyce.github.io/dashicons/
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'slide'),
        'capability_type' => 'post',
        'has_archive' => false,
        'hierarchical' => false,
        'menu_position' => 6,
        'supports' => array(
            'title',
            'editor',
            'thumbnail',
        ),
        'taxonomies' => array('category')
    );

    register_post_type( MLF_SLIDE_TYPE, $args );



    if ( function_exists( 'add_image_size' ) ) {
        add_image_size( MLF_SIZE_MD, 1170, 99999 );
        add_image_size( MLF_SIZE_LG, 1920, 99999 );
    }
}

/**
 * Adds a note about the sizes of images we need
 */
function mlfAddSliderImgSizeNote() {
    add_meta_box(
        'mlf_image_size_note',
        '<strong>Note</strong>: Featured Image Sizes',
        'mlfPrintSliderImgSizeNote',
        MLF_SLIDE_TYPE,
        'side',
        'low'
    );
}
add_action( 'add_meta_boxes', 'mlfAddSliderImgSizeNote' );

function mlfPrintSliderImgSizeNote() {
    echo "<p>Recommended sizes for slider images:</p>";
    echo "<ul>";
    echo "    <li>For slides used at the top of the page: 1920&times;400</li>";
    echo "    <li>For slides inserted within the page: 1170&times;400</li>";
    echo "</ul>";
}



function mlfSliderTypeUpdatedMessages( $messages ) {
    global $post, $post_ID;

    $messages[MLF_SLIDE_TYPE] = array(
        0 => '', // Unused. Messages start at index 1.
        1 => sprintf( __('Slide updated. <a href="%s">View slide</a>'), esc_url( get_permalink($post_ID) ) ),
        2 => __('Custom field updated.'),
        3 => __('Custom field deleted.'),
        4 => __('Slide updated.'),
        /* translators: %s: date and time of the revision */
        5 => isset($_GET['revision']) ? sprintf( __('Slide restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
        6 => sprintf( __('Slide published. <a href="%s">View slide</a>'), esc_url( get_permalink($post_ID) ) ),
        7 => __('Slide saved.'),
        8 => sprintf( __('Slide submitted. <a target="_blank" href="%s">Preview slide</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
        9 => sprintf( __('Slide scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview slide</a>'),
            // translators: Publish box date format, see http://php.net/date
            date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
        10 => sprintf( __('Slide draft updated. <a target="_blank" href="%s">Preview slide</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    );

    return $messages;
}
add_filter('post_updated_messages', 'mlfSliderTypeUpdatedMessages');

/**
 * @param $category string Name of the category to filter. If empty, we'll return slides from all categories.
 * @param $maxNumSlides int Maximum number of slides to return
 * @param $size string One of two constants: SIZE_LG or SIZE_MD (use MD if the image will be in a container div)
 * @return array All the slide data you need. Keys are 'content', 'title', 'imgURL', 'imgWidth', and 'imgHeight'
 */
function mlfGetAllSlides($category, $maxNumSlides, $size) {
    $query = null;
    if( $category ) {
        $query = new WP_Query(array('category_name' => $category, 'post_type' => MLF_SLIDE_TYPE, 'showposts' => $maxNumSlides));
    } else {
        $query = new WP_Query('showposts=' . $maxNumSlides . '&post_type=' . MLF_SLIDE_TYPE);
    }

    $slidesArray = array();
    while( $query->have_posts() ) {
        $query->next_post();

        $attachment = wp_get_attachment_image_src( get_post_thumbnail_id($query->post->ID), $size );

        if($attachment) {
            $slidesArray[] = array(
                'id' => $query->post->ID,
                'content' => $query->post->post_content,
                'title' => $query->post->post_title,
                'imgURL' => $attachment[0],
                'imgWidth' => $attachment[1],
                'imgHeight' => $attachment[2],
                'contentPosition' => mlfGetNormalizedMeta('caption_position', 'center', $query->post->ID),
                'bg' => mlfGetNormalizedMeta('caption_bg', '', $query->post->ID)
            );
        }
    }

    wp_reset_postdata();
    return $slidesArray;
}


/**
 * Returns the HTML to display an image+text slider
 * @param $category string The category to pull slides from. (If empty, we'll get all known slides.)
 * @param $numSlides int The max number of slides to display.
 * @param $darken Boolean True if images should be darkened when displayed, false to display them just as they are.
 * @param $size string The image size (which must be made known to WP in advance) to output
 * @return string The HTML to be output
 */
function mlfGetSliderHTML($category = '', $numSlides = 3, $darken = true, $size = MLF_SIZE_MD) {
    $slides = mlfGetAllSlides($category, $numSlides, $size);

    if( count($slides) == 0 ) {
        return "";
    }

    $widthClass = ($size == MLF_SIZE_LG ? "full-page" : "full-width");
    $id = "pageCarousel-$widthClass";
    $out = "<div id=\"{$id}\" class=\"carousel slide {$widthClass}\" data-ride=\"carousel\">";
    if( count($slides) > 1 ) {
        $out .= '<!-- Indicators -->';
        $out .= '<ol class="carousel-indicators">';
        for( $i = 0; $i < count($slides); $i++ ) {
            $activeClass = ($i==0 ? 'active' : '');
            $out .= "<li data-target=\"#{$id}\" data-slide-to=\"{$i}\" class=\"{$activeClass}\"></li>";
        }
        $out .= "</ol>";
    }
    $out .= '<div class="carousel-inner">';
    for( $i = 0; $i < count($slides); $i++ ) {
        $slide = $slides[$i];

        $active = ($i == 0 ? "active" : '');
        $darkenClass = ($darken ? "darken" : "");
        $out .= "<div class=\"item {$active}\">";
        $out .= "    <img alt=\"{$slide['title']}\" src=\"{$slide['imgURL']}\" width=\"{$slide['imgWidth']}\" height=\"{$slide['imgHeight']}\" class=\"{$darkenClass}\">";
        $out .= '    <div class="container">';

        if( $slide['contentPosition'] != 'none' ) {
            $colorStyle = "";
            if( $slide['bg'] ) {
                if( $slide['bg'][0] !== "#" ) $slide['bg'] = "#" . $slide['bg'];
                $colorStyle .= " style=\"background:{$slide['bg']}\"";
            }
            $out .= "        <div class=\"carousel-caption {$slide['contentPosition']}\"{$colorStyle}>";
            $out .= "            <h2>{$slide['title']}</h2>";
            $out .= "            {$slide['content']}";
            $out .= '        </div>';
        }
        $out .= '    </div>';
        $out .= '</div>';
    }
    $out .= '</div><!-- .carousel-inner -->';
    if( count($slides) > 1 ) {
        $out .= "<a class=\"left carousel-control\" href=\"#{$id}\" data-slide=\"prev\"><span class=\"glyphicon glyphicon-chevron-left\"></span></a>";
        $out .= "<a class=\"right carousel-control\" href=\"#{$id}\" data-slide=\"next\"><span class=\"glyphicon glyphicon-chevron-right\"></span></a>";
    }
    $out .= '</div><!-- .carousel -->';
    return $out;
}

/**
 * Wrapper for the getSliderHTML() function, to be used by the Wordpress Shortcode API
 * @param $atts array containing optional 'category' field.
 * @return string The HTML that will display a slider on page
 */
function mlfSliderHTMLShortcode($atts) {
    $category = ""; // Defined for the sake of the IDE's error-checking
    extract( shortcode_atts( array(
        'category' => ''
    ), $atts ), EXTR_OVERWRITE /* overwrite existing vars */ );

    return mlfGetSliderHTML($category, 10, true, MLF_SIZE_MD);
}

function mlfRegisterSliderShortcode() {
    add_shortcode('slider', 'mlfSliderHTMLShortcode');
}

add_action( 'init', 'mlfRegisterSliderShortcode');
