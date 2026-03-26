<?php
              
// Related Products
if(meddox()->get_theme_opt('product_related', '1') === '0' ){
	remove_action('woocommerce_after_single_product_summary','woocommerce_output_related_products', 20);
}
 


 