<?php
/**
 * サンプルの内容を入れる（wp eval-file で実行）。同じ名前のものがあれば作り直さない。
 * 文章はすべて架空のスクールのもの。
 */

if (! function_exists('update_field')) {
    WP_CLI::error('ACF が有効になっていません。');
}

function fields_seed_post(array $args): int
{
    $found = get_posts([
        'post_type' => $args['post_type'],
        'title' => $args['post_title'],
        'post_status' => 'any',
        'numberposts' => 1,
        'fields' => 'ids',
    ]);
    if ($found) {
        return (int) $found[0];
    }

    return (int) wp_insert_post($args + ['post_status' => 'publish'], true);
}

// --- WordPress が最初に入れる「Hello world!」の記事と「サンプルページ」は消す ---
foreach ([['post', 'hello-world'], ['page', 'sample-page']] as [$type, $slug]) {
    $default = get_page_by_path($slug, OBJECT, $type);
    if ($default) {
        wp_delete_post($default->ID, true);
    }
}

// --- 固定ページ：トップ・お知らせ一覧 ---
$front = fields_seed_post(['post_type' => 'page', 'post_title' => 'トップ', 'post_name' => 'top']);
$news = fields_seed_post(['post_type' => 'page', 'post_title' => 'お知らせ', 'post_name' => 'news']);
update_option('show_on_front', 'page');
update_option('page_on_front', $front);
update_option('page_for_posts', $news);

// --- お知らせ ---
fields_seed_post([
    'post_type' => 'post',
    'post_title' => '春の無料体験会を開催します（各クラス定員10名）',
    'post_name' => 'spring-trial',
    'post_content' => "4月の毎週土曜日に、全クラスの無料体験会を行います。\n\nお申し込みは、トップページの下のフォームからどうぞ。",
]);
fields_seed_post([
    'post_type' => 'post',
    'post_title' => 'GKクラスの練習時間が変わります',
    'post_name' => 'gk-schedule',
    'post_content' => '5月から、GKクラスの練習は土曜 9:00〜10:30 になります。',
    'post_date' => date('Y-m-d H:i:s', strtotime('-10 days')),
]);

// --- クラス（料金の表もここから作る） ---
$classes = [
    ['キッズ', 'KIDS', '年長〜小1', '水 16:30〜17:30', '第一グラウンド', 5500, '週1回'],
    ['ジュニア', 'JUNIOR', '小2〜小3', '火・金 17:00〜18:15', '第一グラウンド', 8800, '週2回'],
    ['アドバンス', 'ADVANCE', '小4〜小6', '火・木・金 18:15〜19:45', '第一グラウンド', 11000, '週3回'],
    ['GKクラス', 'GOALKEEPER', '小3〜小6', '土 9:00〜10:30', '第二グラウンド', 4400, '週1回'],
];
foreach ($classes as $i => [$name, $en, $target, $schedule, $venue, $fee, $freq]) {
    $id = fields_seed_post(['post_type' => 'school_class', 'post_title' => $name, 'menu_order' => $i]);
    update_field('field_fields_class_en', $en, $id);
    update_field('field_fields_class_target', $target, $id);
    update_field('field_fields_class_schedule', $schedule, $id);
    update_field('field_fields_class_venue', $venue, $id);
    update_field('field_fields_class_fee', $fee, $id);
    update_field('field_fields_class_frequency', $freq, $id);
}

// --- よくある質問 ---
$faqs = [
    ['サッカーが初めてでも大丈夫ですか？', 'はい。キッズとジュニアのクラスは、ほとんどのお子さまが未経験から始めています。'],
    ['送り迎えは必要ですか？', '送迎バスはありません。保護者の方の送り迎えをお願いしています。'],
    ['ユニフォームは購入が必要ですか？', '入会後に練習着（上下セット）をご購入いただきます。体験のときは不要です。'],
    ['途中から入会できますか？', '空きがあれば、いつでも入会できます。月の途中の場合、その月の月謝は回数に応じて計算します。'],
];
foreach ($faqs as $i => [$q, $a]) {
    fields_seed_post(['post_type' => 'faq', 'post_title' => $q, 'post_content' => $a, 'menu_order' => $i]);
}

// --- 無料体験の申し込みフォーム（Contact Form 7） ---
if (class_exists('WPCF7_ContactForm')) {
    // CF7 を有効にしたときに自動で作られる「Contact form 1」は使わないので消す
    foreach (get_posts(['post_type' => 'wpcf7_contact_form', 'name' => 'contact-form-1', 'numberposts' => -1]) as $default) {
        wp_delete_post($default->ID, true);
    }

    $title = '無料体験のお申し込み';
    $existing = get_posts(['post_type' => 'wpcf7_contact_form', 'title' => $title, 'numberposts' => 1]);
    $form = $existing ? WPCF7_ContactForm::get_instance($existing[0]->ID) : WPCF7_ContactForm::get_template(['locale' => 'ja']);
    $form->set_title($title);
    $props = $form->get_properties();
    $props['form'] = file_get_contents(get_theme_file_path('inc/cf7-form-template.txt'));
    $props['mail']['subject'] = '[_site_title] 無料体験のお申し込み：[your-name] 様';
    $props['mail']['sender'] = '[_site_title] <wordpress@example.com>';
    $props['mail']['recipient'] = '[_site_admin_email]';
    $props['mail']['additional_headers'] = 'Reply-To: [your-email]';
    $props['mail']['body'] = "保護者のお名前：[your-name]\nメールアドレス：[your-email]\n電話番号：[your-tel]\nお子さまの学年：[grade]\n希望のクラス：[school-class]\n\nご質問など：\n[your-message]\n\n-- \n[_site_title] の申し込みフォームから送信されました";
    $form->set_properties($props);
    $form->save();
    update_field('field_fields_front_form', $form->shortcode(), $front);
}

WP_CLI::success('サンプルの内容を入れました。');
