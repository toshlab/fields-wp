<?php

add_action('after_setup_theme', function () {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form', 'gallery', 'caption', 'style', 'script']);
    add_theme_support('responsive-embeds');

    register_nav_menus([
        'global' => __('グローバルメニュー（ヘッダー）', 'fields'),
    ]);
});

// JavaScript が動くときだけ、最初に隠してから出す動きを有効にする（CSS の html.js）
add_action('wp_head', function () {
    echo "<script>document.documentElement.classList.add('js');</script>\n";
}, 1);

// meta description（トップは入力欄の値、記事は抜粋）
add_action('wp_head', function () {
    if (is_front_page()) {
        $description = fields_text('meta_description');
    } elseif (is_singular()) {
        $description = wp_strip_all_tags(get_the_excerpt());
    } else {
        $description = get_bloginfo('description');
    }
    if ($description) {
        printf("<meta name=\"description\" content=\"%s\">\n", esc_attr(wp_trim_words($description, 120, '')));
    }
}, 2);

// 抜粋の末尾を「…」にする
add_filter('excerpt_more', fn () => '…');
