<?php
get_header(); ?>

	<div id="primary" class="content-area col-md-9">
		<main id="main" class="site-main" role="main">

		<?php
		// Start the loop.
		while ( have_posts() ) : the_post();

			/*
			 * Include the post format-specific template for the content. If you want to
			 * use this in a child theme, then include a file called called content-___.php
			 * (where ___ is the post format) and that will be used instead.
			 */
			get_template_part( 'content', get_post_format() );

			the_post_navigation( array(
				'prev_text' => '<span class="post-title">&laquo %title</span>',
				'next_text' => '<span class="post-title">%title &raquo</span>',
				'screen_reader_text' => __( 'บทความอื่นๆ' ),
			) );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		// End the loop.
		endwhile;
		?>

		</main><!-- .site-main -->
	</div><!-- .content-area -->

	<?php get_sidebar(); ?>

<?php get_footer(); ?>
