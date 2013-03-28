<?php get_header(); ?>

	<div id="single-content" class="widecolumn">

<?php if (have_posts()) : ?>

<?php $post = $posts[0]; ?>
<?php if (is_category()) { ?>				
		<p class="post-date-single">{ Category Archives }</p>
		<h2 class="post-title-single"><?php echo single_cat_title(); ?></h2>		
<?php } elseif (is_day()) { ?>
		<p class="post-date-single">{ Daily Archives }</p>
		<h2 class="post-title-single"><?php the_time('F jS, Y'); ?></h2>		
<?php } elseif (is_month()) { ?>
		<p class="post-date-single">{ Monthly Archives }</p>
		<h2 class="post-title-single"><?php the_time('F Y'); ?></h2>
<?php } elseif (is_year()) { ?>
		<p class="post-date-single">{ Yearly Archives }</p>
		<h2 class="post-title-single"><?php the_time('Y'); ?></h2>		
<?php } elseif (is_search()) { ?>
		<p class="post-date-single">{ &#8220; <?php echo esc_html($s); ?> &#8221; }</p>
		<h2 class="post-title-single">Search Results</h2>		
<?php } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
		<h2 class="post-title-single">Blog Archives</h2>
<?php } ?>

<?php while (have_posts()) : the_post(); ?>
				
		<div id="post-<?php the_ID(); ?>" class="post single-post"> 
		<?php if (function_exists('hotDates')) { hotDates(); ?>
		<h2 class="post-title-single"> <?php the_title(); ?> </h2>
		<?php } else { ?>
		<p class="post-date-single"> <?php the_time(get_option('date_format')); ?> </p> <h2 class="post-title-single"> <?php the_title(); ?> </h2>
		<?php } ?>

			<div class="post-entry">
						<?php if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
							the_post_thumbnail(); } ?>
				<?php the_content('<span class="more-link">Continue Reading &raquo;</span>'); ?>
				<?php wp_link_pages('<p>Pages: ', '</p>', 'number'); ?>
				<?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>
				<!-- <?php if (function_exists('wp_notable')) wp_notable(); ?><br /><br /> -->
				<?php if (function_exists('related_posts')) {_e('Related posts:','corporateslave'); related_posts();} ?> <br />
			</div><!-- end post-entry  -->

			<div class="post-footer">
				<p>Posted by <?php the_author(); ?> at <?php the_time(get_option('date_format')); ?>, and filed under <?php the_category(', ') ?>.</p>
				<p>Follow any responses to this entry with the <?php post_comments_feed_link('RSS 2.0'); ?> feed.</p>
<?php if (('open' == $post-> comment_status) && ('open' == $post->ping_status)) { ?>
				<p>You can <a href="#respond">post a comment</a>, or <a href="<?php trackback_url(true); ?>" rel="trackback">trackback</a> from your site.</p>
<?php } elseif (!('open' == $post-> comment_status) && ('open' == $post->ping_status)) { ?>
				<p>You can <a href="<?php trackback_url(true); ?> " rel="trackback">trackback</a> from your site.</p>
<?php } elseif (('open' == $post-> comment_status) && !('open' == $post->ping_status)) { ?>
				<p>You can <a href="#respond">post a comment</a>.</p>
<?php } elseif (!('open' == $post-> comment_status) && !('open' == $post->ping_status)) { ?>
<?php } ?>
			</div><!-- end post-footer -->
		</div><!-- end post -->
		<br />
<?php endwhile; ?>

		<div class="navigation">
			<div class="nav-left"><?php next_posts_link('&laquo; Older posts') ?></div>
			<div class="nav-right"><?php previous_posts_link('Newer posts &raquo;') ?></div>
		</div><!-- end navigation -->

<?php else : ?>

		<div id="post-error" class="post single-post">
			<h2 class="post-title-single">Not Found</h2>
			<div class="post-entry">
				<p>Apologies. But something you were looking for just can't be found. Please have a look around and try searching for what you're looking for.</p>
			</div><!-- end post-entry  -->
		</div><!-- end post -->

<?php endif; ?>

	</div><!-- end single-content -->
</div><!-- end container  -->

<?php get_sidebar(); ?>
<div class="clearer">&nbsp;</div>
<?php get_footer(); ?>