<?php
  require_once(dirname(__FILE__).'/../config.php');
  HTML_HEAD(['<link rel="stylesheet" type="text/css" href="https://unpkg.com/leaflet@1.0.2/dist/leaflet.css">']);
?>

<body>

<?php HTML_HEADER(); ?>

<h1 class="contacts-h1"><?= T('ourContacts') ?></h1>

<p class="contacts-intro">
  <?= T('contactsIntro') ?>
</p>

<main role="main" class="contacts">

<section class="contacts__offices">
  <div class="contacts__office">
    <h2 class="contacts__h2"><?= T('headquarters') ?>:</h2>
    <h3 class="contacts__h3">VibroBox OÜ</h3>
    <address class="contacts__address">
      <?= T('addressEstonia') ?>
    </address>
  </div>
  <div class="contacts__office">
    <h2 class="contacts__h2"><?= T('developmentOffice') ?>:</h2>
    <h3 class="contacts__h3"><?= T('sitel') ?></h3>
    <address class="contacts__address">
      <?= T('addressBelarus') ?>
    </address>
  </div>
</section>

<!-- Map is rendered here by leaflet and our js code below. -->
<section id="leaflet-map" class="leaflet-map">
</section>

</main>

<?php HTML_FOOTER(); ?>

<!-- Code which renders leaflet map with #leaflet-map id above. It's here for localization. -->
<script type="text/javascript" src=https://unpkg.com/leaflet@1.0.2/dist/leaflet.js></script>
<script type="text/javascript">
  var map = L.map('leaflet-map', {scrollWheelZoom: false, zoomControl: false, dragging: false, touchZoom: false, doubleClickZoom: false, tap: false, boxZoom: false, keyboard: false, zoomSnap: 0.1}).setView([57.717, 24.840], 4.8);
  L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1Ijoidmlicm9ib3giLCJhIjoiY2l3Njhib2tqMDAwbzJ5czAxYTN4ZWt6dyJ9.1CqJcnto4oJNbHLvwzxc5A', {
    attribution: 'Map data © <a href="http://openstreetmap.org/">OpenStreetMap</a> | Imagery © <a href="http://mapbox.com/">Mapbox</a>',
    maxZoom: 19,
    id: 'vibrobox.28m6igh7',
    accessToken: 'pk.eyJ1Ijoidmlicm9ib3giLCJhIjoiY2l3Njhib2tqMDAwbzJ5czAxYTN4ZWt6dyJ9.1CqJcnto4oJNbHLvwzxc5A',
    detectRetina: true}).addTo(map);
  var strHeadquarters = '<?= T('headquarters') ?>';
  var strDevelopmentOffice = '<?= T('developmentOffice') ?>';
  var tallinn = L.marker([59.43411, 24.75434], {title: strHeadquarters, alt: strHeadquarters}).addTo(map);
  tallinn.bindPopup("<p>" + strHeadquarters + "</p>");
  var minsk = L.marker([53.94678, 27.61623], {title: strDevelopmentOffice, alt: strDevelopmentOffice}).addTo(map);
  minsk.bindPopup("<p>" + strDevelopmentOffice + "</p>");
</script>

</body>
</html>
