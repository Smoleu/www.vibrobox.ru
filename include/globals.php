<?php

require_once('page_params.php');
require_once('translations.php');

// Returns true if site is running on localhost.
function IsDevelopmentMode() {
  return array_key_exists('SERVER_SOFTWARE', $_SERVER) and
      1 === preg_match('/PHP.+Development Server/', $_SERVER['SERVER_SOFTWARE']);
}

function BaseURL() {
  // Replace BaseURL when developing on localhost.
  if (IsDevelopmentMode()) {
    $scheme = (isset($_SERVER['HTTPS']) and !empty($_SERVER['HTTPS'])) ? 'https' : 'http';
    return "${scheme}://${_SERVER['HTTP_HOST']}/";
  }

  // Get base url from list of available translations.
  return LANG_SITES[LANG];
}

// $link can be any absolute link without leading slash or .php page name.
function URL($link) {
  // Root/home/index page.
  if (empty($link) or $link == '/')
    return BaseURL();
  // Generated pages should use directory/index.html structure.
  // Github Pages require '/' at the end of IRI.
  $optionalSlash = IsDevelopmentMode() ? '' : '/';
  // Extract page link directly from the page's file.
  if (EndsWith($link, '.php'))
    return JoinIRI(BaseURL(), ExtractLinkFromPage($link)) . $optionalSlash;
  // Correctly replace relative links with absolute ones.
  if ($link[0] == '#')
    return JoinIRI(BaseURL(), PageLink()) . $optionalSlash . $link;

  return JoinIRI(BaseURL(), $link);
}

function HTML_HEAD() {
  require_once('head.php');
}

function HTML_HEADER() {
  require_once('header.php');
}

function HTML_FOOTER() {
  require_once('footer.php');
}

function MainMenu() {
  $menuPages = [
    'index.php' => 'menuIndexPage',
    'technology.php' => 'menuTechnologyPage',
    'team.php' => 'menuTeamPage',
    'faq.php' => 'menuFaqPage',
    'contact.php' => 'menuContactPage',
  ];

  foreach ($menuPages as $page => $menuTitle)
    $menu[] = new MenuItem(URL($page), T($menuTitle), $page == PageFile());
  return $menu;
}

function IsRelativeIRI($iri) {
  return empty(parse_url($iri, PHP_URL_SCHEME));
}

// Include and preprocess content (e.g. fix relative links and image sources).
// Translated versions like content/baseName.ru.html have priority over content/baseName.html.
// Subdirectories in content dir are also supported.
// TODO: Move base content directory path to web-site settings file.
function IncludeContent($baseName) {
  $basePath = dirname(__FILE__).'/../content/' . $baseName;

  // TODO: correctly process multiple matches.
  $paths = glob($basePath . '.' . LANG . '*');
  if (empty($paths))
    $paths = glob($basePath . '.*');

  if (empty($paths))
    die("Error loading content from $basePath");

  ob_start();
  include($paths[0]);
  $html = ob_get_clean();

  // Fix relative links.
  // TODO: Fix all relative links automatically everywhere, not only in the included content
  // to make URL() calls unnecessary.
  ReplacePattern('/ (?:src|href)=[\'"]?([^\'" >]+)/', $html, 'URL', 'IsRelativeIRI');
  echo $html;
}

function GetCurrentPageTranslations() {
  $translations = [];
  foreach(LANG_SITES as $key=>$url) {
    if (LANG !== $key) {
      $translations[$key] = ['url' => JoinIRI($url, PageLink()), 'title' => T('language', $key)];
    }
  }

  return $translations;
}
?>
