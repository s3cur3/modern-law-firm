<?php

global $ciSidebars;
reset($ciSidebars);
$default = key($ciSidebars);

$sidebar = mlfGetNormalizedMeta('sidebar', $default);
dynamic_sidebar($sidebar);

?>
