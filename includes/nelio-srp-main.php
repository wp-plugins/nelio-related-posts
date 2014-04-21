<?php

if ( !class_exists( 'NelioSRPMain' ) ) {

	class NelioSRPMain {

		/**
		 * This function creates the required hooks for adding
		 * a list of related posts after a post's content.
		 */
		public function __construct() {
			if ( !is_admin() ) {
				add_action( 'wp_enqueue_scripts',  array( &$this, 'add_styles' ) );
				add_filter( 'the_content',         array( &$this ,'append_related_posts' ) );
			}
			else {
				add_action( 'save_post',           array( &$this, 'reset_related_posts' ) );
			}
		}

		public function add_styles() {
			wp_enqueue_style( 'nelio-srp', NELIOSRP_ASSETS_URL . '/nelio-srp.css' );
		}

		public function append_related_posts( $content ) {
			global $post;
			if ( $post->post_type != 'post' || is_feed() )
				return $content;

			remove_filter( 'the_content', array( &$this ,'append_related_posts' ) );
			require_once( NELIOSRP_DIR . '/related-post-template.php' );
			$related_posts = $this->get_related_posts();
			$num_of_posts  = min( count( $related_posts ), NelioSRPSettings::get_max_num_of_rel_posts() );

			$res = '';
			if ( $num_of_posts > 0 ) {
				$res .= '<div id="neliosrp" class="neliosrp-widget" data-swiftype-index="false">';
				$res .= '<h2>';
				$res .= strtr( NelioSRPSettings::get_title(), array( '{post_title}' => $post->post_title ) );
				$res .= '</h2>';
				for ( $i = 0; $i < $num_of_posts; ++$i ) {
					$rel_post = $related_posts[$i];
					$res .= NelioSRPRelatedPostTemplate::render( $rel_post );
				}
				$res .= '</div>';
			}

			add_filter( 'the_content', array( &$this ,'append_related_posts' ) );
			return $content . $res;
		}

		public function get_related_posts() {
			global $post;
			$now = time();
			$interval = max( 1, NelioSRPSettings::get_refresh_cache_interval_in_days() ) * 86400;
			$last_update = get_post_meta( $post->ID, '_neliosrp_last_update', true );
			if ( !$last_update )
				$last_update = 0;

			if ( $last_update + $interval < $now ) {
				require_once( NELIOSRP_DIR . '/search.php' );
				$searcher = new NelioSRPSearch();
				$result   = $searcher->search( $this->get_search_string() );
				update_post_meta( $post->ID, '_neliosrp_last_update', $now );
				update_post_meta( $post->ID, '_neliosrp_related_posts', $result );
			}
			else {
				$result = get_post_meta( $post->ID, '_neliosrp_related_posts', true );
				if ( !$result )
					$result = array();
			}

			return $result;
		}

		public function reset_related_posts( $post_id ) {
			if ( wp_is_post_revision( $post_id ) )
				return;
			update_post_meta( $post_id, '_neliosrp_last_update', 0 );
			$aux = $this->get_related_posts();
		}

		private function get_search_string() {
			global $post;

			// OPTION 1. The search query the user specified
			$str = get_post_meta( $post->ID, '_neliosrp_search_query', true );
			if ( $str )
				return $str;

			// OPTION 2. One of the tags
			$posttags = get_the_tags();
			if ( $posttags ) {
				foreach( $posttags as $tag ) {
					$hashtag = $tag->name;
					$tag = $tag->name;
					if ( strpos( $tag, ' ' ) === false ) {
						$hashtag = $tag;
						break;
					}
				}
				return $hashtag;
			}

			// OPTION 3. A search that doesn't matter at all, just
			// to return something
			return '';
		}

	}

	$aux = new NelioSRPMain();
}

?>
