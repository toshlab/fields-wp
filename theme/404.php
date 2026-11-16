<?php get_header(); ?>
<div class="wrap">
  <header class="page-head">
    <span class="en-title" lang="en">404</span>
    <h1><?php esc_html_e('ページが見つかりませんでした', 'fields'); ?></h1>
  </header>
  <div class="entry">
    <p><?php esc_html_e('URLが変わったか、ページが削除された可能性があります。', 'fields'); ?></p>
    <a class="back-link" href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('← トップページへ', 'fields'); ?></a>
  </div>
</div>
<?php get_footer(); ?>
