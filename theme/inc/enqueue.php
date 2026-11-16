<?php

add_action('wp_enqueue_scripts', function () {
    $version = static fn (string $path): string => (string) filemtime(get_theme_file_path($path));

    wp_enqueue_style(
        'fields-fonts',
        'https://fonts.googleapis.com/css2?family=Archivo:wght@500;600;700;800&family=Noto+Sans+JP:wght@400;500;700;900&display=swap',
        [],
        null
    );
    wp_enqueue_style('fields-main', get_theme_file_uri('assets/css/main.css'), ['fields-fonts'], $version('assets/css/main.css'));

    // GSAP は CDN から。読み込めなくても main.js が全部表示する作りにしている
    wp_enqueue_script('gsap', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js', [], null, ['in_footer' => true]);
    wp_enqueue_script('gsap-scrolltrigger', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js', ['gsap'], null, ['in_footer' => true]);
    wp_enqueue_script('fields-main', get_theme_file_uri('assets/js/main.js'), ['gsap-scrolltrigger'], $version('assets/js/main.js'), ['in_footer' => true]);
});

add_action('wp_head', function () {
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
}, 3);
