<?php
/*
 * Template Name: Front Page
 */
get_header(); ?>


<div id="primary" class="content-area col-md-9">
	<main id="main" class="site-main" role="main">

	<?php

	$args = array(
		'paged' => $paged,
		'post_type' => 'post',
		'order' => 'DESC',
		'orderby' => 'date',
		'posts_per_page' => 3
	);

	$wp_query = new WP_Query($args);

	while ($wp_query -> have_posts()): $wp_query -> the_post();

		get_template_part( 'content-blog', get_post_format() );

	endwhile; ?>

	<?php dym_numeric_posts_nav(); ?>

	</main><!-- .site-main -->
</div><!-- .content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
