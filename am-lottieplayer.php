<?php

/**
 * AM LottiePlayer
 * 
 * @package AM LottiePlayer
 * @author Aarstein Media
 *
 * Plugin Name:       AM LottiePlayer
 * Description:       The most complete Lottie Player plugin! It is lightweight, versatile and easy to use, and it has integrations for Gutenberg, Divi, Elementor, Flatsome and WPBakery.
 * Requires at least: 5.9
 * Requires PHP:      7.0
 * Version:           2.5.14
 * Author:            Aarstein Media
 * Author URI:        https://www.aarstein.media
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       am-lottieplayer
 */

defined('ABSPATH') || exit;

if (!class_exists('AM_LottiePlayer')) {

  class AM_LottiePlayer
  {
    public $version;

    public function __construct()
    {
      $this->version = '2.5.14';
    }

    /**
     * Sets up Am LottiePlayer plugin
     * @return void
     */
    public function initialize()
    {

      // Define constants
      define('AM_LOTTIEPLAYER_PATH', plugin_dir_path(__FILE__));
      define('AM_LOTTIEPLAYER_BASENAME', plugin_basename(__FILE__));
      define('AM_LOTTIEPLAYER_VERSION', $this->version);
      define('AM_LOTTIEPLAYER_URL', plugin_dir_url(__FILE__));
      // define('AM_LOTTIEPLAYER_FILE', __FILE__);

      // Include utility functions
      include_once AM_LOTTIEPLAYER_PATH . 'includes/functions.php';

      am_include('upload.php');
      am_include('builders/index.php');

      add_action('admin_enqueue_scripts', [$this, 'backend_enqeue']);

      register_activation_hook(__FILE__, [$this, 'on_activation']);

      // Check if other instances are active
      add_action('activated_plugin', [$this, 'deactivate_other_instances']);
      add_action('pre_current_active_plugins', [$this, 'plugin_deactivated_notice']);
    }

    /**
     * Initiate download of default asset if missing
     * @return void
     */
    public static function on_activation()
    {
      if (!current_user_can('activate_plugins'))
        return;

      AM_LottiePlayer_Upload::lottie_asset();
    }

    /**
     * Enqueue JavaScript and CSS for backend
     * @return void
     */
    public function backend_enqeue()
    {
      wp_register_style('am-backend-style', null);
      wp_enqueue_style('am-backend-style');
      $style = '
      .attachment-media-view.landscape .thumbnail-text,.attachment-media-view.landscape .thumbnail-application{position:relative;}
      .attachment-media-view.landscape dotlottie-player{position:absolute;height:calc(100% - 42px);width:calc(100% - 42px);}';
      wp_add_inline_style('am-backend-style', $style);

      wp_enqueue_script('dotlottie-player');
    }

    /**
     * Checks if another version of AM LottiePlayer/AM LottiePlayer PRO is active and deactivates it.
     * Hooked on `activated_plugin` so other plugin is deactivated when current plugin is activated.
     *
     * @param string $plugin The plugin being activated.
     * @return void
     */
    public function deactivate_other_instances($plugin)
    {
      if (!in_array($plugin, ['am-lottieplayer/am-lottieplayer.php', 'am-lottieplayer-pro/am-lottieplayer-pro.php'], true)) {
        return;
      }

      $plugin_to_deactivate  = 'am-lottieplayer/am-lottieplayer.php';
      $deactivated_notice_id = '1';

      // If we just activated the free version, deactivate the pro version.
      if ($plugin === $plugin_to_deactivate) {
        $plugin_to_deactivate  = 'am-lottieplayer-pro/am-lottieplayer-pro.php';
        $deactivated_notice_id = '2';
      }

      if (is_multisite() && is_network_admin()) {
        $active_plugins = (array) get_site_option('active_sitewide_plugins', []);
        $active_plugins = array_keys($active_plugins);
      } else {
        $active_plugins = (array) get_option('active_plugins', []);
      }

      foreach ($active_plugins as $plugin_basename) {
        if ($plugin_to_deactivate === $plugin_basename) {
          set_transient('am_deactivated_notice_id', $deactivated_notice_id, 1 * HOUR_IN_SECONDS);
          deactivate_plugins($plugin_basename);
          return;
        }
      }
    }

    /**
     * Displays a notice when either Am LottiePlayer or Am LottiePlayer PRO is automatically deactivated.
     * @return void
     */
    public function plugin_deactivated_notice()
    {
      $deactivated_notice_id = (int) get_transient('am_deactivated_notice_id');
      if (!in_array($deactivated_notice_id, [1, 2], true)) {
        return;
      }

      $message = __('AM LottiePlayer and AM LottiePlayer  PRO should not be active at the same time. We\'ve automatically deactivated AM LottiePlayer.', 'am-lottieplayer');
      if (2 === $deactivated_notice_id) {
        $message = __('AM LottiePlayer and AM LottiePlayer PRO should not be active at the same time. We\'ve automatically deactivated AM LottiePlayer PRO.', 'am-lottieplayer');
      }

?>
      <div class="updated" style="border-left: 4px solid #ffba00;">
        <p><?php echo esc_html($message); ?></p>
      </div>
<?php

      delete_transient('am_deactivated_notice_id');
    }
  }

  /**
   * Main function, to initialize plugin
   * @return AM_LottiePlayer
   */
  function am_lottieplayer()
  {
    global $am_lottieplayer;

    if (!isset($am_lottieplayer)) {
      $am_lottieplayer = new AM_LottiePlayer();
      $am_lottieplayer->initialize();
    }

    return $am_lottieplayer;
  }

  am_lottieplayer();
} // class_exists check end
