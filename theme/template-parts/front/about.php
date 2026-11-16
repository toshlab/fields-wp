<section class="sec" id="about">
  <div class="vlines" aria-hidden="true"><i></i><i></i><i></i><i></i><i></i></div>
  <div class="wrap">
    <div class="sec-head">
      <span class="en-title" lang="en"><span>About</span></span>
      <h2 class="reveal"><?php fields_lines('about_title'); ?></h2>
      <p class="reveal"><?php fields_lines('about_text'); ?></p>
    </div>
    <div class="btns reveal">
      <a class="btn primary" href="#flow"><?php esc_html_e('無料体験について', 'fields'); ?><?php fields_arrow(); ?></a>
      <a class="btn dark" href="#class"><?php esc_html_e('クラス・日程', 'fields'); ?><?php fields_arrow(); ?></a>
      <a class="btn dark" href="#price"><?php esc_html_e('料金', 'fields'); ?><?php fields_arrow(); ?></a>
    </div>
    <div class="about-grid">
      <?php for ($i = 1; $i <= 3; $i++) : ?>
        <div class="reveal">
          <span class="num en"><?php echo esc_html(sprintf('%02d', $i)); ?></span>
          <h3><?php echo esc_html(fields_text("about_{$i}_title")); ?></h3>
          <p><?php fields_lines("about_{$i}_text"); ?></p>
        </div>
      <?php endfor; ?>
    </div>
  </div>
</section>
