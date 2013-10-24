<?php

timer_start('precache');

$clear = drush_get_option('clear') == 'true';

if ($clear) {
  drupal_flush_all_caches();
}

$urls = array();

$urls[] = url('<front>', array('absolute' => TRUE));

$query = new EntityFieldQuery();
$entities = $query->entityCondition('entity_type', 'node', '=')
	->propertyCondition('status', 1)
	->execute();
	
$nids = array_keys($entities['node']);

foreach ($nids as $nid) {
	$urls[] = url('node/' . $nid, array('absolute' => TRUE));
}

foreach ($urls as $url) {
	$request = drupal_http_request($url);
}

timer_stop('precache');

$secs = round(timer_read('precache') / 1000);

watchdog('precache', 'precached @count url responses in @secs seconds', array(
	'@count' => count($urls),
	'@secs' => $secs,
), WATCHDOG_NOTICE);
