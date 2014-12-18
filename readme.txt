=== Plugin Name ===
Contributors: SwiftCloud
Tags: forms, web forms, polls, lead capture, landing page, 
Requires at least: 3.0
Tested up to: 4.1
Stable tag: 4.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Embeds SwiftForm.com (free HTML Forms generator) webforms via shortcode or widget tied to SwiftCloud apps. Free Signup at http://SwiftCloud.me

== Description ==
Instant embed of <a href="http://SwiftForm.com" target="_new">http://SwiftForm.com</a> Web-Forms, which is a drag-and-drop forms editor.

*This plugin requires a (free or paid) account on http://SwiftCloud.me to do anything useful.*

SwiftCloud is a business productivity suite in alpha, mostly of value to web designers and developers.

http://SwiftForm.com is currently 100% free and will always have free options. If you just want to make a 
nice looking form that emails you each time it is filled out, try it out.

===== Features of SwiftForm: =====
1. Fields like "Smart Zip" will automatically convert your zip code or postal code to city, state, zip, county, time zone
1. Time zone, language settings and other meta will be stored automatically
1. The complete URL of the page on which the form-data is sent from will be captured, including Google Analytics and other tracking data which will help with marketing, specifically, knowing how this person found you.
1. More features coming soon.

Currently this plugin does just one thing: 
1. Embed SwiftForm.com forms (a free drag and drop forms editor) into any Wordpress
1. In production: Google Analytics conversion to cookie, so as to pass it through on captures
1. In alpha: Lead Scoring


=== How to Use it ======
blog / website, using either widgets or shortcodes (using [swiftform formid=XXXXXX] where XXXXX = your form number, as provided
within the SwiftForm.com app.

These forms can then be automatically connected to...
* Autoresponder Sequences (in http://SwiftMarketing.com) 
* SwiftCRM Hosted Client Relationship Manager (http://SwiftCRM.com)
* SwiftBooks accounting (http://SwiftBooks.com)
* SwiftTasks task/project management system (locked in Private Alpha as of Oct 2014)

with additional use cases planned to follow. We welcome your feedback and requests.

== Installation ==
You probably know the drill by now, but if not, here's a step by step suggestion.

1. Upload the `SwiftCloud_WP` folder to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. To install a webform, login at http://SwiftForm.com (free signup) and click 'new form',
drag and drop fields to create a form, click save, and then remember the number it gives you.
1. Either drop a shortcode 

== Frequently Asked Questions ==

1. How do I use it?

See above. You need a SwiftCloud account (free for most applications) (sign up at http://SwiftCloud.me to use any 
SwiftCloud apps). To drop into a page-body, use shortcode [swiftform formid=XXXXXX] where XXXXX is your form number,
or drag and drop a widget on the Appearance >> Widgets section.

== Screenshots ==

Coming soon

== Changelog ==

= 0.2 =
* Alpha release.


`<?php code(); // goes in backticks ?>`