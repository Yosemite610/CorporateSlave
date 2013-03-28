<?php get_header(); ?>

	<div id="single-content" class="widecolumn">
		<div id="post-search" class="post single-post">
			<p class="post-date-single">{ Query: &#8220;<?php echo esc_html($s); ?>&#8221; }</p>
			<h2 class="post-title-single">Search Results</h2>

<?php if (have_posts()) : ?>

			<div class="post-entry">
				<p>Search complete for &#8220;<strong><?php echo esc_html($s); ?></strong>&#8221;. Results are below.</p>
				<ol>
<?php while (have_posts()) : the_post(); ?>
					<li id="post-<?php the_ID(); ?>" style="margin-bottom:10px;">
						<strong><a href="<?php the_permalink() ?>" rel="bookmark" title="Permalink to <?php the_title(); ?>"><?php the_title(); ?></a></strong>
						<br/>
						<span class="excerpt"><?php the_excerpt_rss(); ?></span>
						<br />
						<em>Filed in <?php the_category(', ') ?> | <?php the_time('d-M-y') ?> | <?php comments_popup_link('no comments', 'one comment', '% comments'); ?></em>
					</li>
<?php endwhile; ?>
				</ol>
			</div><!-- end post-entry -->
		</div><!-- end post -->

		<div class="navigation" style="margin-top:3em;">
			<div class="nav-left"><?php next_posts_link('&laquo; Older posts') ?></div>
			<div class="nav-right"><?php previous_posts_link('Newer posts &raquo;') ?></div>
		</div><!-- end navigation -->

<?php else : ?>

			<div class="post-entry">
				<p>Nothing was found with &#8220;<strong><?php echo esc_html($s); ?></strong>&#8221;. Please change your keyword(s) and try your search again.</p>
				<form method="get" action="<?php echo home_url(); ?>/">
					<p><label for="s"><strong>Search Again:</strong></label>&nbsp;&nbsp;&nbsp;
					<input type="text" name="s" size="5" tabindex="1" style="border:1px inset #666;font-size:1.125em;font-family:verdana, helvetica, sans-serif;margin: 0;padding: 2px;width:7em;" />
					<input type="submit" name="searchsubmit" value="Find" tabindex="2" /></p>
				</form>
			</div><!-- end post-entry -->
		</div><!-- end post -->

<?php endif; ?>

	</div><!-- end content -->
</div><!-- end container  -->
<?php get_sidebar(); ?>
<div class="clearer">&nbsp;</div>
<?php get_footer(); ?>