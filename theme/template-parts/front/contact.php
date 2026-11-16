<?php $fields_form = fields_text('contact_form'); ?>
<section class="contact" id="contact">
  <div class="wrap">
    <p class="en-title reveal" lang="en">FREE<br>TRIAL</p>
    <h2 class="reveal"><?php esc_html_e('無料体験のお申し込み', 'fields'); ?></h2>
    <p class="reveal"><?php fields_lines('contact_text'); ?></p>
    <a class="btn reveal" href="#trial-form"><?php esc_html_e('フォームへ進む', 'fields'); ?><?php fields_arrow(); ?></a>

    <div id="trial-form" class="trial-form">
      <?php if ($fields_form && shortcode_exists('contact-form-7')) : ?>
        <?php echo do_shortcode($fields_form); ?>
      <?php else : ?>
        <p class="form-empty"><?php esc_html_e('申し込みフォームは準備中です。', 'fields'); ?></p>
      <?php endif; ?>
    </div>
  </div>
</section>
