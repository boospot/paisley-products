<?php

namespace Paisleyproducts;
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// if class already defined, bail out
if ( class_exists( 'Paisleyproducts\Shortcode' ) ) {
	return;
}


/**
 * This class will create meta boxes for Shortcode
 *
 * @package    Paisleyproducts
 * @subpackage Paisleyproducts/includes
 * @author     Rao <raoabid491@gmail.com>
 */
class Shortcode {


	/**
	 * Initialize the class and set its properties.
	 *
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		add_action( 'wp_head', array( $this, 'load_shortcode_css' ) );
		add_shortcode( 'paisley_products', array( $this, 'display_paisley_products' ) );

	}


	/**
	 * Load CSS relaterd to shortcodes
	 */
	public function load_shortcode_css() {

		if ( 'boo_recipe' !== get_post_type( get_the_ID() ) ) {
			return null;
		}

		?>
        <style>
            .shortcode-recipe {
                display: grid;
                grid-template-columns: 1fr 2fr;
                grid-gap: 10px;
                margin-bottom: 20px !important;
                border-bottom: 1px solid #bbbbbb;
                padding: 10px 0;
            }

            .shortcode-list {
                margin-top: 10px !important;
            }

            .shortcode-image {
            }

            .shortcode-content p {
                margin-bottom: 5px;
            }

            .shortcode-content h3 {
                font-size: 1em;
            }
        </style>

		<?php


	}

	/**
	 * display_paisley_products
	 */
	public function display_paisley_products( $atts ) {
		if( ! function_exists('get_field') ){
			return null;
		}

		$posts = get_field( 'recipes_related_product' );
		//short code array
		$atts = shortcode_atts(
			array(
				'heading'           => 'Recipes',
				'button'            => 'Add To cart',
				'available_heading' => 'Available at:',
			),
			$atts
		);

		$buttonName        = esc_attr( $atts['button'] );
		$available_heading = esc_attr( $atts['available_heading'] );

		ob_start();

		if ( $posts ):
			?>
            <ul class="shortcode-list">
				<?php
				foreach ( $posts as $post ):
					// Setup this post for WP functions (variable must be named $post).
					setup_postdata( $post );
					$add_to_cart_url = get_post_meta( $post->ID, 'add_to_cart', true );

					?>
                    <li class="shortcode-recipe">
                        <div class="shortcode-image">
							<?php
							if ( ! empty( $add_to_cart_url ) ) {
								printf( '<a href="%s" target="_blank"><img src="%s"/></a>',
									esc_url_raw( $add_to_cart_url ),
									get_the_post_thumbnail_url( $post->ID, 'full' )
								);
							} else {
								printf( '<img src="%s"/>',
									get_the_post_thumbnail_url( $post->ID, 'full' )
								);
							}
							?>
                        </div>
                        <div class="shortcode-content">
							<?php
							if ( ! empty( $add_to_cart_url ) ) {
								printf( '<a href="%s" target="_blank"><h3>%s</h3></a>',
									esc_url_raw( $add_to_cart_url ),
									get_the_title( $post->ID )
								);
							} else {
								printf( '<h3>%s</h3>',
									get_the_title( $post->ID )
								);
							}

							$price = get_post_meta( $post->ID, 'price', true );
							if ( ! empty( $price ) ) {
								printf( '<p>Price: $ %s</p>', $price );
							}
							if ( ! empty( $add_to_cart_url ) ) {
								printf(
									'<a href="%s" target="_blank" class="elementor-button-link elementor-button elementor-size-md">%s</a>',
									$add_to_cart_url,
									$buttonName
								);
							}

							$product_store_terms = wp_get_post_terms( $post->ID, [ 'product_store' ] );

							if ( ! empty( $product_store_terms ) ):
								printf( '<div class="available-heading">%s</div>', $available_heading );
								foreach ( $product_store_terms as $term_obj ) :
									$term_img = get_term_meta( $term_obj->term_id, 'storeimage', true );
									if ( $term_img ) {
										echo wp_get_attachment_image( $term_img, 'medium_large' );
									}
								endforeach;
							endif;
							?>

                        </div>
                    </li>
				<?php endforeach;

				?>
            </ul>

			<?php

			// Reset the global post object so that the rest of the page works correctly.
			wp_reset_postdata(); ?>
		<?php endif; ?>


		<?php
		return ob_get_clean();

	}


}
