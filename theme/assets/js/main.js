/**
 * FIELDS テーマの動き。デザインのHTML（soccer-school-sample.html）のスクリプトを元にしている。
 *
 * - トップページ以外にはスライダーやメイン画像が無いので、要素があるときだけ動かす
 * - GSAP が読み込めない／動きを減らす設定のときは、最初から全部表示する
 * - 申し込みフォームの送信は Contact Form 7 が行う
 */
(function () {
  var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var hasGsap = !!window.gsap && !!window.ScrollTrigger;
  var motion = hasGsap && !reduce;
  var loader = document.querySelector('.loader');

  /* ---------- スマホのメニュー ---------- */
  var menuBtn = document.querySelector('.menu-btn');
  var spNav = document.getElementById('sp-nav');
  if (menuBtn && spNav) {
    var setMenu = function (open) {
      menuBtn.setAttribute('aria-expanded', String(open));
      menuBtn.setAttribute('aria-label', open ? 'メニューを閉じる' : 'メニューを開く');
      spNav.hidden = !open;
    };
    menuBtn.addEventListener('click', function () {
      setMenu(menuBtn.getAttribute('aria-expanded') !== 'true');
    });
    spNav.addEventListener('click', function (e) {
      if (e.target.closest('a')) setMenu(false);
    });
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && menuBtn.getAttribute('aria-expanded') === 'true') {
        setMenu(false);
        menuBtn.focus();
      }
    });
  }

  /* ---------- 下の「無料体験」バー：メイン画像を過ぎたら出し、申し込みの所では隠す ---------- */
  var bar = document.querySelector('.trialbar');
  var hero = document.querySelector('.hero');
  var contact = document.getElementById('contact');
  if (bar && hero && contact) {
    var updateBar = function () {
      var h = hero.getBoundingClientRect();
      var c = contact.getBoundingClientRect();
      var show = h.bottom < window.innerHeight * 0.6 && c.top > window.innerHeight * 0.8;
      bar.classList.toggle('is-show', show);
      // 隠れているあいだは、Tab キーでフォーカスが当たらないようにする
      bar.toggleAttribute('inert', !show);
      bar.setAttribute('aria-hidden', String(!show));
    };
    window.addEventListener('scroll', updateBar, { passive: true });
    updateBar();
  }

  /* ---------- 特長のスライダー ---------- */
  var slider = document.querySelector('[data-slider]');
  var startSlider = function () {};
  if (slider) {
    var slides = slider.querySelectorAll('.slide');
    var items = slider.querySelectorAll('.item');
    var tabs = slider.querySelectorAll('[role="tab"]');
    var pauseBtn = slider.querySelector('[data-pause]');
    var DURATION = 5;
    var tween = null;
    var userPaused = false;
    var hoverPaused = false;

    var syncPause = function () {
      if (!tween) return;
      if (userPaused || hoverPaused) {
        tween.pause();
      } else {
        tween.resume();
      }
    };

    var go = function (i) {
      slides.forEach(function (s, n) { s.classList.toggle('is-active', n === i); });
      items.forEach(function (s, n) { s.classList.toggle('is-active', n === i); });
      tabs.forEach(function (t, n) {
        t.setAttribute('aria-selected', n === i ? 'true' : 'false');
        var fg = t.querySelector('.fg');
        if (motion) {
          gsap.killTweensOf(fg);
          gsap.set(fg, { strokeDasharray: '0 150' });
          if (n === i) {
            tween = gsap.to(fg, {
              strokeDasharray: '145 150',
              duration: DURATION,
              ease: 'none',
              onComplete: function () { go((i + 1) % slides.length); },
            });
            syncPause();
          }
        } else {
          fg.style.strokeDasharray = n === i ? '145 150' : '0 150';
        }
      });
      if (motion) {
        gsap.fromTo(slides[i].querySelector('.pic'), { scale: 1.08 }, { scale: 1, duration: 1.2, ease: 'power3.out' });
        gsap.fromTo(items[i].children, { y: 16, opacity: 0 }, { y: 0, opacity: 1, duration: 0.6, stagger: 0.08, ease: 'power3.out' });
      }
    };

    tabs.forEach(function (t, n) {
      t.addEventListener('click', function () { go(n); });
    });

    if (motion && pauseBtn) {
      // 自動で切り替わるので、止める手段を用意する（マウスを乗せる・フォーカスしても止まる）
      pauseBtn.hidden = false;
      pauseBtn.addEventListener('click', function () {
        userPaused = !userPaused;
        pauseBtn.setAttribute('aria-pressed', String(userPaused));
        pauseBtn.textContent = userPaused ? '再生' : '一時停止';
        syncPause();
      });
      slider.addEventListener('mouseenter', function () { hoverPaused = true; syncPause(); });
      slider.addEventListener('mouseleave', function () { hoverPaused = false; syncPause(); });
      slider.addEventListener('focusin', function () { hoverPaused = true; syncPause(); });
      slider.addEventListener('focusout', function (e) {
        if (!slider.contains(e.relatedTarget)) {
          hoverPaused = false;
          syncPause();
        }
      });
    }

    startSlider = function () { go(0); };
  }

  /* ---------- 動きを使わないとき：全部表示して終わり ---------- */
  if (!motion) {
    if (loader) loader.remove();
    document.querySelectorAll('.reveal').forEach(function (el) {
      el.style.opacity = 1;
      el.style.transform = 'none';
    });
    startSlider();
    return;
  }

  gsap.registerPlugin(ScrollTrigger);

  /* ---------- 読み込み → メイン画像（トップページだけ） ---------- */
  if (loader && document.querySelector('.hero-pitch')) {
    // 急いでいる保護者がスマホで見ることが多いので、ローディングは短くする
    var intro = gsap.timeline({ delay: 0.15 });
    intro.to(loader, { yPercent: -100, duration: 0.6, ease: 'power4.inOut', onComplete: function () { loader.remove(); } })
      .from('.hero-pitch', { clipPath: 'inset(10% 10% 10% 10%)', duration: 1.1, ease: 'power4.out' }, '-=.3')
      .from('.hero-pitch .draw', { strokeDasharray: 2400, strokeDashoffset: 2400, duration: 1.6, stagger: 0.12, ease: 'power2.inOut' }, '-=.8')
      .from('.hero-title .row span', { yPercent: 110, duration: 0.9, stagger: 0.1, ease: 'power4.out' }, '-=1.3')
      .from('.hero-copy .lead, .hero-copy .sub', { y: 16, opacity: 0, duration: 0.6, stagger: 0.1, ease: 'power3.out' }, '-=.5')
      .from('.hero-badge', { scale: 0, rotate: -90, duration: 0.8, ease: 'back.out(1.6)' }, '-=.5')
      .add(startSlider);

    // 「FREE TRIAL」の文字を回す
    gsap.to('.hero-badge svg', { rotate: 360, duration: 18, repeat: -1, ease: 'none', transformOrigin: '50% 50%' });

    // メイン画像の線を、スクロールに合わせて少し動かす
    gsap.to('.hero-pitch svg.lines', {
      yPercent: 8,
      ease: 'none',
      scrollTrigger: { trigger: '.hero', start: 'top top', end: 'bottom top', scrub: true },
    });
  } else {
    if (loader) loader.remove();
    startSlider();
  }

  /* ---------- スクロールで出す動き ---------- */
  gsap.utils.toArray('.sec-head .en-title span').forEach(function (el) {
    gsap.from(el, { yPercent: 105, duration: 1, ease: 'power4.out', scrollTrigger: { trigger: el, start: 'top 88%' } });
  });

  gsap.utils.toArray('.reveal').forEach(function (el) {
    gsap.to(el, { opacity: 1, y: 0, duration: 0.9, ease: 'power3.out', scrollTrigger: { trigger: el, start: 'top 86%' } });
  });

  gsap.utils.toArray('.vlines').forEach(function (v) {
    gsap.from(v.querySelectorAll('i'), { scaleY: 0, duration: 1.4, stagger: 0.08, ease: 'power3.inOut', scrollTrigger: { trigger: v, start: 'top 80%' } });
  });

  gsap.utils.toArray('.bar').forEach(function (b) {
    gsap.from(b, { scaleX: 0, duration: 1, ease: 'power3.out', scrollTrigger: { trigger: b, start: 'top 90%' } });
  });

  // 料金の数字は、最初から正しい金額のまま表示する（カウントアップはしない）
})();
