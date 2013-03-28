<?php get_header(); ?>

	<div id="single-content" class="widecolumn">

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>> 
		<?php if (function_exists('hotDates')) { hotDates(); ?>
		<h2 class="post-title-single"> <?php the_title(); ?> </h2>
		<?php } else { ?>
		<p class="post-date-single"> <?php the_time(get_option('date_format')); ?> </p> <h2 class="post-title-single"> <?php the_title(); ?> </h2>
		<?php } ?>
			<div class="post-entry">
				<?php if ( has_post_thumbnail() ) { // Post Thumbnail?
					the_post_thumbnail(); } ?>
				<?php the_content('<span class="more-link">Continue Reading &raquo;</span>'); ?>
				<?php wp_link_pages('<p>Pages: ', '</p>', 'number'); ?>
				<?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>
				<?php if (function_exists('related_posts')) {_e('Related posts:','corporateslave'); related_posts();} ?> <br />
			</div><!-- end post-entry  -->
			<!-- <?php trackback_rdf(); ?> -->
			<div class="post-footer">
				<p>Posted by <?php the_author(); ?> on <?php the_time('l, F jS, Y,'); ?> at <?php the_time(); ?>, and filed under <?php the_category(', '); ?>. Tags: <?php the_tags(); ?></p>
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

<?php comments_template(); ?>

		<div class="navigation">
			<div class="nav-left"><?php previous_post_link('&laquo; %link') ?></div>
			<div class="nav-right"><?php next_post_link('%link &raquo;') ?></div>
		</div><!-- end navigation -->

<?php endwhile; else : ?>

		<div id="post-error" class="post single-post">
			<h2 class="post-title-single">Not Found</h2>
			<div class="post-entry">
				<p>Apologies. But something you were looking for just can't be found. Please have a look around and try searching for what you're looking for.</p>
			</div><!-- end post-entry  -->
		</div><!-- end post -->

<?php endif; ?>

	</div><!-- end single-content -->
</div><!-- end container -->
<?php get_sidebar(); ?>
<div class="clearer">&nbsp;</div>
<?php get_footer(); ?>