<?php
/*
 * Template Name: Blog
 */

$args = array(
	'paged' => $paged,
	'post_type' => 'post',
	'order' => 'DESC',
	'orderby' => 'date',
	'posts_per_page' => 3
);

$wp_query = new WP_Query($args);

while ($wp_query -> have_posts()): $wp_query -> the_post(); ?>

<div class="blog-list row">
	<div class="col-md-4">
		<a title="<?php echo the_title(); ?>" href="<?php echo get_permalink(); ?>" class="thumnail zoom">
			<?php echo get_the_post_thumbnail( $post->ID, 'blog-thumbnail'); ?>
		</a>
	</div>
	<div class="col-md-8">
		<div class="col-md-12">
			<h3><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h3>
			<p><?php //the_excerpt(); ?></p>
			<div class="meta-update clearfix">
				<div class="public-time pull-left label label-default">เมื่อ: <?php the_time('j F Y');?></div>
				<div class="auther-name pull-right label label-success"><?php echo get_the_author(); ?></div>
			</div>
		</div>
	</div>
</div>

<?php endwhile; ?>