<?php
/** お知らせの記事 */
get_header();

while (have_posts()) :
    the_post();
    ?>
  <div class="wrap">
    <article>
      <header class="page-head">
        <span class="en-title" lang="en">News</span>
        <h1><?php the_title(); ?></h1>
        <time datetime="<?php echo esc_attr(get_the_date('Y-m-d')); ?>"><?php echo esc_html(get_the_date('Y.m.d')); ?></time>
      </header>
      <div class="entry">
        <?php the_content(); ?>
        <?php $fields_list = get_option('page_for_posts') ? get_permalink((int) get_option('page_for_posts')) : home_url('/'); ?>
        <a class="back-link" href="<?php echo esc_url($fields_list); ?>"><?php esc_html_e('← お知らせ一覧へ', 'fields'); ?></a>
      </div>
    </article>
  </div>
    <?php
endwhile;

get_footer();
