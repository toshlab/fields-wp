<?php
/**
 * お知らせの一覧（投稿の一覧・アーカイブ）。ほかに合うテンプレートが無いときもこれを使う。
 */
get_header();
?>
<div class="wrap">
  <header class="page-head">
    <span class="en-title" lang="en">News</span>
    <h1><?php echo esc_html(is_home() ? __('お知らせ', 'fields') : wp_strip_all_tags(get_the_archive_title())); ?></h1>
  </header>

  <?php if (have_posts()) : ?>
    <ul class="post-list">
      <?php while (have_posts()) : the_post(); ?>
        <li>
          <a href="<?php the_permalink(); ?>">
            <time datetime="<?php echo esc_attr(get_the_date('Y-m-d')); ?>"><?php echo esc_html(get_the_date('Y.m.d')); ?></time>
            <span><?php the_title(); ?></span>
            <svg width="10" height="14" viewBox="0 0 10 14" aria-hidden="true"><path d="M2 1l6 6-6 6" fill="none" stroke="currentColor" stroke-width="2"/></svg>
          </a>
        </li>
      <?php endwhile; ?>
    </ul>
    <?php // 1ページに収まるときは paginate_links() が null を返すので、何も出さない ?>
    <?php if ($fields_pages = paginate_links(['prev_text' => '‹', 'next_text' => '›'])) : ?>
      <nav class="pagination" aria-label="<?php esc_attr_e('ページ送り', 'fields'); ?>">
        <?php echo wp_kses_post($fields_pages); ?>
      </nav>
    <?php endif; ?>
  <?php else : ?>
    <p style="margin-bottom:120px"><?php esc_html_e('お知らせはまだありません。', 'fields'); ?></p>
  <?php endif; ?>
</div>
<?php
get_footer();
