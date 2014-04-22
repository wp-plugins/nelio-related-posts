<?php

function neliosrp_split_nth( $str, $delim, $n ) {
	$arr = explode( $delim, $str );
	$arr = array_slice( $arr, 0, min( $n, count( $arr ) ) );
	return implode( $delim, $arr );
}

function neliosrp_extract_excerpt( $post, $words = 80 ) {
	if ( NelioSRPSettings::use_excerpt_if_available() && strlen( $post->post_excerpt ) > 0 )
		return apply_filters( 'the_excerpt', $post->post_excerpt );

	$excerpt = $post->post_content;
	$excerpt = strip_shortcodes( $excerpt );
	$excerpt = strip_tags( $excerpt );
	$excerpt = neliosrp_split_nth( $excerpt, ' ', $words ) . '...';
	return $excerpt;
}

?>
