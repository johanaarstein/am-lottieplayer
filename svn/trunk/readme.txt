=== AM LottiePlayer ===
Contributors: johanaarstein
Donate link: https://www.paypal.com/donate/?hosted_button_id=E7C7DMN8KSQ6A
Author URI: https://www.aarstein.media
Plugin URI: https://wordpress.org/plugins/am-lottieplayer/
Tags: lottie, bodymovin, gutenberg, svg, gif
Requires at least: 5.9
Tested up to: 6.8
Requires PHP: 7.2
Stable Tag: 3.5.16
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

The most complete Lottie Player plugin! It is lightweight, versatile and easy to use, and it works with Gutenberg, Divi, Elementor and Flatsome.

== Description ==

**The most complete free Lottie Player yet.**

AM LottiePlayer is easy to use, lightweight, and gives you total control over how to implement crisp, vectorized animations to your website. Easily set up user interactions, choose between JSON or the optimized dotLottie format, choose whether to serve the files from a CDN or your own *Media Library*, choose how to scale the animation, add a nice description for screen readers and search eninge crawlers, and you're off to the races!

Upload Lottie animations to WordPress and add them to Gutenberg, Divi, Elementor, Bricks, Flatsome UX Builder, or via the shortcode `[am-lottieplayer]`. This plugin also offer partial support for WPBakery (formerly Visual Studio).

= Features =

- Contains two Gutenberg blocks: a player and a cover block with text overlay – great for headers.
- Contains a Divi Builder Module
- Contains an Elementor Widget
- Contains a Bricks Element
- Contains the shortcode `[am-lottieplayer]`
- Has intergration for Flatsome UX Builder
- Has partial support for WPBakery (formerly Visual Studio)
- Scripts are only loaded for pages where the player is used
- Upload Lottie JSON or dotLottie files to your *Media Library*
- Drag & drop a Lottie JSON or dotLottie file
- Insert a Lottie JSON or dotLottie animation from URL
- Choose scaling, speed, size, background color, interactions and more from the block settings in Gutenberg. The same settings are accessible in the Divi Module menu, the Elementor Widget menu, the Flatsome UX Builder menu, and WPBakery menu.

= Links =

