=== Plugin Name ===
Contributors: robert.kay
Donate link: http://freedomonlineservices.net/
Tags: resources, organise, display, custom post type
Requires at least: 3.0.1
Tested up to: 3.5
Stable tag: 0.6
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Adds a resources post type and simple php calls to display them.

== Description ==

Adds a resources post type and simple php calls to display them.

More docs at http://freedomonlineservices.net/resources/homegrown/resources-plugin/
Live example at http://www.freedomonlineservices.net/pluginshowroom/resources/

== Installation ==

1. Upload the 'Resources' folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3.
Call get_all_resources() on your resources page template (page-resources.php)
<div id="primary" class="site-content">
	<div id="content" role="main">
			<?php /* Start the Loop */
			get_all_resources();
	</div><!-- #content -->
</div><!-- #primary -->
Call get_tax_resources() on your taxonomy page template (taxonomy-restype.php)
eg:
<div id="primary" class="site-content">
		<div id="content" role="main">
			<?php /* Start the Loop */
			get_tax_resources();
            ?>
	</div><!-- #content -->
</div><!-- #primary -->
 
== Frequently Asked Questions ==


== Changelog ==

= 0.6 =
First release
