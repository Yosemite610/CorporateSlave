<?php
/*
Template Name: Archives Page
*/
?>
<?php get_header(); ?>

	<div id="single-content" class="widecolumn">

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<div id="post-<?php the_ID(); ?>" class="post single-post">
			<h2 class="post-title-single"><?php the_title(); ?></h2>
			<div class="post-entry">
				<?php if ( has_post_thumbnail() ) { // Post Thumbnail?
							the_post_thumbnail(); } ?>
				<?php the_content(); ?>
					<div style="clear:both;width:45%;padding:0 1em;float:left;">
						<p class="list-title"><strong>Categories</strong></p>
						<ul style="margin-top:0;">
							<?php wp_list_categories('sort_column=name&optioncount=1&feed=(RSS)&title_li=&feed_image='.get_bloginfo('template_url').'/images/feed.png&hierarchical=1'); ?>
						</ul>
					</div>
					<div style="width:45%;padding:0 1em;float:left;">
						<p class="list-title"><strong>Archives</strong></p>
						<ul style="margin-top:0;">
							<?php wp_get_archives('type=monthly&show_post_count=1&title_li='); ?>
						</ul>
					</div>
					<div class="clearer"></div>
				<?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>
			</div><!-- end post-entry  -->
			<!-- <?php trackback_rdf(); ?> -->
		</div><!-- end post -->

<?php endwhile; endif; ?>

	</div><!-- end single-content -->
</div><!-- end container  -->

<?php get_sidebar(); ?>
<div class="clearer">&nbsp;</div>
<?php get_footer(); ?>