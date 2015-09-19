<?php
$showTitle = mlfGetNormalizedMeta( 'show_page_title', true );
if( $showTitle ) { ?>
    <div class="page-header">
        <h1>
            <?php echo roots_title(); ?>
        </h1>
    </div> <?php
} else { ?>
    <div class="buffer"></div> <?php
} ?>