=== WP-Bookwormr ===
Contributors: mormanski	
Tags: reading, books, reviews, bookwormr
Requires at least: 2.0.2
Tested up to: 2.7.1
Stable tag: 1.0.0

Display the image and title of the book(s) you are currently reading in the sidebar.

== Description ==

This plugin shows the image and the title of the book you are currently reading in the sidebar. The plugin gets this information from your [Bookwormr](http://www.bookwormr.com/ "The Social Reading Revolution") reading list. Bookwormr is a completely free service where book lovers can list the books they are reading, have read and would like to read. Users can also write reviews and give each book a score. If you are reading more than one book the plugin randomly chooses a different book to display on each page request.

### 1.0.0 Release ###
Tested on Wordpress 2.7.1 and stable.

== Installation ==

1. Upload wp-bookwormr to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Place `<?php print bookwormr_display(); ?>` in your sidebar

### 0.1 Release ###
Initial release.

== Installation ==

1. Upload wp-bookwormr to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Place `<?php print bookwormr_display(); ?>` in your sidebar

== Frequently Asked Questions ==

= What do I need to use this plugin? =

This plugin uses the *CURL* library. If your server doesn't have this library wp-bookwormr automatically tries to get information from bookwormr using *fopen* instead.

== Screenshots ==

1. Screenshot of plugin in use.
