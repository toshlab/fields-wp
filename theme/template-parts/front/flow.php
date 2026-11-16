<section class="sec" id="flow">
  <div class="vlines" aria-hidden="true"><i></i><i></i><i></i><i></i><i></i></div>
  <div class="wrap">
    <div class="sec-head">
      <span class="en-title" lang="en"><span>Trial</span></span>
      <h2 class="reveal"><?php esc_html_e('無料体験の流れ', 'fields'); ?></h2>
      <p class="reveal"><?php fields_lines('trial_text'); ?></p>
    </div>
    <ol class="flow">
      <?php for ($i = 1; $i <= 4; $i++) : ?>
        <li class="reveal">
          <span class="step en"><?php echo esc_html(sprintf('STEP %02d', $i)); ?></span>
          <h3><?php echo esc_html(fields_text("flow_{$i}_title")); ?></h3>
          <p><?php fields_lines("flow_{$i}_text"); ?></p>
        </li>
      <?php endfor; ?>
    </ol>
  </div>
</section>
