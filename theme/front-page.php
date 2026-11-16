<?php
/**
 * トップページ。各セクションは template-parts/front/ に分けている。
 * 文章は「固定ページ → トップ」の入力欄、クラス・よくある質問・お知らせはそれぞれの投稿から読み込む。
 */
get_header();

foreach (['news-bar', 'hero', 'about', 'class', 'feature', 'price', 'flow', 'access', 'contact'] as $part) {
    get_template_part('template-parts/front/' . $part);
}

get_footer();
