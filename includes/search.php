<?php

if ( !class_exists( 'NelioSRPSearch' ) ) {

	class NelioSRPSearch {

		public function search( $string ) {
			include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			if ( is_plugin_active( 'swiftype-search/swiftype.php' ) ) {
				try {
					return $this->swiftype_search( $string );
				} catch ( Exception $e ) {}
			}
			return $this->wordpress_search( $string );
		}

		/**
		 * The function returns a list of up to 20 related
		 * posts. The related posts are obtained by searching
		 * the given string.
		 */
		public function wordpress_search( $string ) {
			global $post;
			$args = array(
				's'              => $string,
				'posts_per_page' => 20,
				'post_type'      => 'post',
			);

			$ori_post = false;
			if ( $post ) {
				$ori_post = $post;
				$args['post__not_in'] = array( $post->ID );
			}

			$my_query = new wp_query( $args );
			$related_posts = array();
			while( $my_query->have_posts() ) {
				$my_query->the_post();
				array_push( $related_posts, $post );
			}

			if ( $ori_post )
				$post = $ori_post;

			return $related_posts;
		}

		/**
		 * The function returns a list of up to 20 related
		 * posts. The related posts are obtained by searching
		 * the given string with swiftype.
		 */
		public function swiftype_search( $string ) {
			global $post;
			$api_key     = get_option( 'swiftype_api_key' );
			$engine_slug = get_option( 'swiftype_engine_slug' );
			$client      = new SwiftypeClient();
			$client->set_api_key( $api_key );

			$swiftype_result = $client->search(
				$engine_slug, 'posts', $string, array( 'page' => '1' ) );

			$related_posts = array();
			foreach ( $swiftype_result['records']['posts'] as $rel ) {
				$id = $rel['external_id'];
				if ( $post && $post->ID == $id ) continue;
				$rel_post = get_post( $id );
				if ( $rel_post )
					array_push( $related_posts, $rel_post );
			}

			return $related_posts;
		}

	}

}

