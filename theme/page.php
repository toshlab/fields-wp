<?php
/** 固定ページ */
get_header();

while (have_posts()) :
    the_post();
    ?>
  <div class="wrap">
    <article>
      <header class="page-head">
        <h1><?php the_title(); ?></h1>
      </header>
      <div class="entry"><?php the_content(); ?></div>
    </article>
  </div>
    <?php
endwhile;

get_footer();
