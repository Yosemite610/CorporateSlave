<?php get_header(); ?>

<!-- toppost here -->
<div id="toppost">
<?php if (have_posts()) : ?>
	<?php $top_post_cat='cat=' . corporateslave_option('toppostcat'); ?> <!-- determine category for toppost -->
	<?php query_posts($top_post_cat . '&showposts=1'); ?> <!-- only show the most recent one -->
	<?php while (have_posts()) : the_post(); $do_not_duplicate = $post->ID; ?> <!-- don't duplicate it in other columns -->
		<div class="post-content">
			<div class="post-title"><a href="<?php the_permalink() ?>" title="Permalink to <?php the_title(); ?>" rel="bookmark"><?php the_title(); ?></a>
				<h3 class="post-date"><?php the_time(get_option('date_format')); ?> </h3>
			</div>
			<div class="post-entry">
				<?php if ( has_post_thumbnail() ) { // Post Thumbnail?
					the_post_thumbnail(); } ?>
				<?php the_content('<span class="more-link">Continue Reading &raquo;</span>'); ?>
				<hr />
			</div> <!-- end post-entry -->
		</div> <!-- end post-content  -->
	<?php endwhile; ?>
</div> <!-- end toppost -->
<?php else :
	echo "<!-- no category defined for toppost? -->\n </div>";
	endif;
?>

<!-- content1 column here -->
<div id="content1">
<?php if (have_posts()) : ?>
	<?php $cat_id='cat=' . corporateslave_option('col1cats'); ?>
	<?php query_posts($cat_id.'&posts_per_page=5&paged='.$paged); ?>
<?php while (have_posts()) : the_post(); if( $post->ID == $do_not_duplicate ) continue; update_post_caches($posts); ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<div class="post-container">
				<div class="post-content">
					<div class="post-title"><a href="<?php the_permalink() ?>" title="Permalink to <?php the_title(); ?>" rel="bookmark"><?php the_title(); ?></a>
					<h3 class="post-date"><?php the_time(get_option('date_format')); ?> </h3>
					</div>
					<div class="post-entry">
						<?php if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
							the_post_thumbnail(); } ?>
						<?php the_content('<span class="more-link">Continue Reading &raquo;</span>'); ?>
						<?php wp_link_pages('<p style="margin:-1em 0 0 0;"><strong>Pages: ', '</strong></p>', 'number'); ?>
						<!-- <?php trackback_rdf(); ?> -->
					</div><!-- end post-entry -->
					<!-- <?php if (function_exists('wp_notable')) wp_notable(); ?> -->
				</div><!-- end post-content  -->
			</div><!-- end post-container -->
			<div class="post-header">
				<p class="post-categories">Categories: <?php the_category(', ') ?></p>
				<span class="post-comments"><?php comments_popup_link('Comments (0)', 'Comments (1)', 'Comments (%)'); ?></span>
				<span class="post-permalink"><a href="<?php the_permalink() ?>" title="Permalink to <?php the_title(); ?>" rel="permalink">Permalink</a></span><br />
				<?php edit_post_link('Edit', '<p class="post-edit">', '</p>'); ?>
				<hr />
			</div><!-- end post-header -->
		</div><!-- end post -->
<?php endwhile;?>
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
</div><!-- end content1 column -->

<!-- content2 column start -->
<div id="content2">
<?php if (have_posts()) : ?>
	<?php $cat_id='cat=' . corporateslave_option('col2cats'); ?>
	<?php query_posts($cat_id.'&posts_per_page=5&paged='.$paged); ?>
<?php while (have_posts()) : the_post(); if( $post->ID == $do_not_duplicate ) continue; update_post_caches($posts); ?>
		<div id="post-<?php the_ID(); ?>" class="post">
			<div class="post-container">
				<div class="post-content">
					<div class="post-title"><a href="<?php the_permalink() ?>" title="Permalink to <?php the_title(); ?>" rel="bookmark"><?php the_title(); ?></a>
					<h3 class="post-date"><?php the_time(get_option('date_format')); ?> </h3>
					</div>
					<div class="post-entry">
						<?php if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
							the_post_thumbnail(); } ?>
						<?php the_content('<span class="more-link">Continue Reading &raquo;</span>'); ?>
						<?php wp_link_pages('<p style="margin:-1em 0 0 0;"><strong>Pages: ', '</strong></p>', 'number'); ?>
						<!-- <?php trackback_rdf(); ?> -->
					</div><!-- end post-entry -->
				</div><!-- end post-content  -->
			</div><!-- end post-container -->
			<div class="post-header">
				<p class="post-categories">Categories: <?php the_category(', ') ?></p>
				<span class="post-comments"><?php comments_popup_link('Comments (0)', 'Comments (1)', 'Comments (%)'); ?></span>
				<span class="post-permalink"><a href="<?php the_permalink() ?>" title="Permalink to <?php the_title(); ?>" rel="permalink">Permalink</a></span><br />
				<?php edit_post_link('Edit', '<p class="post-edit">', '</p>'); ?>
				<hr />
			</div><!-- end post-header -->
		</div><!-- end post -->
<?php endwhile;?>
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
		</div><!-- end post-error -->
<?php endif; ?>

</div><!-- end content2 column -->
</div><!-- end container -->
<?php get_sidebar(); ?>
<div class="clearer">&nbsp;</div>
<?php get_footer(); ?>