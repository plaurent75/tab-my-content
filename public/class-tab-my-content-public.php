<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.patricelaurent.net/
 * @since      1.0.0
 *
 * @package    Tab_My_Content
 * @subpackage Tab_My_Content/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version
 *
 * @package    Tab_My_Content
 * @subpackage Tab_My_Content/public
 * @author     Patrice LAURENT
 */
class Tab_My_Content_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		global $post;
		if( (is_singular() && count(have_tabmc($post->ID)) > 0) || has_shortcode( $post->post_content, 'tabmc_by_ids' ) )
		{
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/tab-my-content-public.css', array(), $this->version, 'all' );
		}

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		global $post;
		if( (is_singular() && count(have_tabmc($post->ID)) > 0) || has_shortcode( $post->post_content, 'tabmc_by_ids' ) ) {
			wp_enqueue_script( 'jquery-ui-core' );
			wp_enqueue_script( 'jquery-ui-tabs', array( 'jquery' ) );
			wp_enqueue_script( $this->plugin_name,
				plugin_dir_url( __FILE__ ) . 'js/tab-my-content-public.js',
				array( 'jquery', 'jquery-ui-tabs' ),
				$this->version,
				false );
		}

	}

	/**
	 * Template for tabs
	 *
	 * @param $content
	 *
	 * @return mixed
	 */
	public function add_tab($content){

		//Check if this post has Tab
		if(is_singular() && count(have_tabmc(get_the_ID())) > 0){
			include_once 'partials/tab-my-content-public-display.php';
		}else{
			return $content;
		}

	}

	/**
	 * Display tabs with shortcode
	 *
	 * @param $atts
	 * @param null $content
	 *
	 * @return null
	 */
	public function shortcode_tabs($atts, $content = null){
		$a = shortcode_atts( array(
			'ids' => false,
		), $atts );
		if(!empty($a) && false !== $a['ids']) {
			$ids = explode( ',', $a['ids'] );
			if(!empty($ids)){
				$tabs = array();
				$tabs_content = array();
				foreach ($ids as $id){
					$tab_id = trim($id);
					if( is_numeric($tab_id) && $tab_id > 0){
						$tabs[$tab_id] = get_the_title($tab_id);
						$tabs_content[$tab_id] = get_post_field('post_content', $tab_id);
					}
				}
				include_once 'partials/tab-my-content-shortcode-tabs.php';
			}
		}
		// always return
		return $content;
	}

	/**
	 * everything that should be loaded with the init action
	 */
	public function init_hook(){
		add_shortcode('tabmc_by_ids', array($this, 'shortcode_tabs') );
	}

}
