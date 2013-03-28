<?php header('Where is that damn thing?', true, 404); ?>
<?php get_header(); ?>

	<div id="single-content" class="widecolumn">
		<div id="post-error404" class="post single-post">
			<p class="post-date-single" style="margin-top:25px;">{ Error 404 }</p>
			<h2 class="post-title-single">Page Not Found</h2>
			<div class="post-entry">
				<p>Apologies. There's been a problem finding the page you're looking for. Perhaps . . .</p>
				<ul>
					<li>The page your looking for was moved</li>
					<li>Your referring site gave you an incorrect address</li>
					<li>Something went terribly, horribly wrong</li>
					<li>You had a short between the headphones</li>
				</ul> 
				<p>Use the search box to see if you can't find what you're looking for.</p>
				<form id="searchform" method="get" action="<?php echo home_url(); ?>/">
					<div>
						<input id="s" name="s" type="text" value="<?php echo esc_html($s, 1); ?>" tabindex="1" size="10" /> <input id="searchsubmit" name="searchsubmit" type="submit" value="Find" tabindex="2" />
					</div>
				</form> 
			</div><!-- end post-entry  -->
		</div><!-- end post -->
	</div><!-- end single-content -->
</div><!-- end container  -->

<?php get_sidebar(); ?>
<div class="clearer">&nbsp;</div>
<?php get_footer(); ?>