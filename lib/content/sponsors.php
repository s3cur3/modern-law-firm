<?php
define("CI_SPONSORS_TYPE", 'sponsor');
define("CI_SPONSOR_IMG", 'sponsor-thumbnail');
define("CI_SPONSOR_IMG_WIDTH", 400);
define("CI_SPONSOR_IMG_WIDTH_RETINA", 200);

// Create the Sponsors custom post type
add_action('init', 'ciCreateSponsors');
function ciCreateSponsors() {
    ciCreateCPT("Sponsor", "Sponsors", CI_SPONSORS_TYPE, 'id-alt');

    add_image_size( CI_SPONSOR_IMG, CI_SPONSOR_IMG_WIDTH, 1000 );
}


add_filter('post_updated_messages', 'ciSponsorTypeUpdatedMessages');
function ciSponsorTypeUpdatedMessages($messages) {
    ciCPTUpdatedMessages($messages, "Sponsor", CI_SPONSORS_TYPE);
}



/**
 * Adds a note about the sizes of images we need
 */
function ciAddSponsorImgSizeNote() {
    add_meta_box(
        'ci_image_size_note',
        '<strong>Note</strong>: Featured Image Sizes',
        'ciPrintSponsorImgSizeNote',
        CI_SPONSORS_TYPE,
        'side',
        'low'
    );
}
add_action( 'add_meta_boxes', 'ciAddSponsorImgSizeNote' );

function ciPrintSponsorImgSizeNote() {
    echo "<p>Recommended size for sponsor images:<br />400&times;400</p>";
}








add_shortcode('sponsors', 'ciHandleSponsorShortcode');
/**
 * Handles the [sponsors /] shortcode. Usage:
 *
 * - [sponsors /]
 * - [sponsors images /] (Display as a list of images + links only)
 * - [sponsors images columns=4 /] (Display as a list of images in 4 columns)
 * - [sponsors images columns=4 max=4 /] (Display at most 4 sponsors as a list of images in 4 columns)
 * - [sponsors list /] (Display as a list of names + links only)
 *
 * @param array $atts
 * @param string $content
 * @return string formatted HTML
 */
function ciHandleSponsorShortcode( $atts, $content="" ) {
    $list = false;
    $images = false;
    $max = 100;
    $columns = 1;
    extract(
        shortcode_atts(
            array(
                'list'    => $list,
                'max'     => $max,
                'columns' => $columns,
                'images'  => $images
            ), ciNormalizeShortcodeAtts($atts), 'sponsors' ) );

    if( $list ) {
        return ciGetSponsorList();
    } else if( $images ) {
        return ciGetSponsorImageList();
    } else {
        return ciGetSponsorsHTML($max, 3, -1, $images, $columns);
    }
}

function ciGetSponsorList() {
    $sponsors = ciGetPostsOfType( CI_SPONSORS_TYPE, 1, CI_SPONSOR_IMG, 100 );

    $out = "<ul class=\"sponsors\">";
    foreach( $sponsors as $sponsor ) {
        $out .= "<li><a href=\"{$sponsor['url']}\">{$sponsor['title']}</a></li>";
    }
    $out .= "</ul>";
    return $out;
}


function ciGetSponsorImageList() {
    $sponsors = ciGetPostsOfType( CI_SPONSORS_TYPE, 1, CI_SPONSOR_IMG, 100 );

    $out = "<ul class=\"sponsors sponsor-images\">";
    foreach( $sponsors as $sponsor ) {
        $out .= "<li><a href=\"{$sponsor['url']}\">" .
                    "<img src=\"{$sponsor['imgURL']}\" width=\"" . CI_SPONSOR_IMG_WIDTH_RETINA . "\" alt=\"Sponsored by {$sponsor['title']}\">" .
                "</a></li>";
    }
    $out .= "</ul>";
    return $out;
}




