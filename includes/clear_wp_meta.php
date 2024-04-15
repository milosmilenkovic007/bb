<?php

//clear wp meta
remove_action('wp_head', 'rsd_link'); //removes EditURI/RSD (Really Simple Discovery) link.
remove_action('wp_head', 'wlwmanifest_link'); //removes wlwmanifest (Windows Live Writer) link.
remove_action('wp_head', 'wp_generator'); //removes meta name generator.
remove_action('wp_head', 'feed_links', 2 ); //removes feed links.
remove_action('wp_head', 'feed_links_extra', 3 );  //removes comments feed.
remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);  // Disable oEmbed Discovery Links
remove_action('wp_head', 'wp_shortlink_wp_head');  // Disable shortlink