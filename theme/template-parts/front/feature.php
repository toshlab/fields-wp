<section class="sec feature" id="feature" style="padding-top:40px">
  <div class="wrap">
    <div class="sec-head">
      <span class="en-title" lang="en"><span>Feature</span></span>
      <h2 class="reveal"><?php fields_lines('feature_title'); ?></h2>
    </div>
    <div class="slider reveal" data-slider>
      <div class="slides">
        <?php for ($i = 1; $i <= 3; $i++) : $fields_img = fields_image_id("feature_{$i}_image"); ?>
          <div class="slide<?php echo $i === 1 ? ' is-active' : ''; ?>">
            <div class="pic">
              <?php if ($fields_img) : ?>
                <?php echo wp_get_attachment_image($fields_img, 'large'); ?>
              <?php else : ?>
                <?php /* 写真が未設定のあいだの目印（管理画面から写真を入れると消える） */ ?>
                <?php echo esc_html(sprintf(__('※ 写真に差し替え（%s）', 'fields'), fields_text("feature_{$i}_alt"))); ?>
              <?php endif; ?>
            </div>
          </div>
        <?php endfor; ?>
      </div>
      <div class="slide-text">
        <?php for ($i = 1; $i <= 3; $i++) : ?>
          <div class="item<?php echo $i === 1 ? ' is-active' : ''; ?>" id="feature-<?php echo $i; ?>" role="tabpanel" aria-labelledby="feature-tab-<?php echo $i; ?>">
            <span class="no en"><?php echo esc_html(sprintf('%02d', $i)); ?></span>
            <h3><?php echo esc_html(fields_text("feature_{$i}_title")); ?></h3>
            <p><?php fields_lines("feature_{$i}_text"); ?></p>
          </div>
        <?php endfor; ?>
        <div class="pager" role="tablist" aria-label="<?php esc_attr_e('特長の切り替え', 'fields'); ?>">
          <?php for ($i = 1; $i <= 3; $i++) : ?>
            <button type="button" role="tab" id="feature-tab-<?php echo $i; ?>" aria-controls="feature-<?php echo $i; ?>" aria-selected="<?php echo $i === 1 ? 'true' : 'false'; ?>" aria-label="<?php echo esc_attr(sprintf(__('特長%02d', 'fields'), $i)); ?>"><svg viewBox="0 0 52 52"><circle class="bg" cx="26" cy="26" r="23"/><circle class="fg" cx="26" cy="26" r="23"/></svg><?php echo esc_html(sprintf('%02d', $i)); ?></button>
          <?php endfor; ?>
          <button type="button" class="pause" data-pause aria-pressed="false" hidden><?php esc_html_e('一時停止', 'fields'); ?></button>
        </div>
      </div>
    </div>
  </div>
</section>
