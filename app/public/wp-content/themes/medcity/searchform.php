<?php
/**
 * Search Form
 */
$search_field_placeholder = medcity_get_opt( 'search_field_placeholder' );
?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url( '/' )); ?>">
	<div class="searchform-wrap">
        <input type="text" placeholder="<?php if(!empty($search_field_placeholder)) { echo esc_attr( $search_field_placeholder ); } else { esc_html_e('Search...', 'medcity'); } ?>" name="s" class="search-field" required />
    	<button type="submit" class="search-submit"><i class="far fa-search"></i></button>
    </div>
</form>