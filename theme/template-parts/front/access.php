<?php
$fields_map = fields_text('map_embed_url');
$fields_faqs = get_posts(['post_type' => 'faq', 'numberposts' => -1, 'orderby' => ['menu_order' => 'ASC', 'ID' => 'ASC']]);
?>
<section class="sec" id="access" style="padding-top:40px">
  <div class="wrap">
    <div class="two">
      <div>
        <div class="sec-head" style="margin-bottom:40px">
          <span class="en-title" lang="en"><span>Access</span></span>
          <h2 class="reveal"><?php esc_html_e('アクセス', 'fields'); ?></h2>
        </div>
        <div class="map reveal">
          <?php if ($fields_map && str_starts_with($fields_map, 'https://www.google.com/maps/embed')) : ?>
            <iframe src="<?php echo esc_url($fields_map); ?>" title="<?php esc_attr_e('会場の地図', 'fields'); ?>" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
          <?php else : ?>
            <?php esc_html_e('※ Googleマップを埋め込み', 'fields'); ?>
          <?php endif; ?>
        </div>
        <dl class="info reveal" style="margin-top:32px">
          <?php for ($i = 1; $i <= 2; $i++) : if (! fields_text("venue_{$i}_name")) { continue; } ?>
            <div><dt><?php echo esc_html(fields_text("venue_{$i}_name")); ?></dt><dd><?php echo esc_html(fields_text("venue_{$i}_address")); ?></dd></div>
          <?php endfor; ?>
          <?php if (fields_text('rain_note')) : ?>
            <div><dt><?php esc_html_e('雨の日', 'fields'); ?></dt><dd><?php echo esc_html(fields_text('rain_note')); ?></dd></div>
          <?php endif; ?>
        </dl>
      </div>
      <div>
        <div class="sec-head" style="margin-bottom:40px">
          <span class="en-title" lang="en"><span>FAQ</span></span>
          <h2 class="reveal"><?php esc_html_e('よくあるご質問', 'fields'); ?></h2>
        </div>
        <?php if ($fields_faqs) : ?>
          <div class="faq reveal">
            <?php foreach ($fields_faqs as $fields_faq) : ?>
              <details>
                <summary><span><span class="q en">Q.</span><?php echo esc_html(get_the_title($fields_faq)); ?></span><span class="plus" aria-hidden="true"></span></summary>
                <?php echo wp_kses_post(wpautop($fields_faq->post_content)); ?>
              </details>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
