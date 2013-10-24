<?php

timer_start('generate-images');

$styles = array_keys(image_styles());

$flush = drush_get_option('flush') == 'true';

if ($clear) {
	foreach ($styles as $style) {
	  image_style_flush($style);
	}
}

$results = db_query("SELECT uri FROM {file_managed} WHERE status = 1 AND filemime LIKE 'image/%'")
  ->fetchAll();

foreach ($results as $record) {
  $uri = $record->uri;
  
  foreach ($styles as $style) {
    $url = image_style_url($style, $uri);
    $request = drupal_http_request($url);
  }
}

timer_stop('generate-images');

$secs = round(timer_read('generate-images') / 1000);

watchdog('generate-images', 'generated image styles in @secs seconds',
	array('@secs' => $secs), WATCHDOG_NOTICE);
