<?php
/*
TEMPLATE NAME: Links Page
*/
?>
<?php get_header(); ?>

	<div id="single-content" class="widecolumn">

<!-- <?php if (have_posts()) : while (have_posts()) : the_post(); ?> -->

		<div id="post-<?php the_ID(); ?>" class="post single-post">
			<h2 class="post-title-single"><?php the_title(); ?></h2>
			<div class="post-entry">
				<?php the_content(); ?>

<?php wp_list_bookmarks('categorize=1&category=&category_name=&before=<li>&after=</li>&show_images=0&show_description=1&orderby=name'); ?>
			
				<?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>
			</div><!-- end post-entry  -->
			<!-- <?php trackback_rdf(); ?> -->
		</div><!-- end post -->

<!-- <?php endwhile; endif; ?> -->

	</div><!-- end single-content -->
</div><!-- end container  -->

<?php get_sidebar(); ?>
<div class="clearer">&nbsp;</div>
<?php get_footer(); ?>