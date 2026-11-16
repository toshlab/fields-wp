<?php $fields_hero_image = fields_image_id('hero_image'); ?>
<section class="hero" aria-label="<?php esc_attr_e('メインビジュアル', 'fields'); ?>">
  <div class="wrap">
    <div class="hero-frame">
      <div class="hero-pitch">
        <?php if ($fields_hero_image) : ?>
          <?php echo wp_get_attachment_image($fields_hero_image, 'full', false, ['class' => 'hero-image', 'loading' => 'eager', 'fetchpriority' => 'high']); ?>
        <?php endif; ?>
        <svg class="lines" viewBox="0 0 1600 800" preserveAspectRatio="xMidYMid slice" aria-hidden="true">
          <g fill="none" stroke="rgba(255,255,255,.85)" stroke-width="5">
            <path class="draw" d="M800 0V800"/>
            <circle class="draw" cx="800" cy="400" r="170"/>
            <rect class="draw" x="40" y="40" width="1520" height="720"/>
            <rect class="draw" x="40" y="220" width="200" height="360"/>
            <rect class="draw" x="1360" y="220" width="200" height="360"/>
          </g>
          <circle cx="800" cy="400" r="8" fill="#fff"/>
        </svg>
        <div class="shade"></div>
        <div class="hero-copy">
          <p class="hero-title" lang="en">
            <span class="row"><span>PLAY,</span></span>
            <span class="row"><span>LEARN,</span></span>
            <span class="row"><span>GROW.</span></span>
          </p>
          <?php // 検索で見つけてもらえるよう、h1 は日本語のキャッチコピーにする ?>
          <h1 class="lead"><?php fields_lines('hero_lead'); ?></h1>
          <p class="sub" lang="en"><?php echo esc_html(fields_text('hero_sub')); ?></p>
        </div>
        <div class="hero-badge" aria-hidden="true">
          <svg viewBox="0 0 140 140"><defs><path id="circ" d="M70 70m-56 0a56 56 0 1 1 112 0a56 56 0 1 1-112 0"/></defs><circle cx="70" cy="70" r="68" fill="#E85A1C"/><text font-family="Archivo" font-weight="700" font-size="12.5" letter-spacing="3" fill="#1B1B1B"><textPath href="#circ">FREE TRIAL • FREE TRIAL • FREE TRIAL •</textPath></text></svg>
          <div class="center"><b><?php esc_html_e('無料', 'fields'); ?></b><small><?php esc_html_e('体験受付中', 'fields'); ?></small></div>
        </div>
      </div>
    </div>
  </div>
</section>
