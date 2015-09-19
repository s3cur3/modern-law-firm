<?php


/**
 * @param $maxNumAttorneys int Maximum number of attorneys to return
 * @param $maxCharLength int The maximum length of the content, in characters
 * @return array All the attorney data you need. Keys are 'content', 'title', 'url', 'imgURL', 'imgWidth', and 'imgHeight'
 */
if( !function_exists('ciGetAllAttorneys') ) {
    function ciGetAllAttorneys( $maxNumAttorneys = 100, $maxCharLength = -1 ) {
        $query = new WP_Query('showposts=' . $maxNumAttorneys . '&post_type=' . CI_ATTORNEY_TYPE);

        $attorneyArray = array();
        while( $query->have_posts() ) {
            $query->next_post();

            $attachment = wp_get_attachment_image_src( get_post_thumbnail_id($query->post->ID), CI_ATTORNEY_IMG );

            $maybeExcerpt = has_excerpt($query->post->ID) ? $query->post->post_excerpt : $query->post->post_content;

            $attorneyArray[] = array(
                'id' => $query->post->ID,
                'content' => ciFilterToMaxCharLength($maybeExcerpt, $maxCharLength),
                'fullContent' => $query->post->post_content,
                'title' => $query->post->post_title,
                'imgURL' => ($attachment ? $attachment[0] : ''),
                'imgWidth' => ($attachment ? $attachment[1] : -1),
                'imgHeight' => ($attachment ? $attachment[2] : -1),
                'url' => get_permalink($query->post->ID),
                'socialURLs' => (function_exists('getAttorneySocialURLs') ? getAttorneySocialURLs($query->post->ID) : array())
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
if( !function_exists('ciGetAttorneysHTML') ) {
    function ciGetAttorneysHTML( $attorneysPerRow = 1, $numAttorneys = 100, $headingLevel = 3, $maxCharLength = -1, $listOnly = false ) {
        if( !function_exists('ciGetAttorneyInnerHTML') ) {
            function ciGetAttorneyInnerHTML( $attorney, $headingLevel, $floatImg="right", $listOnly) {
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
        }


        $attorneys = ciGetAllAttorneys( $numAttorneys, $maxCharLength );

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
                $out .= ciGetAttorneyInnerHTML($attorneys[$i], $headingLevel, "none", $listOnly);
                $out .= "</li>\n";
            }
            $out .= "</ul>\n";
        } else {
            $out .= ciGetAttorneyInnerHTML($attorneys[0], $headingLevel, "right", $listOnly);
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
if( !function_exists('ciAttorneyHTMLShortcode') ) {
    function ciAttorneyHTMLShortcode($atts) {
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

        return ciGetAttorneysHTML(intval($columns), 100, 3, intval($length), $list);
    }
}

if( !function_exists('ciRegisterAttorneyShortcode') ) {
    function ciRegisterAttorneyShortcode() {
        add_shortcode('attorneys', 'ciAttorneyHTMLShortcode');
    }
}

add_action( 'init', 'ciRegisterAttorneyShortcode');




 