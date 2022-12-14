=== AM LottiePlayer – Vector animations for WordPress ===
Author URI: https://www.aarstein.media
Plugin URI: https://wordpress.org/plugins/am-lottieplayer/
Tags: lottie, dotlottie, bodymovin, gutenberg, animation, animations, vector, divi, svg, gif
Requires at least: 5.9
Tested up to: 6.1.1
Requires PHP: 7.0
Stable Tag: 1.0.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

The most complete Lottie Player yet. Lightweight, easy to use, accepts LottieJSON and dotLottie, and works with Gutenberg, Divi Builder and Elementor.

== Description ==

**The most complete Lottie Player yet.**

AM LottiePlayer is easy to use, lightweight, and gives you total control over how to implement crisp, vectorized animations to your website. Easily set up user interactions, choose between JSON or the optimized dotLottie format, choose whether to serve the files from a CDN or your own **Media Library**, choose whether to render the animations as malleable SVGs or performant Canvases, and choose how to scale the animation.

Upload Lottie animations to WordPress and add them to Gutenberg, Divi, Elementor or via shortcode [am-lottieplayer]. Choose between user interactions, renderers, aspect ratio and more.

= Features =

- Contains two Gutenberg blocks: a player and a cover block with text overlay – great for headers.
- Contains a Divi Builder Module
- Contains an Elementor Widget
- Upload Lottie JSON or dotLottie files to your **Media Library**
- Drag & drop a Lottie JSON or dotLottie file
- Insert a Lottie JSON or dotLottie animation from URL
- Choose renderer, scaling, speed, size, background color and more from the block settings in Gutenberg. The same settings are accessible in the Divi Module menu. Alternatively you can use the shortcode [am-lottieplayer].

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

1. Go to the WordPress Block Editor / Elementor / Divi Builder
2. Add new block / widget / module
3. Search For **Lottie**
4. Click on the **Lottie** to add the block

If you wish to use the shortcode [am-lottieplayer], it has the following parameters:

- src: string (required)
- autoplay: true | false
- controls: true | false
- loop: true | false
- objectFit: cover | contain | none

== Screenshots ==

1. AM LottiePlayer works with Gutenberg…
2. …as well as Divi Builder…
3. …and even Elementor!

== Changelog ==

= 2.0.0 =
* New Feature: Added support for Elementor.
* Optimization: Made scripts load dynamically only when used
* Bugfix: Minor bugfixes

= 1.0.3 =
* Optimization: Updates to animation engine. Faster and even more lightweight!

= 1.0.2 =
* Bugfix: typo in dotLottie decompression, causing base64 encryption of bitmap images to break.