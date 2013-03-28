<div id="footer">  
		<p>
			&copy; <?php echo(date('Y')); ?> <?php bloginfo('name'); ?> 
			|
			Thanks, <a href="http://wordpress.org/" title="WordPress">WordPress</a>
			|
			Ported to WordPress by <a href="http://www.samdevol.com/" title="Sam Devol" rel="nofollow">Sam Devol</a><br />Original Design by <a href="http://www.dream-logic.com" title="Corporate Slave for WordPress" rel="nofollow">dreamLogic</a>
			|
			Subscribe to RSS: <a href="<?php bloginfo('rss2_url'); ?>" title="<?php bloginfo('name'); ?> RSS 2.0 (XML) Feed" rel="alternate" type="application/rss+xml">Posts</a> &amp; <a href="<?php bloginfo('comments_rss2_url'); ?>" title="<?php bloginfo('name'); ?> Comments RSS 2.0 (XML) Feed" rel="alternate" type="application/rss+xml">Comments</a><br />
			<?php /* here is where the custom footer text is called */ if ( corparateslave_option( 'footeraddin' ) )
				echo corparateslave_option( 'footertext' ); ?>
			<?php do_action('wp_footer'); ?>
		</p>
</div>
</div><!-- end wrap -->
<?php wp_footer(); ?>
</body>
</html>