<?php

namespace Paisleyproducts;
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://booskills.com/rao
 * @since      1.0.0
 *
 * @package    Paisleyproducts
 * @subpackage Paisleyproducts/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Paisleyproducts
 * @subpackage Paisleyproducts/public
 * @author     Rao <rao@booskills.com>
 */
class Front {

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
	 * @param string $plugin_name The name of the plugin.
	 * @param string $version The version of this plugin.
	 *
	 * @since    1.0.0
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

		$this->register_custom_fields();

		add_action( 'init', array( $this, 'register_cpt_paisley_products' ) );
		add_action( 'init', array( $this, 'register_taxonomy_product_stores' ) );

	}

	/**
	 *
	 */
	public function register_taxonomy_product_stores() {

		/**
		 * Taxonomy: Product Stores.
		 */

		$labels = [
			"name"          => __( "Product Stores", "astra-child" ),
			"singular_name" => __( "Product Store", "astra-child" ),
		];

		$args = [
			"label"                 => __( "Product Stores", "astra-child" ),
			"labels"                => $labels,
			"public"                => true,
			"publicly_queryable"    => true,
			"hierarchical"          => true,
			"show_ui"               => true,
			"show_in_menu"          => true,
			"show_in_nav_menus"     => true,
			"query_var"             => true,
			"rewrite"               => [ 'slug' => 'product_store', 'with_front' => true, 'hierarchical' => true, ],
			"show_admin_column"     => true,
			"show_in_rest"          => true,
			"rest_base"             => "product_store",
			"rest_controller_class" => "WP_REST_Terms_Controller",
			"show_in_quick_edit"    => false,
		];
		register_taxonomy( "product_store", [ "paisley-products" ], $args );

	}

	/**
	 *
	 */
	public function register_cpt_paisley_products() {


		/**
		 * Post Type: Paisley Products.
		 */

		$labels = [
			"name"          => __( "Paisley Products", "astra-child" ),
			"singular_name" => __( "Paisley Product", "astra-child" ),
			"menu_name"     => __( "Paisley Products", "astra-child" ),
			"all_items"     => __( "Paisley Products", "astra-child" ),
			"add_new"       => __( "Add new Products", "astra-child" ),
		];

		$args = [
			"label"                 => __( "Paisley Products", "astra-child" ),
			"labels"                => $labels,
			"description"           => "",
			"public"                => true,
			"publicly_queryable"    => true,
			"show_ui"               => true,
			"show_in_rest"          => true,
			"rest_base"             => "",
			"rest_controller_class" => "WP_REST_Posts_Controller",
			"has_archive"           => true,
			"show_in_menu"          => true,
			"show_in_nav_menus"     => true,
			"delete_with_user"      => true,
			"exclude_from_search"   => true,
			"capability_type"       => "post",
			"map_meta_cap"          => true,
			"hierarchical"          => true,
			"rewrite"               => [ "slug" => "paisley-products", "with_front" => true ],
			"query_var"             => true,
			"menu_icon"             => "dashicons-food",
			"supports"              => [ "title", "editor", "thumbnail" ],
		];

		register_post_type( "paisley-products", $args );

	}


	/**
	 *
	 */
	public function register_custom_fields() {

		if ( function_exists( 'acf_add_local_field_group' ) ):

			acf_add_local_field_group( array(
				'key'                   => 'group_5fb4665410840',
				'title'                 => 'Paisley products fields',
				'fields'                => array(
					array(
						'key'               => 'field_5fb466816a0bf',
						'label'             => 'price',
						'name'              => 'price',
						'type'              => 'number',
						'instructions'      => '',
						'required'          => 1,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'default_value'     => '',
						'placeholder'       => '',
						'prepend'           => '$',
						'append'            => '',
						'min'               => '',
						'max'               => '',
						'step'              => '',
					),
					array(
						'key'               => 'field_5fb466bd6a0c0',
						'label'             => 'Add to Cart Url',
						'name'              => 'add_to_cart',
						'type'              => 'url',
						'instructions'      => '',
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'default_value'     => '',
						'placeholder'       => '',
					),
				),
				'location'              => array(
					array(
						array(
							'param'    => 'post_type',
							'operator' => '==',
							'value'    => 'paisley-products',
						),
					),
				),
				'menu_order'            => 0,
				'position'              => 'normal',
				'style'                 => 'default',
				'label_placement'       => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen'        => '',
				'active'                => true,
				'description'           => '',
			) );

			acf_add_local_field_group( array(
				'key'                   => 'group_5fb4518cc8229',
				'title'                 => 'Recipes related product',
				'fields'                => array(
					array(
						'key'               => 'field_5fb451d0dbc23',
						'label'             => 'Recipes related product',
						'name'              => 'recipes_related_product',
						'type'              => 'relationship',
						'instructions'      => '',
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'post_type'         => array(
							0 => 'paisley-products',
						),
						'taxonomy'          => '',
						'filters'           => array(
							0 => 'search',
							1 => 'post_type',
							2 => 'taxonomy',
						),
						'elements'          => array(
							0 => 'featured_image',
						),
						'min'               => '',
						'max'               => '',
						'return_format'     => 'object',
					),
				),
				'location'              => array(
					array(
						array(
							'param'    => 'post_type',
							'operator' => '==',
							'value'    => 'boo_recipe',
						),
					),
				),
				'menu_order'            => 0,
				'position'              => 'normal',
				'style'                 => 'default',
				'label_placement'       => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen'        => '',
				'active'                => true,
				'description'           => '',
			) );

			acf_add_local_field_group( array(
				'key'                   => 'group_5fb5dd82c8442',
				'title'                 => 'Store Image',
				'fields'                => array(
					array(
						'key'               => 'field_5fb5dd9c36c5d',
						'label'             => 'Store Image',
						'name'              => 'storeimage',
						'type'              => 'image',
						'instructions'      => '',
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'return_format'     => 'url',
						'preview_size'      => 'medium',
						'library'           => 'all',
						'min_width'         => '',
						'min_height'        => '',
						'min_size'          => '',
						'max_width'         => '',
						'max_height'        => '',
						'max_size'          => '',
						'mime_types'        => '',
					),
				),
				'location'              => array(
					array(
						array(
							'param'    => 'taxonomy',
							'operator' => '==',
							'value'    => 'product_store',
						),
					),
				),
				'menu_order'            => 0,
				'position'              => 'normal',
				'style'                 => 'default',
				'label_placement'       => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen'        => '',
				'active'                => true,
				'description'           => '',
			) );

		endif;


	}

//	/**
//	 * Register the stylesheets for the public-facing side of the site.
//	 *
//	 * @since    1.0.0
//	 */
//	public function enqueue_styles() {
//
//		/**
//		 * This function is provided for demonstration purposes only.
//		 *
//		 * An instance of this class should be passed to the run() function
//		 * defined in Paisleyproducts\Loader as all of the hooks are defined
//		 * in that particular class.
//		 *
//		 * The Paisleyproducts\Loader will then create the relationship
//		 * between the defined hooks and the functions defined in this
//		 * class.
//		 */
//
//		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/public.css', array(), $this->version, 'all' );
//
//	}
//
//	/**
//	 * Register the JavaScript for the public-facing side of the site.
//	 *
//	 * @since    1.0.0
//	 */
//	public function enqueue_scripts() {
//
//		/**
//		 * This function is provided for demonstration purposes only.
//		 *
//		 * An instance of this class should be passed to the run() function
//		 * defined in Paisleyproducts\Loader as all of the hooks are defined
//		 * in that particular class.
//		 *
//		 * The Paisleyproducts\Loader will then create the relationship
//		 * between the defined hooks and the functions defined in this
//		 * class.
//		 */
//
//		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/public.js', array( 'jquery' ), $this->version, false );
//
//	}

}
