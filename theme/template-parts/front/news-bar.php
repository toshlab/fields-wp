<?php
// 最新のお知らせ1件
$fields_latest = get_posts(['numberposts' => 1, 'post_status' => 'publish']);
if (! $fields_latest) {
    return;
}
$fields_post = $fields_latest[0];
?>
<div class="news">
  <div class="wrap">
    <div class="cell"></div>
    <div class="cell"></div>
    <div class="cell">
      <a href="<?php echo esc_url(get_permalink($fields_post)); ?>">
        <time class="en" datetime="<?php echo esc_attr(get_the_date('Y-m-d', $fields_post)); ?>"><?php echo esc_html(get_the_date('Y.m/d', $fields_post)); ?></time>
        <span><?php echo esc_html(get_the_title($fields_post)); ?></span>
        <svg width="10" height="14" viewBox="0 0 10 14" aria-hidden="true"><path d="M2 1l6 6-6 6" fill="none" stroke="currentColor" stroke-width="2"/></svg>
      </a>
    </div>
  </div>
</div>
