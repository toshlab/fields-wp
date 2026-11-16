<?php
/**
 * Contact Form 7 の調整
 */

// フォームを置いているのはトップページだけなので、CF7 の CSS・JS もそこでだけ読み込む
add_filter('wpcf7_load_js', fn () => is_front_page());
add_filter('wpcf7_load_css', fn () => is_front_page());

// デザインどおりのマークアップにするため、CF7 が自動で入れる <p>・<br> を止める
add_filter('wpcf7_autop_or_not', '__return_false');

/**
 * 「希望のクラス」の選択肢を、管理画面の「クラス」から自動で作る。
 * クラスを増やしたり名前を変えたりしても、フォームを直さなくてよい。
 */
add_filter('wpcf7_form_tag', function (array $tag) {
    if (($tag['name'] ?? '') !== 'school-class') {
        return $tag;
    }

    $labels = array_map(function (WP_Post $class) {
        $target = fields_class_field('target', $class->ID);

        return $target ? "{$class->post_title}（{$target}）" : $class->post_title;
    }, fields_classes());

    if ($labels) {
        // first_as_label の1つ目（「選んでください」）は残す
        $first = $tag['raw_values'][0] ?? __('選んでください', 'fields');
        $tag['raw_values'] = array_merge([$first], $labels);
        $tag['values'] = $tag['raw_values'];
        $tag['labels'] = $tag['raw_values'];
    }

    return $tag;
});
