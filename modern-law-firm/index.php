<?php get_template_part('templates/page', 'header-archive'); ?>

<?php if (!have_posts()) { ?>
    <div class="alert alert-warning">
        <?php _e('Sorry, no results were found.', MLF_TEXT_DOMAIN); ?>
    </div> <?php
    get_search_form();
}

global $evenOddCount;
$evenOddCount = 0;
while( have_posts() ) {
    the_post();

    $evenOddCount++;
    get_template_part('templates/content', get_post_format());
} ?>

<?php if ($wp_query->max_num_pages > 1) : ?>
  <nav class="post-nav">
    <ul class="pager">
      <li class="previous"><?php next_posts_link(__('&larr; Older posts', MLF_TEXT_DOMAIN)); ?></li>
      <li class="next"><?php previous_posts_link(__('Newer posts &rarr;', MLF_TEXT_DOMAIN)); ?></li>
    </ul>
  </nav>
<?php endif; ?>
