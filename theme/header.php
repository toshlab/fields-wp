<!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#main"><?php esc_html_e('本文へ移動', 'fields'); ?></a>

<?php if (is_front_page()) : ?>
  <div class="loader" aria-hidden="true">
    <div class="mark"><?php echo esc_html(strtok(get_bloginfo('name'), ' ')); ?></div>
    <div class="dots"><span></span><span></span><span></span></div>
  </div>
<?php endif; ?>

<?php if ($fields_notice = fields_text('notice_text')) : ?>
  <p class="notice"><?php echo esc_html($fields_notice); ?></p>
<?php endif; ?>

<?php $fields_nav = fields_nav_items(); ?>
<header class="header">
  <div class="wrap">
    <a href="<?php echo esc_url(home_url('/')); ?>" class="logo">
      <svg width="38" height="38" viewBox="0 0 40 40" aria-hidden="true"><circle cx="20" cy="20" r="17" fill="none" stroke="currentColor" stroke-width="3"/><path d="M20 3v34M3 20h34" stroke="currentColor" stroke-width="2"/><circle cx="20" cy="20" r="6" fill="none" stroke="currentColor" stroke-width="2.5"/></svg>
      <span>
        <b lang="en"><?php echo esc_html(strtok(get_bloginfo('name'), ' ')); ?></b>
        <small><?php bloginfo('description'); ?></small>
      </span>
    </a>
    <nav class="gnav" aria-label="<?php esc_attr_e('メインメニュー', 'fields'); ?>">
      <?php foreach ($fields_nav as $item) : ?>
        <a href="<?php echo esc_url($item['url']); ?>"><?php echo esc_html($item['label']); ?></a>
      <?php endforeach; ?>
    </nav>
    <button class="menu-btn" type="button" aria-label="<?php esc_attr_e('メニューを開く', 'fields'); ?>" aria-expanded="false" aria-controls="sp-nav"><span></span><span></span></button>
  </div>
  <nav id="sp-nav" class="sp-nav" aria-label="<?php esc_attr_e('メインメニュー', 'fields'); ?>" hidden>
    <ul>
      <?php foreach ($fields_nav as $item) : ?>
        <li><a href="<?php echo esc_url($item['url']); ?>"><?php echo esc_html($item['label']); ?></a></li>
      <?php endforeach; ?>
      <li><a class="btn primary" href="<?php echo esc_url(home_url('/#trial-form')); ?>"><?php esc_html_e('無料体験に申し込む', 'fields'); ?><?php fields_arrow(); ?></a></li>
    </ul>
  </nav>
</header>

<main id="main">
