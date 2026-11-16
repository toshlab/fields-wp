#!/usr/bin/env bash
# 初回だけ実行する：WordPress のインストール、日本語化、プラグイン、テーマ、サンプルの内容。
# 何度実行しても壊れないようにしている（すでにあるものはそのまま）。
set -euo pipefail
cd "$(dirname "$0")/.."

wp() { docker compose run --rm wpcli wp "$@"; }

docker compose up -d
echo "WordPress の起動を待っています..."
until curl -s -o /dev/null http://localhost:8080; do sleep 2; done

if ! wp core is-installed 2>/dev/null; then
  # 手元の開発環境専用のユーザー（本番では使わない）
  wp core install \
    --url=http://localhost:8080 \
    --title="FIELDS FOOTBALL SCHOOL" \
    --admin_user=admin --admin_password=password \
    --admin_email=admin@example.com --skip-email
fi

wp language core install ja --activate
wp option update timezone_string "Asia/Tokyo"
wp option update blogdescription "フィールズ サッカースクール"
# サンプルサイトなので、検索エンジンに載せない
wp option update blog_public 0
wp rewrite structure "/%postname%/"

wp plugin install advanced-custom-fields contact-form-7 --activate
wp language plugin install --all ja || true

wp theme activate fields
wp eval-file /scripts/seed.php

echo
echo "できました： http://localhost:8080 （管理画面 http://localhost:8080/wp-admin  admin / password）"
echo "メールの確認： http://localhost:8025"
