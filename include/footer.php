<footer class="footer">
  <ul class="footer__nav">
    <?php foreach (MainMenu() as $m) : ?>
    <li class="footer__nav-item">
      <a class="footer__link" href="<?= $m->url ?>"><?= $m->title ?></a>
    </li>
    <?php endforeach; ?>
    <?php foreach (GetCurrentPageTranslations() as $key => $t) : ?>
    <li class="footer__nav-item">
      <a class="footer__link" hreflang="<?= $key ?>" href="<?= $t['url'] ?>" rel="alternate">
        <?= $t['title'] ?>
      </a>
    </li>
    <?php endforeach; ?>
    <li class="footer__nav-item footer__nav-item--login">
      <a class="footer__link footer__link--login" href="<?= DEMO_URL ?>"><?= T('loginButton') ?></a>
    </li>
  </ul>
  <p class="footer__copyright"><?= T('copyright') ?></p>
</footer>

<?php // Do not load Google Analytics when developing on a localhost machine.
if (!IsDevelopmentMode()): ?>
<script>
(function(i, s, o, g, r, a, m) {
  i['GoogleAnalyticsObject'] = r;
  i[r] = i[r] || function() {
    (i[r].q = i[r].q || []).push(arguments)
  }, i[r].l = 1 * new Date();
  a = s.createElement(o), m = s.getElementsByTagName(o)[0];
  a.async = 1;
  a.src = g;
  m.parentNode.insertBefore(a, m)
})(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');
ga('create', '<?= GOOGLE_ANALYTICS_ID ?>', 'auto');
ga('send', 'pageview');
</script>
<?php endif ?>

