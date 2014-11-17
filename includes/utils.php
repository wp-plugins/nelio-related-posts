<?php

function neliosrp_split_nth( $str, $delim, $n ) {
	$arr = explode( $delim, $str );
	$arr = array_slice( $arr, 0, min( $n, count( $arr ) ) );
	return implode( $delim, $arr );
}

function neliosrp_extract_excerpt( $post, $words = 80 ) {
	if ( NelioSRPSettings::use_excerpt_if_available() && strlen( $post->post_excerpt ) > 0 )
		return apply_filters( 'get_the_excerpt', $post->post_excerpt );

	$content = $post->post_content;
	$content = strip_shortcodes( $content );
	$content = strip_tags( $content );
	$excerpt = neliosrp_split_nth( $content, ' ', $words );
	if ( strlen( $excerpt ) < strlen( $content ) )
		$excerpt .= '...';
	return $excerpt;
}

