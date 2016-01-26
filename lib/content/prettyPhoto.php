<?php

function mlfAutoAddRelPrettyPhoto($content) {
    global $post;
    $pattern        = "/(<a(?![^>]*?rel=['\"]prettyPhoto.*)[^>]*?href=['\"][^'\"]+?\.(?:bmp|gif|jpg|jpeg|png)['\"][^\>]*)>/i";
    $postId = $post && property_exists($post, "ID") ? $post->ID : "";
    $replacement    = '$1 rel="prettyPhoto['.$postId.']">';
    $content = preg_replace($pattern, $replacement, $content);
    return $content;
}

add_filter("the_content", "mlfAutoAddRelPrettyPhoto");;

