<?php
/*
Plugin Name: Faster WP-Admin Menus
Plugin URI: https://github.com/paulgibbs/??
Description: Experimenting with quicker-opening WP-Admin menus.
Version: 1.0
Requires at least: 3.6.1
Tested up to: 3.6.20
License: GPLv3
Author: Paul Gibbs
Author URI: http://byotos.com/
Text Domain: dpfm

http://bjk5.com/post/44698559168/breaking-down-amazons-mega-dropdown
*/

function dpfm_remove_hoverintent() {
	if ( ! is_admin() )
		return;

	// Hacky but effective way of stopping hoverIntent loading. Lots of things re-add into the stack.
	unset( $GLOBALS['wp_scripts']->registered['hoverIntent'] );
}
add_action( 'wp_print_scripts', 'dpfm_remove_hoverintent' );

function dpfm_enqueue_js() {
	wp_enqueue_script( 'dpfm', plugin_dir_url( __FILE__ ) . 'jquery.menu-aim.js', array( 'jquery' ) );
}
add_action( 'admin_init', 'dpfm_enqueue_js' );

function dpfm_inline_js() {
?>
<script type="text/javascript">
	function activateSubmenu(row) {
		jQuery('#adminmenu').find('li.menu-top').removeClass('opensub');
		jQuery(row).addClass('opensub');
	}

	function deactivateSubmenu(row) {
		jQuery(row).removeClass('opensub');
	}

	jQuery(document).ready(function () {
		jQuery('#adminmenu').menuAim({
			activate: activateSubmenu,
			deactivate: deactivateSubmenu
		});
	});

</script>
<?php
}
add_action( 'admin_footer', 'dpfm_inline_js' );