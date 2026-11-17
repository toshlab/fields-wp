# CLAUDE.md

架空のサッカースクール「FIELDS」の WordPress オリジナルテーマ（ポートフォリオ用のサンプル）。toshLab（https://toshlab.jp）の実績として載せる。

## 最重要：公開リポジトリであること

実名・勤務先・個人のメールアドレスを、コード・コメント・ドキュメントに書かない。制作者の表記は「tosh / toshLab」。サンプルの住所・電話番号・料金は架空のものにする。

## 作り

- クラシックテーマ（PHP）＋ Advanced Custom Fields（無料版）＋ Contact Form 7
- 入力欄の定義はコードで持つ（`theme/inc/acf-fields.php`）。key は `field_fields_{グループ}_{名前}` で固定（`scripts/seed.php` が使う）
- ACF 無料版には繰り返しの入力欄が無いので、数が変わるもの（クラス・よくある質問）は投稿タイプにする
- 入力欄の値は `fields_text()` などのヘルパー（`theme/inc/template-tags.php`）で取り出す。空なら `theme/inc/defaults.php` の文章を出す
- 出力は必ずエスケープする（`esc_html`・`esc_url`・`esc_attr`・`wp_kses_post`）
- デザインの元は `toshlab/docs/design/reference/soccer-school-sample.html`（CSS・JS はほぼそのまま `theme/assets/` に移している）

## 開発コマンド

```shell
./scripts/setup.sh                                # 初回：インストール・プラグイン・サンプルの内容
docker compose run --rm wpcli wp <コマンド>       # WP-CLI
docker compose down                               # 停止
```

## CLI の共通ルール

- コミット・push はしない（git 操作は人が行う）
- 不明点は推測せず質問する
- パッケージ・プラグインの追加は、実行前に確認する
