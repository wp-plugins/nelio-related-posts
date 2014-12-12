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
			}
			else {
				add_action( 'save_post',           array( &$this, 'reset_related_posts' ) );
			}
		}

		public function add_styles() {
			wp_enqueue_style( 'nelio-srp', NELIOSRP_ASSETS_URL . '/nelio-srp.css' );
		}

		public function the_related_posts( $template_name ) {
			global $post;
			$single_post_id = 0;
			if ( is_single() && is_object( $post ) && isset( $post->ID ) )
				$single_post_id = $post->ID;

			$template = NELIOSRP_DIR . '/related-post-template.php';
			if ( $template_name ) {
				$aux = get_stylesheet_directory() . '/neliosrp/' . $template_name . '.php';
				if ( file_exists( $aux ) )
					$template = $aux;
			}

			$related_posts = $this->get_related_posts();
			$num_of_posts  = min( count( $related_posts ), NelioSRPSettings::get_max_num_of_rel_posts() );
			if ( $num_of_posts > 0 ) {
				$div = '<div class="neliosrp-row">';
				?>
					<div class="neliosrp" data-swiftype-index="false"><?php
					echo "\n";
					$i = 0;
					global $post;
					$ori_post = $post;
					foreach ( $related_posts as $post ) {
						if ( $post->ID == $single_post_id )
							continue;
						if ( $i%2 == 0 ) echo "\t\t\t\t\t$div\n";
						include( $template );
						if ( $i%2 != 0 ) echo "\t\t\t\t\t</div>\n";
						$i++;
					}
					$post = $ori_post;
					if ( $i%2 != 0 ) echo "\t\t\t\t\t</div>"; ?>
				</div>
				<?php
			}

		}

		public function get_related_posts() {
			global $post;
			if ( $post && is_single() ) {
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
			}
			else {
				require_once( NELIOSRP_DIR . '/search.php' );
				$searcher = new NelioSRPSearch();
				$result   = $searcher->search( $this->get_search_string() );
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
			if ( $post ) {
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
			}

			// OPTION 3. A search that doesn't matter at all, just
			// to return something
			return '';
		}

	}

}

$neliosrp_main = new NelioSRPMain();
function neliosrp_the_related_posts() {
	if ( NelioSRPSettings::append_to_content_automatically() )
		return;
	global $neliosrp_main;
	echo $neliosrp_main->the_related_posts();
}

