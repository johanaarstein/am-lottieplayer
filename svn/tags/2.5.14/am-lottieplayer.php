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
    public $slug;
    public $version;

    public function __construct()
    {
      $this->slug = plugin_basename(__DIR__);
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

      // Include utility functions
      include_once AM_LOTTIEPLAYER_PATH . 'includes/functions.php';

      // Include Upload functionality
      am_include('includes/upload.php');

      // Add actions
      add_action('init', [$this, 'blocks_init']);
      add_action('admin_enqueue_scripts', [$this, 'backend_enqeue']);
      add_action('wp_enqueue_scripts', [$this, 'frontend_enqueue']);

      // Builder initializations
      add_action('divi_extensions_init', [$this, 'init_divi']);
      add_action('elementor/widgets/register', [$this, 'init_elementor']);
      add_action('after_setup_theme', [$this, 'init_flatsome']);
      add_action('vc_before_init', [$this, 'init_vc']);

      // Check if other instances are active
      add_action('activated_plugin', array($this, 'deactivate_other_instances'));
      add_action('pre_current_active_plugins', array($this, 'plugin_deactivated_notice'));
    }

    /**
     * Initialize Gutenberg Blocks and register JavaScript
     * @return void
     */
    public function blocks_init()
    {
      add_shortcode('am-lottieplayer', 'am_render_lottieplayer_shortcode');

      register_block_type(AM_LOTTIEPLAYER_PATH . 'build/lottieplayer');
      register_block_type(AM_LOTTIEPLAYER_PATH . 'build/lottiecover');

      wp_register_script(
        'dotlottie-player',
        AM_LOTTIEPLAYER_URL . 'scripts/dotlottie-player.min.js',
        null,
        '2.0.3',
        true
      );

      wp_register_script(
        'am-backend-ux',
        AM_LOTTIEPLAYER_URL . 'scripts/am-backend-ux.min.js',
        ['dotlottie-player'],
        '1.0.0',
        true
      );

      wp_register_script(
        'am-frontend',
        AM_LOTTIEPLAYER_URL . 'scripts/am-frontend.min.js',
        ['dotlottie-player'],
        '1.2.1',
        true
      );

      register_activation_hook(
        __FILE__,
        'am_lottie_asset'
      );
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
     * Enqueue JavaScript for frontend
     * @return void 
     */
    public function frontend_enqueue()
    {
      global $post;
      $content = '';

      $diviFlag = false;

      //Check if any front-end builders are active
      $isDiviBuilder = isset($_GET['et_fb']) && !empty($_GET['et_fb']);
      $isVCBuilder = function_exists('vc_is_inline') && vc_is_inline();

      if (is_a($post, 'WP_Post')) {
        $content = $post->post_content;
      }

      // Check for Lottie in Divi Templates
      if (function_exists('et_theme_builder_get_template_layouts')) {
        $layouts = et_theme_builder_get_template_layouts();
        if (!empty($layouts)) {
          if ($layouts['et_header_layout']['override']) {
            $header = get_post($layouts['et_header_layout']['id'])->post_content;
            if (has_shortcode($header, 'et_pb_lottieplayer')) {
              $diviFlag = true;
            }
          }
          if (!$diviFlag && $layouts['et_body_layout']['override']) {
            $body = get_post($layouts['et_body_layout']['id'])->post_content;
            if (has_shortcode($body, 'et_pb_lottieplayer')) {
              $diviFlag = true;
            }
          }
          if (!$diviFlag && $layouts['et_footer_layout']['override']) {
            $footer = get_post($layouts['et_footer_layout']['id'])->post_content;
            if (has_shortcode($footer, 'et_pb_lottieplayer')) {
              $diviFlag = true;
            }
          }
        }
      }

      if (!is_admin()) {
        if (
          //Check if post has Gutenberg blocks
          has_block('gb/lottieplayer') ||
          has_block('gb/lottiecover') ||
          (
            (
              //Check if post has general shortcode, and VC frontend builder is not active
              has_shortcode($content, 'am-lottieplayer') &&
              !$isVCBuilder
            ) ||
            (
              //Check if post has Divi shortcode, and Divi Builder is not active
              ($diviFlag || has_shortcode($content, 'et_pb_lottieplayer')) &&
              !$isDiviBuilder
            )
          )
        ) {
          wp_enqueue_script('am-frontend');
        }
        //Add scripts for Divi/VC front-end builder, if either are installed and active
        if ($isDiviBuilder || $isVCBuilder) {
          wp_enqueue_script('dotlottie-player');
        }
      }
    }

    /**
     * Initialize DIVI Extension
     * @return void
     */
    public function init_divi()
    {
      am_include('includes/LottieDiviModules.php');
    }

    /**
     * Initialize Elementor Widget
     * @return void
     */
    public function init_elementor($widgets_manager)
    {
      wp_enqueue_style(
        'elementor-backend-style',
        AM_LOTTIEPLAYER_URL . 'styles/am-font.css'
      );
      am_include('includes/widgets/elementor-am-lottieplayer.php', $widgets_manager);
    }

    /**
     * Initialize Flatsome Shortcode
     * @return void
     */
    public function init_flatsome()
    {
      if (!function_exists('add_ux_builder_shortcode'))
        return;
      am_include('includes/flatsome/ux-am-lottieplayer.php');
    }

    /**
     * Initialize Visual Composer
     * @return void 
     */
    public function init_vc()
    {
      am_include('includes/vc/vc-am-lottieplayer.php');
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
