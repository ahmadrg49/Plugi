<?php

/**
*@package pluginTask
*/


global $wpdb;
$wpdb->query( "DELETE FROM wp_posts WHERE post_type = 'Task'");
$wpdb->query( "DELETE FROM wp_postmeta WHERE post_id NOT IN (SELECT id FROM wp_posts)");
$wpdb->query( "DELETE FROM wp_ter_relations WHERE object_id NOT IN (SELECT id FROM wp_posts)");




?>