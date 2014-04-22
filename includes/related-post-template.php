<?php
if ( !class_exists( 'NelioSRPRelatedPostTemplate' ) ) {
class NelioSRPRelatedPostTemplate {

public static function render( $post ) {
	ob_start();

	$open_link = sprintf(
		'<a href="%s" title="%s">',
		get_permalink( $post->ID ),
		esc_attr( apply_filters( 'the_title', $post->post_title ) )
	);
	$close_link = '</a>';
	?>

	<article class="post-<?php echo $post->ID; ?> post type-post status-publish entry" itemscope="itemscope">
		<div class="entry-title">
			<p><?php
				echo $open_link;
				echo apply_filters( 'the_title', $post->post_title );
				echo $close_link;
			?></p>
		</div>
		<?php
		if ( has_post_thumbnail( $post->ID ) ) { ?>
		<div class="featured-image alignleft">
			<?php
			echo $open_link;
			echo get_the_post_thumbnail( $post->ID, 'thumbnail' );
			echo $close_link;
			?>
		</div>
		<?php
		} ?>
		<div class="entry-content">
			<?php echo neliosrp_extract_excerpt( $post, NelioSRPSettings::get_max_num_of_words_in_excerpt() ); ?>
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
	return $value;
}

} }
?>
