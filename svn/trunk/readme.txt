=== AM LottiePlayer – Vector animations for WordPress ===
Contributors: johanaarstein
Donate link: https://www.paypal.com/donate/?hosted_button_id=E7C7DMN8KSQ6A
Author URI: https://www.aarstein.media
Plugin URI: https://wordpress.org/plugins/am-lottieplayer/
Tags: lottie, dotlottie, bodymovin, gutenberg, elementor, divi, flatsome, animation, vector, svg, gif
Requires at least: 5.9
Tested up to: 6.3
Requires PHP: 7.0
Stable Tag: 1.0.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

The most complete Lottie Player plugin! It is lightweight, versatile and easy to use, and it works with Gutenberg, Divi, Elementor and Flatsome.

== Description ==

**The most complete Lottie Player yet.**

AM LottiePlayer is easy to use, lightweight, and gives you total control over how to implement crisp, vectorized animations to your website. Easily set up user interactions, choose between JSON or the optimized dotLottie format, choose whether to serve the files from a CDN or your own *Media Library*, choose whether to render the animations as malleable SVGs or performant Canvases, choose how to scale the animation, add a nice description for screen readers and search eninge crawlers, and you're off to the races!

Upload Lottie animations to WordPress and add them to Gutenberg, Divi, Elementor, Flatsome UX Builder, or via the shortcode `[am-lottieplayer]`. This plugin also offer partial support for WPBakery (formerly Visual Studio).

= Features =

- Contains two Gutenberg blocks: a player and a cover block with text overlay – great for headers.
- Contains a Divi Builder Module
- Contains an Elementor Widget
- Contains the shortcode `[am-lottieplayer]`
- Has intergration for Flatsome UX Builder
- Has partial support for WPBakery (formerly Visual Studio)
- Scripts are only loaded for pages where the player is used
- Upload Lottie JSON or dotLottie files to your *Media Library*
- Drag & drop a Lottie JSON or dotLottie file
- Insert a Lottie JSON or dotLottie animation from URL
- Choose renderer, scaling, speed, size, background color, interactions and more from the block settings in Gutenberg. The same settings are accessible in the Divi Module menu, the Elementor Widget menu, the Flatsome UX Builder menu, and WPBakery menu.

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
- renderer: `svg` | `canvas` | `html`, default: `svg`
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
- direction: `1` | `-1`, default: `1`
- renderer: `svg` | `canvas` | `html`, default: `svg`
- onclick: `true` | `false`, default: `false`
- onmouseover: `true` | `false`, default: `false`
- onmouseout: `void` | `stop` | `pause` | `reverse`, default: `void`

Here's an example: `[am-lottieplayer src="https://storage.googleapis.com/aarsteinmedia/am.lottie" controls="true" ]`

== Screenshots ==

1. AM LottiePlayer works with Gutenberg…
2. …as well as Divi Builder…
3. …Elementor…
4. …and even Flatsome!

== Changelog ==

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