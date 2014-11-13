<?php
if ( !class_exists( 'NelioSRPRelatedPostTemplate' ) ) {
class NelioSRPRelatedPostTemplate {

public static function render( $post_to_render ) {
	global $post;
	$ori_post = false;
	if ( $post ) {
		$ori_post = $post;
		$post = $post_to_render;
	}

	ob_start();

	$open_link = sprintf(
		'<a class="related_post_link" href="%s" title="%s">',
		get_permalink( $post_to_render->ID ),
		esc_attr( apply_filters( 'the_title', $post_to_render->post_title ) )
	);
	$close_link = '</a>';
	?>

	<article class="post-<?php echo $post_to_render->ID; ?> post type-post status-publish entry" itemscope="itemscope"><?php
		if ( has_post_thumbnail( $post_to_render->ID ) ) { ?>
		<div class="featured-image alignleft">
			<?php
			echo $open_link;
			echo get_the_post_thumbnail( $post_to_render->ID, 'post-thumbnail' );
			echo $close_link;
			?>
		</div>
		<?php
		} ?>
		<h2 class="entry-title"><?php
				echo $open_link;
				echo apply_filters( 'the_title', $post_to_render->post_title, $post_to_render->ID );
				echo $close_link;
			?></h2>
		<div class="entry-content">
			<?php echo neliosrp_extract_excerpt( $post_to_render, NelioSRPSettings::get_max_num_of_words_in_excerpt() ); ?>
			<?php
			echo $open_link;
			echo NelioSRPSettings::get_read_more_label();
			echo $close_link;
			?>
		</div>
	</article>
<?php

	$value = ob_get_contents();
	ob_end_clean();

	if ( $ori_post )
		$post = $ori_post;

	return $value;
}

} }

