<?php
$showTitle = mlfGetNormalizedMeta('show_page_title', true);
if( $showTitle ) { ?>
    <div class="page-header" itemscope itemtype="http://schema.org/Person">
        <h1 itemprop="name"><?php
            echo roots_title();

            if (has_post_thumbnail()) {
                the_post_thumbnail(MLF_ATTORNEY_IMG_SM, array( 'class'	=> "attachment-post-thumbnail alignright ml20 featured-img", 'itemprop' => 'name'));
            }
            ?>
        </h1>
    </div> <?php
} else { ?>
    <div class="buffer"></div> <?php
}

?>