/**
 * Returns the HTML to display the sponsors
 * @param $numSponsors int The max number of sponsors to display.
 * @param $headingLevel int The "level" of heading to apply to the attorney's name. E.g., 2 gives H2, 3 gives H3, etc.
 *                          Use 0 to simply bold the heading.
 * @param $maxCharLength int The maximum length for each attorney's content. If -1, there will be no limit.
 * @param $useImages boolean For posts that have a featured image, should we display that image?
 * @param $columns int The number of columns to format the practice areas into
 * @param $more boolean True if we should use a "Read more." link; false if we should simply link the titles
 * @return string The HTML to be output
 */
function ciGetSponsorsHTML( $numSponsors = 100,
                            $headingLevel = 3,
                            $maxCharLength = -1,
                            $useImages = true,
                            $columns = 1,
                            $more = false ) {
    function getSponsorInnerHTML( $sponsor, $headingLevel, $floatImg="right", $useImages, $more ) {
        $imgClass = "sponsor-img";
        if( $floatImg == "right" ) {
            $imgClass .= " alignright ml20";
        } else if( $floatImg == "left" ) {
            $imgClass .= " alignleft mr20";
        }

        $out = "";
        $aHREF = "<a href=\"{$sponsor['url']}\">";
        if( $useImages && strlen($sponsor['imgURL']) > 0 ) {
            $out  .= "    $aHREF<img alt=\"{$sponsor['title']}\" src=\"{$sponsor['imgURL']}\" width=\"" . CI_SPONSOR_IMG_WIDTH_RETINA . "\" class=\"{$imgClass}\"></a>\n";
        }


        $title = $sponsor['title'];
        if( !$more ) {
            $title = "{$aHREF}$title</a>";
        }

        if( $headingLevel > 0 ) {
            $out .= "    <h{$headingLevel}>$title</h{$headingLevel}>\n";
        } else {
            $out .= "    <strong>$title</strong>\n";
        }

        $out .= "    {$sponsor['content']}\n";

        if( $more ) {
            $out .= "{$aHREF}Learn more...</a>";
        }

        return $out;
    }


    $sponsors = ciGetPostsOfType( CI_SPONSORS_TYPE, $maxCharLength, CI_SPONSOR_IMG, $numSponsors );

    if( count($sponsors) == 0 ) {
        return "";
    }

    $divClass = "sponsors" . ($columns > 1 ? " row mb30" : "");
    $liClass = "sponsor " . ($columns > 1 ? ciGetColumnClass($columns) : "") ;

    $out = "<div class=\"{$divClass}\">";
    if( count($sponsors) > 1 ) {
        $out .= "<ul class=\"no-bullet\">\n";
        for( $i = 0; $i < count($sponsors); $i++ ) {
            $out .= "<li class=\"{$liClass}\">\n";
            $out .= getSponsorInnerHTML($sponsors[$i], $headingLevel, "none", $useImages, $more);
            $out .= "</li>\n";
        }
        $out .= "</ul>\n";
    } else {
        $out = getSponsorInnerHTML($sponsors[0], $headingLevel, "right", $useImages, $more);
    }
    $out .= "</div>";
    return $out;
}





/**
 * Register meta boxes
 *
 * For a demo of available options, see https://github.com/rilwis/meta-box/blob/master/demo/demo.php
 *
 * @param $meta_boxes void
 * @return array The filled meta boxes
 */
function ciRegisterSponsorMetaBox( $meta_boxes ) {
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
        'id' => 'sponsor-meta',

        // Meta box title - Will appear at the drag and drop handle bar. Required.
        'title' => 'Sponsor settings',

        // Post types, accept custom post types as well - DEFAULT is array('post'). Optional.
        'pages' => array( CI_SPONSORS_TYPE ),

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
                'name' => 'Show page title?',
                'id'   => "{$prefix}show_page_title",
                'type' => 'checkbox',
                // Value can be 0 or 1
                'std'  => 1,
            ),

        ),
    );


    return $meta_boxes;
}
add_filter( 'rwmb_meta_boxes', 'ciRegisterSponsorMetaBox' );


















