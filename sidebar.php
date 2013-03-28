<div id="sidebar">
	<div onclick="location.href='<?php echo home_url(); ?>/';" style="cursor:pointer;">
		<img src="<?php header_image(); ?>" height="<?php echo get_custom_header()->height; ?>" width="<?php echo get_custom_header()->width; ?>" alt="Site Logo" /> 
	</div>
<?php

$defaults = array(
	'theme_location'  => 'corporateslave',
	'menu'            => 'Primary Menu',
	'container'       => 'div',
	'container_class' => 'primary-menu',
	'container_id'    => '',
	'menu_class'      => 'navlist',
	'menu_id'         => '',
	'echo'            => true,
	'fallback_cb'     => 'wp_page_menu',
	'before'          => '',
	'after'           => '',
	'link_before'     => '',
	'link_after'      => '',
	'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
	'depth'           => 0,
	'walker'          => ''
);

wp_nav_menu( $defaults );

?>

	<ul>
	<?php /* HERE IS THE CALL FOR WIDGETS */if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Main Sidebar') ) : ?>

	<?php endif; /* END FOR WIDGETS CALL */ ?>

	<?php /* here is where the custom footer text is called */ if ( corporateslave_option( 'sidebaraddin' ) )	
		echo corporateslave_option( 'sidebartext' ); ?>
	</ul>
</div><!--end sidebar-->