<?php
/**
 * 手元の開発環境でだけ、WordPress のメールを Mailpit に送る。
 * 環境変数 FIELDS_LOCAL_SMTP_HOST が無い環境（本番など）では何もしない。
 */

add_action('phpmailer_init', function ($phpmailer) {
    $host = getenv('FIELDS_LOCAL_SMTP_HOST');
    if (! $host) {
        return;
    }

    $phpmailer->isSMTP();
    $phpmailer->Host = $host;
    $phpmailer->Port = 1025;
    $phpmailer->SMTPAuth = false;
    $phpmailer->SMTPAutoTLS = false;
});
