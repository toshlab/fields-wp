<?php $fields_classes = fields_classes(); ?>
<section class="sec" id="class" style="padding-top:40px">
  <div class="wrap">
    <div class="sec-head">
      <span class="en-title" lang="en"><span>Class</span></span>
      <h2 class="reveal"><?php esc_html_e('クラスと練習日時', 'fields'); ?></h2>
    </div>
    <?php if ($fields_classes) : ?>
      <div class="class-list">
        <?php foreach ($fields_classes as $fields_class) : ?>
          <div class="class-row reveal">
            <div class="name">
              <b><?php echo esc_html(get_the_title($fields_class)); ?></b>
              <?php if ($fields_en = fields_class_field('en', $fields_class->ID)) : ?><small lang="en"><?php echo esc_html($fields_en); ?></small><?php endif; ?>
            </div>
            <dl><dt><?php esc_html_e('対象', 'fields'); ?></dt><dd><?php echo esc_html(fields_class_field('target', $fields_class->ID)); ?></dd></dl>
            <dl><dt><?php esc_html_e('曜日・時間', 'fields'); ?></dt><dd><?php echo esc_html(fields_class_field('schedule', $fields_class->ID)); ?></dd></dl>
            <dl><dt><?php esc_html_e('会場', 'fields'); ?></dt><dd><?php echo esc_html(fields_class_field('venue', $fields_class->ID)); ?><span class="bar"></span></dd></dl>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else : ?>
      <p class="reveal"><?php esc_html_e('クラスの情報は準備中です。', 'fields'); ?></p>
    <?php endif; ?>
  </div>
</section>
