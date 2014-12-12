<?php

add_action( 'add_meta_boxes', 'neliosrp_search_query' );
function neliosrp_search_query() {
	add_meta_box(
		'neliosrp_search',
		'Nelio Related Posts',
		'neliosrp_search_query_meta',
		'post',
		'side',
		'default'
	);
}

function neliosrp_search_query_meta( $post ) {
	$neliosrp_search_query = get_post_meta( $post->ID, '_neliosrp_search_query', true );
	?>
	<input type="text"
		placeholder="<?php _e( 'Search String', 'neliosrp' ); ?>"
		name="neliosrp_search_query" value="<?php echo esc_attr( $neliosrp_search_query ); ?>" />
	<?php
}

add_action( 'save_post', 'neliosrp_save_query_string' );
function neliosrp_save_query_string( $post_ID ) {
	$post = get_post( $post_ID );
	if( $post && $post->post_type == 'post' ) {
		if (isset( $_POST['neliosrp_search_query'] ) ) {
			update_post_meta( $post_ID, '_neliosrp_search_query', strip_tags( $_POST['neliosrp_search_query'] ) );
		}
	}
}

