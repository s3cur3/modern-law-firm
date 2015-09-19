<?php

function mlfAutoAddRelPrettyPhoto($content) {
    global $post;
    $pattern        = "/(<a(?![^>]*?rel=['\"]prettyPhoto.*)[^>]*?href=['\"][^'\"]+?\.(?:bmp|gif|jpg|jpeg|png)['\"][^\>]*)>/i";
    $replacement    = '$1 rel="prettyPhoto['.$post->ID.']">';
    $content = preg_replace($pattern, $replacement, $content);
    return $content;
}

add_filter("the_content", "mlfAutoAddRelPrettyPhoto");;

