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
      add_action('wp_dashboard_setup', [$this, 'register_am_lottieplayer_dashboard_widget']);
      add_action('admin_enqueue_scripts', [$this, 'admin_enqueue_scripts']);
    }

    /**
     * Enqueue JavaScript and CSS for backend
     * @return void
     */
    public function admin_enqueue_scripts($page)
    {
      wp_enqueue_style('am-backend-style', AM_LOTTIEPLAYER_URL . 'styles/admin.css');
      wp_enqueue_script('dotlottie-player-light');

      $widgetAssets = require AM_LOTTIEPLAYER_PATH . 'build/widget.asset.php';

      if ($page === 'index.php') {
        wp_enqueue_script(
          'am-lottieplayer-widget',
          AM_LOTTIEPLAYER_URL . 'build/widget.js',
          $widgetAssets['dependencies'],
          '0.1.0',
          true
        );

        // Add variables to be used inside script
        wp_localize_script(
          'am-lottieplayer-widget',
          'amPhpVars',
          [
            'pluginUrl' => AM_LOTTIEPLAYER_URL,
          ]         
        );
      }
    }

    /**
     * Add dashboard widget
     */
    public function register_am_lottieplayer_dashboard_widget()
    {
      wp_add_dashboard_widget(
        'am_lottieplayer_dashboard_widget',
        'AM LottiePlayer',
        [$this, 'render_am_lottieplayer_dashboard_widget']
      );
    }

    public function render_am_lottieplayer_dashboard_widget() {
      echo '<div id="am-lottieplayer-widget"></div>';
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