* [Website](https://www.aarstein.media/en/am-lottieplayer)
* [AM LottiePlayer PRO](https://www.aarstein.media/en/am-lottieplayer/pro)

= PRO =

AM LottiePlayer is also available in a professional version, which includes more functionality and flexibility. The AM LottiePlayer PRO features are:

* Combine animations in a single file via drag and drop
* Control interactions and behaviour of each animation in multi-animation files
* Convert JSON-lotties to dotLottie in an easy-to use GUI
* Choose renderer: SVG, Canvas or HTML
* More of the functionality from animations made with After Effects

[Upgrade to AM LottiePlayer PRO](https://www.aarstein.media/en/am-lottieplayer/pro)

== Installation ==

= Automatic installation =

Automatic installation is the easiest option — WordPress will handle the file transfer, and you won’t need to leave your web browser.

1. Log in to your WordPress dashboard
2. Navigate to the **Plugins** menu
3. Search for **AM LottiePlayer**
4. Click **Install Now** and WordPress will take it from there
5. Activate the plugin through the **Plugins** menu in WordPress

= Manual installation =

1. Upload the entire 'am-lottieplayer' folder to your plugins directory
2. Activate the plugin through the **Plugins** menu in WordPress

= After activation =

1. Go to the WordPress Block Editor / Elementor / Divi Builder / Flatsome UX Builder
2. Add new block / widget / module
3. Search for *Lottie*
4. Click on *Lottie* to add the block

If you want to use the shortcode `[am-lottieplayer]`, it has the following parameters:

- src: `string` (required)
- autoplay: `true` | `false`, default: `false`
- controls: `true` | `false`, default: `false`
- loop: `true` | `false`, default: `false`
- objectfit: `cover` | `contain` | `none`, default: `contain`
- speed: `number` (1 – 5), default: `1`
- direction: `1` | `-1`, default: `1`
- onclick: `true` | `false`, default: `false`
- onmouseover: `true` | `false`, default: `false`
- onmouseout: `void` | `stop` | `pause` | `reverse`, default: `void`

== Feedback ==

We'd love to [hear from you](mailto:johan@aarstein.media)!

Thanks for using our plugin! Please take a moment to [rate it](https://wordpress.org/support/view/plugin-reviews/am-lottieplayer?filter=#postform).

== Translations ==

You can [contribute your translation here](https://translate.wordpress.org/projects/wp-plugins/am-lottieplayer).

New to Translating WordPress? Read through the [Translator Handbook](https://make.wordpress.org/polyglots/handbook/tools/glotpress-translate-wordpress-org/) to get started.

== Frequently Asked Questions ==

= What is the structure of the shortcode? =

The shortcode `[am-lottieplayer]` has the following parameters:

- src: `string` (required)
- autoplay: `true` | `false`, default: `false`
- controls: `true` | `false`, default: `false`
- loop: `true` | `false`, default: `false`
- objectfit: `cover` | `contain` | `none`, default: `contain`
- speed: `number` (1 – 5), default: `1`
- intermission: `number` in miliseconds
- direction: `1` | `-1`, default: `1`
- onclick: `true` | `false`, default: `false`
- onmouseover: `true` | `false`, default: `false`
- onmouseout: `void` | `stop` | `pause` | `reverse`, default: `void`

Here's an example: `[am-lottieplayer src="https://storage.googleapis.com/aarsteinmedia/am.lottie" controls="true"]`

== Screenshots ==

1. AM LottiePlayer works with Gutenberg…
2. …as well as Divi Builder…
3. …Elementor…
4. …Flatsome…
5. …and Bricks!

== Changelog ==

= 3.5.16 - Aug 11 2025 =
* Fixed bug causing Bricks builder to crash.

= 3.5.15 - June 21 2025 =
* Fixed bug causing some elements to have wrong placement.
* Fixed bug with toggling boomerang
* Minor optimizations

= 3.5.14 - June 11 2025 =
* Fixed runtime bug where minification caused some functionality to break
* Minor optimizations to animation engine.

= 3.5.11 - June 6 2025 =
* Fixed issue with sanitation of string values, causing trouble for text layers and unencoded expressions.

= 3.5.10 - June 5 2025 =
* Fixed issue with data handling in animation engine.

= 3.5.9 - June 4 2025 =
* Fixed issue with data handling in animation engine.

= 3.5.8 - June 2 2025 =
* Fixed issue with modifiers not being rendered correctly
* Fixed issue with parsing of layers, causing some animations to have mangled transforms

= 3.5.6 - May 14 2025 =
* New animation engine
* Added support for optimized dotLottie files
* Various minor bugfixes

= 3.5.5 - May 9 2025 =
* Rolled back animation engine due to bugs

= 3.5.4 - April 22 2025 =
* Added more style options for Gutenberg block: margin, padding and drop-shadow.
* Enhanced sanitation of uploads

= 3.5.3 - April 21 2025 =
* Fixed issue with sanitation that prevented some valid lottie files from uploading.
* Fixed issue that prevented Lotties from being uploaded via REST API.
* Fixed too early invoking of textdomain.
* Enhanced sanitation of SVG thumbnails.

= 3.5.2 - April 3 2025 =
* Fixed compability issues with older versions of PHP, causing sanitation not to work properly.

= 3.5.1 - March 28 2025 =
* Enhancing of sanitation method
* Changed behavior of mouseover interaction, so that animation resets on new mouseover when animation is complete.

= 3.5.0 - February 22 2025 =
* Added sanitation to upload. Credit to Avraham Shemesh for exposing a security hole.

= 3.4.5 - February 21 2025 =
* Fixed CSS bugs

= 3.4.4 - February 5 2025 =
* ES2021 -> ES2022

= 3.4.3 - January 17 2025 =
* Fixed bug preventing playback on hover in some builders

= 3.4.2 - October 28 2024 =
* Fixed bug with Elementor playback direction

= 3.4.1 - October 27 2024 =
* Fixed bug with front end script in Gutenberg

= 3.4.0 - October 13 2024 =
* Added support for Bricks Builder
* Tested with WordPress 6.7
* Added nonce to thumbnail uploader

= 3.3.10 - October 8 2024 =
* Fixed font-end script not parsing interactions correctly

= 3.3.9 - October 8 2024 =
* Fixed bug in Elementor preventing front-end render

= 3.3.8 - October 8 2024 =
* Fixed bug in Divi visual builder causing autoplay not to work

= 3.3.7 - October 7 2024 =
* Minor bugfix

= 3.3.6 - October 7 2024 =
* Added blueprint.JSON
* Minor changes

= 3.3.5 - October 4 2024 =
* Fixed critical bug

= 3.3.4 - October 4 2024 =
* Added thumbnail previews for Meda Library

= 3.3.1 - October 2 2024 =
* Fixed bug with Flatsome template

= 3.3.0 - October 28 2024 =
* Refactored codebase
* Implemention of namespace to avoid conflict
* Migrated away from rich data to text attributes

= 3.2.5 - October 20 2024 =
* Extended browser support

= 3.2.4 - September 30 2024 =
* Added intermission controls
* Added "Replace"-functionality to Gutenberg editor

= 3.2.3 - September 11 2024 =
* Updated frontend script

= 3.2.2 - September 2 2024 =
* Minor bugfixes

= 3.2.1 - August 28 2024 =
* New feature: Added option to use external urls with Gutenberg

= 3.2.0 - August 6 2024 =
* Updated and lighter animation engine
* Tested with WordPress 6.6

= 3.1.8 - June 21 2024 =
* Bugfix to admin.css, where broad selectors created unwanted behavior

= 3.1.7 - June 13 2024 =
* Bugfix to backend script, fixing unwanted behaviour on blur event

= 3.1.6 - June 6 2024 =
* Bugfix to frontend script

= 3.1.5 - June 4 2024 =
* Bugfix to animation engine

= 3.1.4 - May 15 2024 =
* Minor bugfixes

= 3.1.3 - May 8 2024 =
* Minor bugfixes

= 3.1.2 - May 8 2024 =
* Minor bugfixes

= 3.1.1 - March 31 2024 =
* Minor updates to animation engine

= 3.1.0 - March 20 2024 =
* Functional update to animation engine

= 3.0.7 - March 6 2024 =
* Minor updates to animation engine

= 3.0.6 - Feb 12 2024 =
* Minor updates to animation engine

= 3.0.5 - Jan 15 2024 =
* Performance: More accurate use of Intersection Observer, to freeze/pause all animations out of view

= 3.0.4 - Dec 31 2023 =
* Updated, optimized animation engine

= 3.0.3 - Dec 29 2023 =
* Bugfix: Rollback of animation engine due to faulty script

= 3.0.2 - Dec 29 2023 =
* Bugfix: Fixed bug that caused animation lag in some browsers

= 3.0.1 - Dec 20 2023 =
* Added defer to loading of component scripts

= 3.0.0 - Dec 8 2023 =
* Because we've launched a [PRO version of this plugin](https://www.aarstein.media/en/am-lottieplayer/pro) some features, like boomerang, animation segments, external selector and the option to choose renderer has been removed from the free tier. Certain methods from animations made with After Effects (like loopOut) has also been omitted. The upside is that this plugin is now even more lightweight and less RAM intensive than before. To anyone who still might experiences this as a downgrade: you're free to continue to use [any version of this plugin below 3.0.0](https://wordpress.org/plugins/am-lottieplayer/advanced/). However, if you'd like to support the development of this plugin, the premium version starts at $2.75 a month ($33 a year), and contains several requested features like the ability to combine and control multiple animations in a single file, or convert and optimize JSON to dotLottie. [Read more about AM LottiePlayer PRO here!](https://www.aarstein.media/en/am-lottieplayer/pro)

= 2.5.17 - Nov 23 2023 =
* Bugfix: Fixed compability issue with PHP 7.4

= 2.5.16 - Nov 15 2023 =
* Bugfix: Fixed loading issue for third party builders

= 2.5.15 - Nov 11 2023 =
* Compability with WordPress 6.4

= 2.5.14 - Sep 22 2023 =
* Bugfix: Fixed playback error on Divi Shortcode

= 2.5.13 =
* Bugfix: Fixed total frames display

= 2.5.12 =
* Optimization: Terser script, as well as new functionality available within JS.

= 2.5.11 =
* Bugfix: Fixed seeker on player

= 2.5.10 =
* Bugfix: Fixed uninitialized PHP variable

= 2.5.9 =
* Bugfix: Fixed seeker

= 2.5.8 =
* New Feature: Better error handling
* Bugfix: Fixed link for Divi builder

= 2.5.7 =
* Minor bugfixes

= 2.5.6 =
* New Feature: Added support for Divi Theme Builder

= 2.5.4 =
* New Feature: Added option to play animation only once on scroll

= 2.5.3 =
* Bugfix: Play on scoll functionality wasn't working properly in certain browsers.

= 2.5.2 =
* Minor bugfix.

= 2.5.1 =
* Bugfix: Added polyfill for Buffer, allowing bitmap assets for dotLottie animations.

= 2.5.0 =
* New Feature: Added play on scroll functionality

= 2.4.1 =
* New Feature: Expanded possibility to play segments to Divi Builder

= 2.4 =
* New Feature: Added possibility to play segments, in Gutenberg editor
* Compability: Checked compability with new release of WordPress

= 2.3.3 =
* Bugfix: Fixed issue with shortcode and namings

= 2.3.2 =
* New Feature: Added support for selectors to Elementor, Flatsome, WPBakery and Divi

= 2.3.1 =
* Bugfix: Fixed issue with Boomerang

= 2.3.0 =
* New Feature: Added selector option for interactions
* Bugfix: Fixed issue in Gutenberg where the player lost connection on block move

= 2.2.2 =
* Bugfix: Issue prevented Gutenberg backend from working properly

= 2.2.1 =
* Optimization: Preparatioins for future functionality expansion

= 2.2.0 =
* New Feature: Adding preview of animations in Media Library

= 2.1.5 =
* Optimization: Minor patches

= 2.1.4 =
* New Feature: Added partial support for WPBakery

= 2.1.3 =
* Bugfix: Minor errors in shortcode
* Optimization: More options for screen readers

= 2.1.2 =
* Optimization: Bugfix in frontend script

= 2.1.1 =
* Optimization: Minor patches

= 2.1.0 =
* New Feature: Added support for Flatsome UX Builder

= 2.0.4 =
* Bugfix: An error caused shortcode not to load necessary scripts.

= 2.0.3 =
* Optimization: WCAG compliance

= 2.0.2 =
* Optimization: Less weight – same functionality!

= 2.0.0 =
* New Feature: Added support for Elementor.
* Optimization: Made scripts load dynamically only when used
* Bugfix: Minor bugfixes

= 1.0.3 =
* Optimization: Updates to animation engine. Faster and even more lightweight!

= 1.0.2 =
* Bugfix: typo in dotLottie decompression, causing base64 encryption of bitmap images to break.