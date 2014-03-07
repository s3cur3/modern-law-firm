<?php while (have_posts()) : the_post(); ?>
  <?php the_content(); ?>
    <div><?php
        printSocialLinks(getAttorneySocialURLs(), 'alignright mb20');
        ?>

    </div>
  <?php wp_link_pages(array('before' => '<nav class="pagination">', 'after' => '</nav>')); ?>
<?php endwhile; ?>
