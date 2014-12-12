<?php

class NelioSRPSettings {

	const DEFAULT_NUM_OF_REL_POSTS         = 10;
	const DEFAULT_NUM_OF_WORDS_IN_EXCERPT  = 80;
	const DEFAULT_READ_MORE_LABEL          = 'Read more';
	const DEFAULT_USE_EXCERPT_IF_AVAILABLE = true;
	const DEFAULT_DAYS_FOR_CACHE           = 10;
	const DEFAULT_AUTO_APPEND_TO_CONTENT   = true;

	public static function get_settings() {
		return get_option( 'neliosrp_settings', array()	);
	}

	public static function get_max_num_of_rel_posts() {
		$settings = NelioSRPSettings::get_settings();
		if ( isset( $settings['max_num_of_rel_posts'] ) )
			return $settings['max_num_of_rel_posts'];
		return NelioSRPSettings::DEFAULT_NUM_OF_REL_POSTS;
	}

	public static function use_excerpt_if_available() {
		$settings = NelioSRPSettings::get_settings();
		if ( isset( $settings['use_excerpt'] ) )
			return $settings['use_excerpt'];
		return NelioSRPSettings::DEFAULT_USE_EXCERPT_IF_AVAILABLE;
	}

	public static function get_max_num_of_words_in_excerpt() {
		$settings = NelioSRPSettings::get_settings();
		if ( isset( $settings['max_num_of_words_in_excerpt'] ) )
			return $settings['max_num_of_words_in_excerpt'];
		return NelioSRPSettings::DEFAULT_NUM_OF_WORDS_IN_EXCERPT;
	}

	public static function get_read_more_label() {
		$settings = NelioSRPSettings::get_settings();
		if ( isset( $settings['read_more_label'] ) )
			return $settings['read_more_label'];
		return NelioSRPSettings::DEFAULT_READ_MORE_LABEL;
	}

	public static function get_refresh_cache_interval_in_days() {
		$settings = NelioSRPSettings::get_settings();
		if ( isset( $settings['cache_interval'] ) )
			return $settings['cache_interval'];
		return NelioSRPSettings::DEFAULT_DAYS_FOR_CACHE;
	}

	/**
	 * Sanitize each setting field as needed
	 *
	 * @param array $input Contains all settings fields as array keys
	 */
	public function sanitize( $input ) {
		$new_input = array();

		// RELATED POSTS
		// ------------------------------------------------

		$new_input['max_num_of_rel_posts'] = NelioSRPSettings::DEFAULT_NUM_OF_REL_POSTS;
		if( isset( $input['max_num_of_rel_posts'] ) )
			$new_input['max_num_of_rel_posts'] = absint( $input['max_num_of_rel_posts'] );
		$new_input['max_num_of_rel_posts'] = min( absint( $input['max_num_of_rel_posts'] ), 20 );

		$new_input['use_excerpt'] = 0;
		if( isset( $input['use_excerpt'] ) )
			$new_input['use_excerpt'] = 1;

		$new_input['max_num_of_words_in_excerpt'] = NelioSRPSettings::DEFAULT_NUM_OF_WORDS_IN_EXCERPT;
		if( isset( $input['max_num_of_words_in_excerpt'] ) )
			$new_input['max_num_of_words_in_excerpt'] = absint( $input['max_num_of_words_in_excerpt'] );
		$new_input['max_num_of_words_in_excerpt'] = max( 10, $input['max_num_of_words_in_excerpt'] );

		$new_input['read_more_label'] = NelioSRPSettings::DEFAULT_READ_MORE_LABEL;
		if( isset( $input['read_more_label'] ) )
			$new_input['read_more_label'] = sanitize_text_field( $input['read_more_label'] );
		if ( strlen( $new_input['read_more_label'] ) == 0 )
			$new_input['read_more_label'] = NelioSRPSettings::DEFAULT_READ_MORE_LABEL;

		// CACHE
		// ------------------------------------------------

		$new_input['cache_interval'] = NelioSRPSettings::DEFAULT_DAYS_FOR_CACHE;
		if( isset( $input['cache_interval'] ) )
			$new_input['cache_interval'] = absint( $input['cache_interval'] );
		$new_input['cache_interval'] = max( 1, $input['cache_interval'] );

		return $new_input;
	}

}

