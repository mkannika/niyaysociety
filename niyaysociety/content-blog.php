<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package Wordpress
 * @subpackage niyaysociety
 */
 ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">
		<?php
			if ( is_single() ) :
				the_title( '<h1 class="entry-title">', '</h1>' );
			else :
				the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
			endif;
		?>
	</header><!-- .entry-header -->

	<?php if (has_post_thumbnail( $post->ID ) ): ?>
	<div class="post-thumbnail">
		<a title="<?php echo the_title(); ?>" href="<?php echo get_permalink(); ?>"><?php echo get_the_post_thumbnail( $post->ID, 'blog-large'); ?>
		</a>
	</div>
	<?php endif; ?>

	<!--Post meta-->
	<div class="postMeta">
		<span class="metaAuthor"><?php the_time('j F Y');?> by <?php the_author_posts_link(); ?></span>
		<span class="metaCategory">in <?php the_category(', '); ?></span>
	</div>
	<!--End post meta-->

	<div class="entry-content">
		<?php

			the_excerpt();

			wp_link_pages( array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'niyaysociety' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'niyaysociety' ) . ' </span>%',
				'separator'   => '<span class="screen-reader-text">, </span>',
			) );
		?>
	</div><!-- .entry-content -->

	<?php
		// Author bio.
		if ( is_single() && get_the_author_meta( 'description' ) ) :
			get_template_part( 'author' );
		endif;
	?>

	<footer class="entry-footer">
		<?php niyaysociety_entry_meta(); ?>
		<?php //edit_post_link( __( 'Edit', 'niyaysociety' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-footer -->

</article><!-- #post-## -->
