<!-- content-attorneys -->
<?php while (have_posts()) : the_post(); ?>
    <div class="entry-content">
        <?php the_content(); ?>
    </div>
<?php endwhile; ?>
<?php

$contentLength = 250;
$attorneys = mlfGetAllAttorneys(100, $contentLength);

foreach( $attorneys as $i => $attorney ) {
    if( $i % 2 == 0 ) { ?>
        <div class="row"><?php
    }?>
    <div id="post-<?php echo $attorney['id']; ?>" class="main individual-post mb35 col-md-6"><?php
        if( $attorney['imgURL'] != '' ) { ?>
            <div class="">
                <a href="<?php echo $attorney['url']; ?>" title="<?php echo $attorney['title']; ?>">
                    <img class="mb0" src="<?php echo $attorney['imgURL']; ?>" alt="<?php echo $attorney['title']; ?>" width="<?php echo $attorney['imgWidth']; ?>" height="<?php echo $attorney['imgHeight']; ?>"/>
                </a>
            </div><?php
        } ?>
        <h2><a href="<?php echo $attorney['url']; ?>" title="<?php echo $attorney['title']; ?>"><?php echo $attorney['title']; ?></a></h2> <?php
        echo $attorney['content'];

        if( strlen(strip_tags($attorney['fullContent'], '<p>')) > strlen($attorney['content'])) {?>
            <a href="<?php echo $attorney['url']; ?>" class="btn">Read <?php echo $attorney['title']; ?>'s full bio</a><?php
        }
        ?>
        <div class="clr"></div>
    </div><!-- /.main --> <?php
    if( $i % 2 == 1 ) { ?>
        </div><?php
    }
}
