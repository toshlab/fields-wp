<?php
/**
 * テンプレートで使う関数。ACF が無くても動くように、値の取り出しはここに集める。
 */

/** トップページ（固定ページ）の ID */
function fields_front_id(): int
{
    return (int) get_option('page_on_front');
}

/**
 * トップページの入力欄の値。空なら defaults.php の文章を返す。
 */
function fields_text(string $name): string
{
    $value = function_exists('get_field') ? get_field($name, fields_front_id()) : null;
    if (is_string($value) && trim($value) !== '') {
        return $value;
    }

    return fields_defaults()[$name] ?? '';
}

/** 改行を <br> にして出力する（入力された文章は必ずエスケープする） */
function fields_lines(string $name): void
{
    echo nl2br(esc_html(fields_text($name)), false);
}

/** トップページの画像の入力欄（添付ファイルの ID）。無ければ 0 */
function fields_image_id(string $name): int
{
    if (! function_exists('get_field')) {
        return 0;
    }

    return (int) get_field($name, fields_front_id(), false);
}

/** クラスの入力欄の値 */
function fields_class_field(string $name, int $post_id): string
{
    if (! function_exists('get_field')) {
        return '';
    }

    return (string) get_field($name, $post_id);
}

/** ボタンの右の矢印 */
function fields_arrow(): void
{
    echo '<span class="arrow" aria-hidden="true"><svg width="12" height="12" viewBox="0 0 12 12"><path d="M4 2l4 4-4 4" fill="none" stroke="currentColor" stroke-width="1.8"/></svg></span>';
}

/**
 * ヘッダーのメニュー。管理画面の「メニュー」で作れば、それを使う。
 * 作っていなければ、トップページの各セクションへのリンクを出す。
 *
 * @return array<int, array{label: string, url: string}>
 */
function fields_nav_items(): array
{
    $locations = get_nav_menu_locations();
    if (! empty($locations['global'])) {
        $items = wp_get_nav_menu_items($locations['global']) ?: [];

        return array_map(fn ($item) => ['label' => $item->title, 'url' => $item->url], $items);
    }

    $home = home_url('/');

    return [
        ['label' => __('スクールについて', 'fields'), 'url' => $home . '#about'],
        ['label' => __('クラス・日程', 'fields'), 'url' => $home . '#class'],
        ['label' => __('特長', 'fields'), 'url' => $home . '#feature'],
        ['label' => __('料金', 'fields'), 'url' => $home . '#price'],
        ['label' => __('体験の流れ', 'fields'), 'url' => $home . '#flow'],
        ['label' => __('アクセス', 'fields'), 'url' => $home . '#access'],
    ];
}

/** 公開中のクラス（並び順どおり） */
function fields_classes(): array
{
    return get_posts([
        'post_type' => 'school_class',
        'numberposts' => -1,
        'orderby' => ['menu_order' => 'ASC', 'ID' => 'ASC'],
    ]);
}

/** 月謝の表示（5500 → 5,500） */
function fields_yen(string $value): string
{
    return is_numeric($value) ? number_format((int) $value) : $value;
}
