</main>

<footer class="footer">
  <div class="wrap">
    <div>
      <b lang="en"><?php echo esc_html(strtok(get_bloginfo('name'), ' ')); ?></b><br>
      <?php bloginfo('description'); ?><?php esc_html_e('（架空のスクールです）', 'fields'); ?>
    </div>
    <div>Design &amp; Development: <a href="https://toshlab.jp">tosh / toshLab</a></div>
  </div>
</footer>

<?php if (is_front_page()) : ?>
  <div class="trialbar" aria-hidden="true" inert>
    <a href="#trial-form">
      <span><span class="en">Free Trial</span><small><?php esc_html_e('無料体験のお申し込みはこちら', 'fields'); ?></small></span>
      <span class="plus" aria-hidden="true">+</span>
    </a>
  </div>
<?php endif; ?>

<?php wp_footer(); ?>
</body>
</html>
