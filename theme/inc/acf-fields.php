<?php
/**
 * 管理画面の入力欄（Advanced Custom Fields 無料版）。
 *
 * 入力欄の定義をコードで持つと、テーマを入れるだけで同じ入力欄が使える（別の環境に移しても、設定し直さなくてよい）。
 * 無料版には「繰り返し」の入力欄が無いので、数が決まっているもの（特長3つ・流れ4ステップなど）は番号つきで並べ、
 * 数が変わるもの（クラス・よくある質問）は投稿タイプにしている（post-types.php）。
 */

if (! function_exists('acf_add_local_field_group')) {
    return;
}

/** 入力欄を1つ作る。key は「field_fields_{グループ}_{名前}」で固定する（seed.php からも使う） */
function fields_acf(string $group, string $name, string $label, string $type = 'text', array $extra = []): array
{
    return array_merge([
        'key' => "field_fields_{$group}_{$name}",
        'name' => $name,
        'label' => $label,
        'type' => $type,
        // 空なら、テーマに入っている文章（defaults.php）を表示する
        'placeholder' => in_array($type, ['text', 'textarea', 'url'], true) ? (fields_defaults()[$name] ?? '') : '',
    ], $extra);
}

function fields_acf_tab(string $group, string $label): array
{
    return ['key' => "field_fields_{$group}_tab_" . md5($label), 'label' => $label, 'type' => 'tab', 'placement' => 'top'];
}

add_action('acf/include_fields', function () {
    $g = 'front';
    $textarea = ['rows' => 3, 'new_lines' => ''];

    $fields = [
        fields_acf_tab($g, 'メイン画像'),
        fields_acf($g, 'hero_lead', 'キャッチコピー（h1）', 'textarea', $textarea + ['instructions' => '検索結果にも使われる、いちばん大事な見出しです。改行はそのまま反映されます。']),
        fields_acf($g, 'hero_sub', '英語の補足'),
        fields_acf($g, 'hero_image', 'メイン画像', 'image', ['return_format' => 'id', 'preview_size' => 'medium', 'instructions' => '設定しない場合は、ピッチのイラストを表示します。横長（16:8）の写真がおすすめです。']),
        fields_acf($g, 'notice_text', '一番上のお知らせの帯', 'text', ['instructions' => '空にすると、テーマの初期の文章を表示します。']),
        fields_acf($g, 'meta_description', '検索結果の説明文（meta description）', 'textarea', $textarea),

        fields_acf_tab($g, 'スクールについて'),
        fields_acf($g, 'about_title', '見出し', 'textarea', $textarea),
        fields_acf($g, 'about_text', '説明', 'textarea', $textarea),
    ];
    for ($i = 1; $i <= 3; $i++) {
        $fields[] = fields_acf($g, "about_{$i}_title", "ポイント{$i}：見出し");
        $fields[] = fields_acf($g, "about_{$i}_text", "ポイント{$i}：説明", 'textarea', $textarea);
    }

    $fields[] = fields_acf_tab($g, '特長');
    $fields[] = fields_acf($g, 'feature_title', '見出し', 'textarea', $textarea);
    for ($i = 1; $i <= 3; $i++) {
        $fields[] = fields_acf($g, "feature_{$i}_title", "特長{$i}：見出し");
        $fields[] = fields_acf($g, "feature_{$i}_text", "特長{$i}：説明", 'textarea', $textarea);
        $fields[] = fields_acf($g, "feature_{$i}_image", "特長{$i}：写真", 'image', ['return_format' => 'id', 'preview_size' => 'medium']);
    }

    $fields = array_merge($fields, [
        fields_acf_tab($g, '料金'),
        ['key' => 'field_fields_front_price_help', 'label' => '', 'name' => '', 'type' => 'message', 'message' => '月謝の金額は、左のメニューの「クラス」で、クラスごとに入力します。'],
        fields_acf($g, 'price_text', '説明', 'textarea', $textarea),
        fields_acf($g, 'price_note', '表の下の注意書き', 'textarea', $textarea),
        fields_acf($g, 'campaign_title', 'キャンペーン：名前'),
        fields_acf($g, 'campaign_text', 'キャンペーン：内容'),

        fields_acf_tab($g, '体験の流れ'),
        fields_acf($g, 'trial_text', '説明', 'textarea', $textarea),
    ]);
    for ($i = 1; $i <= 4; $i++) {
        $fields[] = fields_acf($g, "flow_{$i}_title", "STEP {$i}：見出し");
        $fields[] = fields_acf($g, "flow_{$i}_text", "STEP {$i}：説明", 'textarea', ['rows' => 2, 'new_lines' => '']);
    }

    $fields = array_merge($fields, [
        fields_acf_tab($g, 'アクセス'),
        fields_acf($g, 'venue_1_name', '会場1：名前'),
        fields_acf($g, 'venue_1_address', '会場1：住所'),
        fields_acf($g, 'venue_2_name', '会場2：名前'),
        fields_acf($g, 'venue_2_address', '会場2：住所'),
        fields_acf($g, 'rain_note', '雨の日の連絡'),
        fields_acf($g, 'map_embed_url', 'Googleマップの埋め込みURL', 'url', ['instructions' => 'Googleマップの「共有」→「地図を埋め込む」に出てくる iframe の src（https://www.google.com/maps/embed?… の部分）だけを貼ってください。']),

        fields_acf_tab($g, 'お申し込み'),
        fields_acf($g, 'contact_text', '説明', 'textarea', $textarea),
        [
            'key' => 'field_fields_front_form',
            'name' => 'contact_form',
            'label' => 'フォームのショートコード',
            'type' => 'text',
            'instructions' => 'Contact Form 7 のフォーム一覧に出てくるショートコード（[contact-form-7 id="…"]）を貼ってください。',
        ],
    ]);

    acf_add_local_field_group([
        'key' => 'group_fields_front',
        'title' => 'トップページの内容',
        'fields' => $fields,
        'location' => [[['param' => 'page_type', 'operator' => '==', 'value' => 'front_page']]],
        'position' => 'normal',
        'style' => 'default',
        // トップページは入力欄だけで作るので、本文のエディタは隠す
        'hide_on_screen' => ['the_content'],
    ]);

    $c = 'class';
    acf_add_local_field_group([
        'key' => 'group_fields_class',
        'title' => 'クラスの内容',
        'fields' => [
            fields_acf($c, 'en', '英語の名前', 'text', ['placeholder' => 'KIDS']),
            fields_acf($c, 'target', '対象', 'text', ['placeholder' => '年長〜小1', 'required' => 1]),
            fields_acf($c, 'schedule', '曜日・時間', 'text', ['placeholder' => '水 16:30〜17:30', 'required' => 1]),
            fields_acf($c, 'venue', '会場', 'text', ['placeholder' => '第一グラウンド']),
            fields_acf($c, 'fee', '月謝（税込・円）', 'number', ['min' => 0, 'step' => 100, 'required' => 1, 'append' => '円']),
            fields_acf($c, 'frequency', '回数', 'text', ['placeholder' => '週1回']),
        ],
        'location' => [[['param' => 'post_type', 'operator' => '==', 'value' => 'school_class']]],
        'position' => 'normal',
    ]);
});
