<?php
/**
 * クラスとよくある質問。どちらも一覧ページは持たず、トップページに表示する。
 * 並び順は「ページ属性」の順序（menu_order）。
 */

add_action('init', function () {
    register_post_type('school_class', [
        'labels' => [
            'name' => __('クラス', 'fields'),
            'singular_name' => __('クラス', 'fields'),
            'add_new_item' => __('クラスを追加', 'fields'),
            'edit_item' => __('クラスを編集', 'fields'),
        ],
        'public' => false,
        'show_ui' => true,
        'show_in_rest' => true,
        'menu_icon' => 'dashicons-groups',
        'menu_position' => 20,
        'supports' => ['title', 'page-attributes'],
    ]);

    register_post_type('faq', [
        'labels' => [
            'name' => __('よくある質問', 'fields'),
            'singular_name' => __('よくある質問', 'fields'),
            'add_new_item' => __('質問を追加', 'fields'),
            'edit_item' => __('質問を編集', 'fields'),
        ],
        'public' => false,
        'show_ui' => true,
        'show_in_rest' => true,
        'menu_icon' => 'dashicons-editor-help',
        'menu_position' => 21,
        'supports' => ['title', 'editor', 'page-attributes'],
    ]);
});

// タイトルの入力欄の案内を、投稿タイプに合わせる
add_filter('enter_title_here', function (string $title, WP_Post $post) {
    return match ($post->post_type) {
        'school_class' => __('クラス名（例：キッズ）', 'fields'),
        'faq' => __('質問（例：サッカーが初めてでも大丈夫ですか？）', 'fields'),
        default => $title,
    };
}, 10, 2);

// 管理画面の一覧に「順序」の列を出す
foreach (['school_class', 'faq'] as $type) {
    add_filter("manage_{$type}_posts_columns", fn (array $cols) => $cols + ['menu_order' => __('順序', 'fields')]);
    add_action("manage_{$type}_posts_custom_column", function (string $col, int $id) {
        if ($col === 'menu_order') {
            echo (int) get_post_field('menu_order', $id);
        }
    }, 10, 2);
}
