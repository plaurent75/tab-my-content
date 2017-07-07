<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.patricelaurent.net/
 * @since      1.0.0
 *
 * @package    Tab_My_Content
 * @subpackage Tab_My_Content/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version
 *
 * @package    Tab_My_Content
 * @subpackage Tab_My_Content/admin
 * @author     Patrice LAURENT
 */
class Tab_My_Content_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 *
	 * @param      string $plugin_name The name of this plugin.
	 * @param      string $version The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name,
			plugin_dir_url( __FILE__ ) . 'css/tab-my-content-admin.css',
			array(),
			$this->version,
			'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script('jquery-ui-autocomplete', '', array('jquery-ui-widget', 'jquery-ui-position'));
		wp_enqueue_script( 'jquery-ui-sortable' );
		wp_register_script(  $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/tab-my-content-admin.js', array( 'jquery', 'jquery-ui-autocomplete', 'jquery-ui-sortable'),$this->version,
			false   );
		wp_localize_script( $this->plugin_name, 'TabMCAutocomplete', array(
			'url' => admin_url( 'admin-ajax.php' ) ,
			'edit_post_url' => admin_url( 'post.php?action=edit' ) ,
		) );
		wp_enqueue_script( 'tabmc-autocomplete' );

		wp_enqueue_script( $this->plugin_name);

	}

	/**
	 * Register post type
	 */
	public function post_tab_content() {

		$labels = array(
			'name'                  => _x( 'Tabs Content', 'Post Type General Name', 'tab-my-content' ),
			'singular_name'         => _x( 'Tab Content', 'Post Type Singular Name', 'tab-my-content' ),
			'menu_name'             => __( 'Tab Content', 'tab-my-content' ),
			'name_admin_bar'        => __( 'Tab Content', 'tab-my-content' ),
			'add_new_item'          => __( 'Add New Tab', 'tab-my-content' ),
			'all_items'             => __( 'All Tabs', 'tab-my-content' ),
			'edit_item'             => __( 'Edit Tab', 'tab-my-content' ),
		);
		$args = array(
			'label'                 => __( 'Tab Content', 'tab-my-content' ),
			'description'           => __( 'Add tab to your content', 'tab-my-content' ),
			'labels'                => $labels,
			'supports'              => array( 'title', 'editor', 'author', 'custom-fields', 'page-attributes', ),
			'hierarchical'          => true,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 5,
			'menu_icon'             => 'dashicons-feedback',
			'show_in_admin_bar'     => false,
			'show_in_nav_menus'     => false,
			'can_export'            => true,
			'has_archive'           => false,
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'capability_type'       => 'post',
			'show_in_rest'          => false,
		);
		register_post_type( 'tab_my_content', $args );

	}

	/**
	 * Add meta box post selector for tab_my_content
	 */
	public function add_post_selector(){
		add_meta_box(
			'tab_post_parent',
			__('Post Parent', 'tab-my-content'),
			array($this,'add_post_selector_callback'),
			'tab_my_content',
		'side',
		'high',
		null
		);
	}

	/**
	 * post selector callback
	 */
	public function add_post_selector_callback(){
		$tabmc_parent_post_id = (array_key_exists('tabmc_parent_post_id', $_GET) && isset($_GET['tabmc_parent_post_id'])) ? absint($_GET['tabmc_parent_post_id']) : null;
		$current_post_id = get_the_ID();
		if(is_tabmc_of($current_post_id)){
			$tabmc_parent_post_id = is_tabmc_of($current_post_id);
		}

		$label = isset($tabmc_parent_post_id) ? esc_html(get_the_title($tabmc_parent_post_id)) : '';
		$parent_post_id = isset($tabmc_parent_post_id) ? $tabmc_parent_post_id : '';
		?>
		<div class="tabmc_metabox">
		<input type="text" name="q" id="tab_post_parent_selector" class="ui-autocomplete-input" value="<?php echo $label ?>" />
		<?php if($tabmc_parent_post_id) { ?>
		<a id="tab_post_parent_link_delete" href="#"><span class="dashicons dashicons-no"></span></a>
		<hr />
			<a id="tab_post_parent_link" target="_blank" href="<?php echo get_permalink($tabmc_parent_post_id) ?>"><span class="dashicons dashicons-welcome-view-site"></span></a>
			<a id="tab_post_parent_edit_link" href="<?php echo admin_url('post.php?post='.$tabmc_parent_post_id.'&action=edit') ?>"><span class="dashicons dashicons-edit"></span></a>
		<?php } ?>
		<input type="hidden" name="tabmc_parent_post_id" id="tabmc_parent_post_id" value="<?php echo $parent_post_id ?>" />
		</div>
		<?php
	}

	/**
	 * Ajax action for post selector
	 */
	public function tabmc_lookup(){
		global $wpdb;
		$search_term = sanitize_text_field($_REQUEST['term']);

		$posts = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_title LIKE '%s' AND post_status='publish' AND post_type !='tab_my_content'", '%'. $wpdb->esc_like( $search_term ) .'%' ));
		$suggestions=array();
		foreach ($posts as $parent_posts_list):
			$suggestion = array();
			$suggestion['label'] = esc_html($parent_posts_list->post_title);
			$suggestion['link'] = get_permalink($parent_posts_list->ID);
			$suggestion['post_id'] = $parent_posts_list->ID;
			$suggestions[]= $suggestion;
		endforeach;
		wp_reset_query();
		echo $_GET["callback"] . "(" . json_encode($suggestions) . ")";
		exit;
	}


	/**
	 * Add meta Box for post that display current tab linked to this article
	 */

	public function meta_box_list_tab(){
		add_meta_box(
			'list_tab_post',
			__('Tab My Content', 'tab-my-content'),
			array($this,'meta_box_list_tab_callback'),
			null,
			'side',
			'high',
			null
		);
	}

	/**
	 * meta box list callback
	 */
	public function meta_box_list_tab_callback(){
		$current_post_id = get_the_ID();
		$tabMC = array();
		echo '<div class="tabmc_metabox">';
		if( count(have_tabmc($current_post_id)) > 0 ){
			$tabMC = have_tabmc($current_post_id);
			$_tabmc_title_first_tab = get_post_meta($current_post_id, '_tabmc_title_first_tab',true);
			$titleFirstTab = !empty($_tabmc_title_first_tab) ? $_tabmc_title_first_tab : __('Presentation', 'tab-my-content');
			?>
			<p class="post-attributes-label-wrapper"><label class="post-attributes-label" for="_tabmc_title_first_tab"><?php _e('Title for the First Tab', 'tab-my-content') ?></label></p>
			<input type="text" name="tabmc_title_first_tab" id="tabmc_title_first_tab" value="<?php echo $titleFirstTab ?>" />
			<hr />
			<?php
            include_once 'partials/sortable.php';
		}else {
			?>
			<hr/>
			<?php
			_e( 'No Tabs currently linked to it', 'tab-my-content' );
		}?><hr />
			<a href="<?php echo admin_url('post-new.php?post_type=tab_my_content&tabmc_parent_post_id='.$current_post_id) ?>" class="button button-primary button-large alignright">
				<?php _e('Add another tab now ?', 'tab-my-content'); ?>
			</a>
		<div class="clear"></div>
			<?php
		echo '</div>';
	}

	/**
	 * global add_meta_box
	 */

	public function add_meta_box($post_type){
		$this->add_post_selector();
		if ( $post_type != 'tab_my_content' ) $this->meta_box_list_tab();
	}

	/**
	 * Save post meta for tab_my_content
	 */

	public function save_post($post_id){
		global $wpdb;
		// Post Parent for the tab
		if(array_key_exists('tabmc_parent_post_id', $_POST)){
			$wpdb->update(
				$wpdb->posts,
				array(
					'post_parent' => absint($_POST['tabmc_parent_post_id'])	// integer (number)
				),
				array( 'ID' => $post_id ),
				array(
					'%d'
				),
				array( '%d' )
			);
		}
		//Title for the default first tab
		if(array_key_exists('tabmc_title_first_tab', $_POST)){
			update_post_meta($post_id, '_tabmc_title_first_tab', sanitize_text_field($_POST['tabmc_title_first_tab']));
		}
	}

	/**
     * Notice
     */
    public function add_notices(){
	    $screen = get_current_screen();
	    if ( $screen->post_type == 'tab_my_content' ) include_once 'partials/admin-header.php';
    }

    public function tabmc_order_callback(){
	    $order = explode(",",$_POST['order']);
	    foreach ($order as $o){
	        $dataOrder = explode(':',$o);
		    wp_update_post( array('ID' => $dataOrder[0], 'menu_order' => $dataOrder[1] ) );
        }
	    wp_die();
    }
}
