<?php
/**
 * FIELDS テーマ
 *
 * 機能ごとにファイルを分けている。
 * - setup.php        テーマの基本設定・メニュー
 * - enqueue.php      CSS・JavaScript の読み込み
 * - post-types.php   クラス・よくある質問の投稿タイプ
 * - acf-fields.php   管理画面の入力欄（ACF）
 * - defaults.php     入力欄が空のときに表示する文章
 * - template-tags.php テンプレートで使う関数
 * - cf7.php          Contact Form 7 の調整
 */

if (! defined('ABSPATH')) {
    exit;
}

foreach (['setup', 'enqueue', 'post-types', 'acf-fields', 'defaults', 'template-tags', 'cf7'] as $file) {
    require_once get_theme_file_path("inc/{$file}.php");
}
