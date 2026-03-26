<?php if ( class_exists( 'Woocommerce' ) ) { ?>
	<div class="pxl-cart-sidebar-button pxl-anchor side-panel" data-target=".pxl-side-cart">
		<?php if(!empty($settings['pxl_icon']['value'])) {
            \Elementor\Icons_Manager::render_icon( $settings['pxl_icon'], [ 'aria-hidden' => 'true', 'class' => '' ], 'i' );
	    } else { ?>
	    	<i class="flaticon-shop-bag"></i>
	    <?php } ?>
        <span class="pxl_cart_counter"><?php echo sprintf (_n( '%d', '%d', WC()->cart->cart_contents_count, 'meddox' ), WC()->cart->cart_contents_count ); ?></span>
	</div>
<?php }
add_action( 'pxl_anchor_target', 'meddox_hook_anchor_cart'); ?>