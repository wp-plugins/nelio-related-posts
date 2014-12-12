<?php
global $post;
$open_link = sprintf(
	'<a class="related_post_link" href="%s" title="%s">',
	get_permalink( $post->ID ),
	esc_attr( apply_filters( 'the_title', $post->post_title, $post->ID ) )
);
$close_link = '</a>';
?>

<article class="post-<?php echo $post->ID; ?> post type-post status-publish entry" itemscope="itemscope"><?php
	if ( has_post_thumbnail( $post->ID ) ) { ?>
	<div class="featured-image alignleft">
		<?php
		echo $open_link;
		echo get_the_post_thumbnail( $post->ID, 'post-thumbnail' );
		echo $close_link;
		?>
	</div>
	<?php
	} ?>
	<h2 class="entry-title"><?php
			echo $open_link;
			echo apply_filters( 'the_title', $post->post_title, $post->ID );
			echo $close_link;
		?></h2>
	<div class="entry-content">
		<?php echo neliosrp_extract_excerpt( $post, NelioSRPSettings::get_max_num_of_words_in_excerpt() ); ?>
		<?php
		echo $open_link;
		echo NelioSRPSettings::get_read_more_label();
		echo $close_link;
		?>
	</div>
</article>

