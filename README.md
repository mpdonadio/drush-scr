drush-scr
=========

Random drush scripts that don't warrant a proper command and/or get modified for a particular site.

Carefully read the code for these and take backups before running.

delete-revisions.php
--------------------

Deletes all revisions for published nodes, other than the currently published one.  This uses the API, so field data
gets removed, and other Drupal cleanup gets done.  Back up your database before using this.  Seriously, I mean it.

<pre><code>
drush -u 1 scr delete-revisions.php
</code></pre>

generate-images.php
-------------------

Generates all image derivitives for all image styles for all managed images.  Use --flush=true to images from the
filesystem.  This uses the API to build URLs, so this can also be used to warm images served from a origin pull CDN.

Note: you either need to have $base_url defined in settings.php or the URI for your site set up in your drush
aliases for this to work properly.

<pre><code>
drush scr generate-images.php
drush scr generate-images.php --flush=true
</code></pre>

precache.php
------------

Precaches the home page, and all published node pages on a site.  Use --clear=true to zap the Drupal caches.

Note: you either need to have $base_url defined in settings.php or the URI for your site set up in your drush
aliases for this to work properly.

<pre><code>
drush scr precache.php
drush scr precache.php --clear=true
</code></pre>
