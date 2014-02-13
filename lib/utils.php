<?php
/**
 * Utility functions
 */
function mlfAddFilters($tags, $function) {
  foreach($tags as $tag) {
    add_filter($tag, $function);
  }
}

function mlfIsElementEmpty($element) {
  $element = trim($element);
  return empty($element) ? false : true;
}
