<?php

use Roots\Sage\Utils;

$datetime = new DateTime(get_post_time('r', true));
$datetime->setTimezone(new DateTimeZone(get_option('timezone_string')));
$human_date = Utils\human_date($datetime);
$attr_datetime = $datetime->format('c');
$attr_title = $datetime->format(get_option('date_format')) . ' at ' . $datetime->format(get_option('time_format'));

?>

<div class="entry-meta">
  <time class="updated" datetime="<?= $attr_datetime; ?>" title="<?= $attr_title; ?>">
    <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
    Posted <?= $human_date; ?>
  </time>
</div>
