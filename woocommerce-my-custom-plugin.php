<?php
/**
 * Plugin Name: My custom plugin
 * Plugin URI: http://www.demo.url
 * Description: Hide add to cart and deactivate details link for out of stock woocommerce products.
 * Author:  Sohel Rana.
 * Author URI: http://www.demo.url
 * Version: 1.0
 */
if ( ! class_exists( 'WC_my_custom_plugin' ) ) :
    class WC_my_custom_plugin {
        /**
         * Construct the plugin.
         * @param $__FILE__
         */
        public function __construct($__FILE__) {
            add_action( 'plugins_loaded', array( $this, 'init' ) );
        }
        /**
         * Initialize the plugin.
         */
        public function init() {
            // Checks if WooCommerce is installed.
            if ( class_exists( 'WC_Integration' ) ) {
                if (!function_exists('woocommerce_template_loop_add_to_cart')) {
                    function woocommerce_template_loop_add_to_cart() {
                        global $product;
                        if ( ! $product->is_in_stock() || ! $product->is_purchasable() ) return;
                        wc_get_template('loop/add-to-cart.php', ['class'=>'add-to-cart-mt']);
                    }
                }


                if ( ! function_exists( 'woocommerce_template_loop_product_link_open' ) ) {
                    function woocommerce_template_loop_product_link_open()
                    {
                        global $product;

                        if ( ! $product->is_in_stock() || ! $product->is_purchasable() ){
                            echo '<div class="item-title"><a class="woocommerce-LoopProduct-link woocommerce-loop-product__link" title="'.get_the_title().'" >';
                        }else{
                            $link = apply_filters('woocommerce_loop_product_link', get_the_permalink(), $product);

                            echo '<div class="item-title"><a href="' . esc_url($link) . '" class="woocommerce-LoopProduct-link woocommerce-loop-product__link" title="'.get_the_title().'" >';
                        }


                    }
                }
            }


        }

    }
    $WC_my_custom_plugin = new WC_my_custom_plugin( __FILE__ );
endif;
