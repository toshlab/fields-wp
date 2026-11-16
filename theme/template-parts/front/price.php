<?php
// 料金の表は「クラス」の月謝から作る（金額の入力は1か所だけで済む）
$fields_classes = fields_classes();
?>
<section class="sec price" id="price">
  <div class="wrap">
    <div class="sec-head">
      <span class="en-title" lang="en"><span>Price</span></span>
      <h2 class="reveal"><?php esc_html_e('料金', 'fields'); ?></h2>
      <p class="reveal"><?php fields_lines('price_text'); ?></p>
    </div>
    <?php if ($fields_classes) : ?>
      <div class="table-scroll reveal">
        <table class="ptable">
          <thead><tr><th scope="col"><span class="sr"><?php esc_html_e('クラス', 'fields'); ?></span></th><th scope="col" class="hl"><?php esc_html_e('月謝', 'fields'); ?></th><th scope="col"><?php esc_html_e('回数', 'fields'); ?></th></tr></thead>
          <tbody>
            <?php foreach ($fields_classes as $fields_class) : ?>
              <tr>
                <th scope="row"><?php echo esc_html(get_the_title($fields_class)); ?><?php if ($fields_en = fields_class_field('en', $fields_class->ID)) : ?><small lang="en"><?php echo esc_html($fields_en); ?></small><?php endif; ?></th>
                <td><span class="yen"><?php echo esc_html(fields_yen(fields_class_field('fee', $fields_class->ID))); ?><sup lang="en">yen<br>(tax in)</sup></span></td>
                <td><?php echo esc_html(fields_class_field('frequency', $fields_class->ID)); ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
    <p class="price-note"><?php fields_lines('price_note'); ?></p>
    <?php if (fields_text('campaign_title')) : ?>
      <div class="campaign reveal"><b><?php echo esc_html(fields_text('campaign_title')); ?></b><span><?php echo esc_html(fields_text('campaign_text')); ?></span></div>
    <?php endif; ?>
  </div>
</section>
