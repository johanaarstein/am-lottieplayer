<?php

defined('ABSPATH') || exit;

if (!class_exists('AM_LottiePlayer_Admin')) {

  class AM_LottiePlayer_Admin
  {

    /**
     * Constructor
     *
     * @param void
     * @return void
     */
    public function __construct()
    {
      add_action('admin_menu', [$this, 'admin_menu']);
      add_action('admin_enqueue_scripts', [$this, 'admin_enqueue_scripts']);
    }

    /**
     * Add menu item
     */
    public function admin_menu()
    {
      add_menu_page(
        __('AM LottiePlayer Settings', 'am-lottieplayer'),
        'AM LottiePlayer',
        'manage_options',
        AM_LOTTIEPLAYER_SLUG,
        [$this, 'render_settings'],
        'data:image/svg+xml;base64,' . base64_encode('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 80 80" fill="black"><path fill="#a7aaad" d="M60 0H20C9 0 0 9 0 20v39.5C0 71 9 80 20 80h39.5c11 0 20.5-9 20.5-20V20C80 9 71 0 60 0zm4.9 59.7h-7.4V37.1c0-3.2.3-8.2.3-8.2h-.1s-.9 4.7-1.7 7.5l-6.8 23.3h-4l-11-30.2c-.8-2.2-2-5.8-2-5.8h-.1s-1.1 3.4-1.9 5.8L18.7 59.7H15l15-39.4h4.2l11.4 30c.3-1.4 1.2-6.1 2.4-10.2l5.6-19.8H65v39.4z"/></svg>'),
        80
      );
    }

    /**
     * Enqueue JavaScript and CSS for backend
     * @return void
     */
    public function admin_enqueue_scripts($page)
    {
      wp_enqueue_style('am-backend-style', AM_LOTTIEPLAYER_URL . 'styles/admin.css');
      wp_enqueue_script('dotlottie-player-light');
      $assets = require AM_LOTTIEPLAYER_PATH . 'build/settings.asset.php';
      if ($page === 'toplevel_page_am-lottieplayer') {
        wp_enqueue_media();
        wp_enqueue_script(
          'am-lottieplayer-options',
          AM_LOTTIEPLAYER_URL . 'build/settings.js',
          $assets['dependencies'],
          '0.1.0',
          true
        );

        // Add variables to be used inside script
        wp_localize_script(
          'am-lottieplayer-options',
          'amPhpVars',
          [
            'pluginUrl' => AM_LOTTIEPLAYER_URL,
            'endpoint' => esc_url_raw(rest_url('/wp/v2/media/')),
            'nonce' => wp_create_nonce('wp_rest'),
          ]         
        );
      }
    }

    public function render_settings()
    {
      if (!current_user_can('manage_options')) {
        wp_die(esc_html__('You do not have sufficient capabilities to access this page.', 'am-lottieplayer'));
      } ?>
      <div id="am-lottieplayer-settings"></div>
      <?php
      // am_get_view('settings');
    }

  }

} // class_exists check end

/**
 * Main function, to initialize class
 * @return AM_LottiePlayer_Admin
 */
(function () {
  global $am_lottieplayer_admin;

  if (!isset($am_lottieplayer_admin)) {
    $am_lottieplayer_admin = new AM_LottiePlayer_Admin();
  }

  return $am_lottieplayer_admin;
})();