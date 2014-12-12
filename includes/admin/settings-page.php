<?php

class NelioSRPSettingsPage {
	/**
	 * Holds the values to be used in the fields callbacks
	 */
	private $options;

	/**
	 * Start up
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'page_init' ) );
	}

	/**
	 * Add options page
	 */
	public function add_plugin_page() {
		// This page will be under "Settings"
		add_theme_page(
			__( 'Nelio Related Posts', 'neliosrp' ),
			__( 'Related Posts', 'neliosrp' ),
			'manage_options',
			'neliosrp-settings',
			array( $this, 'create_admin_page' )
		);
	}

	/**
	 * Options page callback
	 */
	public function create_admin_page() {
		// Set class property
		$this->options = NelioSRPSettings::get_settings();
		?>
		<div class="wrap">
			<?php screen_icon(); ?>
			<h2><?php _e( 'Nelio Related Posts (powered by Swiftype)', 'neliosrp' ); ?></h2>
			<br />
			<form method="post" action="options.php">
			<?php
				// This prints out all hidden setting fields
				settings_fields( 'neliosrp_settings_group' );
				do_settings_sections( 'neliosrp-settings' );
				submit_button();
			?>
			</form>
		</div>
		<?php
	}

	/**
	 * Register and add settings
	 */
	public function page_init() {

		register_setting(
			'neliosrp_settings_group',
			'neliosrp_settings',
			array( 'NelioSRPSettings', 'sanitize' )
		);

		add_settings_section(
			'rel_posts_section',
		// ================================================================
			__( 'Related Posts', 'neliosrp' ),
		// ================================================================
			array( $this, 'print_section_info' ),
			'neliosrp-settings'
		);

		add_settings_field(
			'max_num_of_rel_posts',
			__( 'Number of Related Posts', 'neliosrp' ),
		// ----------------------------------------------------------------
			array( $this, 'max_num_of_rel_posts_callback' ),
			'neliosrp-settings',
			'rel_posts_section'
		);

		add_settings_field(
			'use_excerpt',
			__( 'Use Excerpt (if available)', 'neliosrp' ),
		// ----------------------------------------------------------------
			array( $this, 'use_excerpt_callback' ),
			'neliosrp-settings',
			'rel_posts_section'
		);

		add_settings_field(
			'max_num_of_words_in_excerpt',
			__( 'Words in Excerpt', 'neliosrp' ),
		// ----------------------------------------------------------------
			array( $this, 'max_num_of_words_in_excerpt_callback' ),
			'neliosrp-settings',
			'rel_posts_section'
		);

		add_settings_field(
			'read_more_label',
			__( 'Label for Read More', 'neliosrp' ),
		// ----------------------------------------------------------------
			array( $this, 'read_more_label_callback' ),
			'neliosrp-settings',
			'rel_posts_section'
		);

		add_settings_section(
			'cache_section',
		// ================================================================
			__( 'Cache', 'neliosrp' ),
		// ================================================================
			array( $this, 'print_section_info' ),
			'neliosrp-settings'
		);

		add_settings_field(
			'cache_interval',
			__( 'Update Interval (days)', 'neliosrp' ),
			array( $this, 'cache_interval_callback' ),
			'neliosrp-settings',
			'cache_section'
		);

	}

	public function print_section_info() {
	}

	public function max_num_of_rel_posts_callback() {
		printf(
			'<input type="text" id="max_num_of_rel_posts" name="neliosrp_settings[max_num_of_rel_posts]" value="%s" placeholder="%s" />',
			NelioSRPSettings::get_max_num_of_rel_posts(),
			NelioSRPSettings::DEFAULT_NUM_OF_REL_POSTS
		);
	}

	public function use_excerpt_callback() { ?>
		<input type="checkbox" id="use_excerpt" name="neliosrp_settings[use_excerpt]" <?php
			checked( NelioSRPSettings::use_excerpt_if_available() );
		?> /><?php
	}

	public function max_num_of_words_in_excerpt_callback() {
		printf(
			'<input type="text" id="max_num_of_words_in_excerpt" name="neliosrp_settings[max_num_of_words_in_excerpt]" value="%s" placeholder="%s" />',
			NelioSRPSettings::get_max_num_of_words_in_excerpt(),
			NelioSRPSettings::DEFAULT_NUM_OF_WORDS_IN_EXCERPT
		);
	}

	public function read_more_label_callback() {
		printf(
			'<input type="text" id="read_more_label" name="neliosrp_settings[read_more_label]" value="%s" placeholder="%s" />',
			NelioSRPSettings::get_read_more_label(),
			NelioSRPSettings::DEFAULT_READ_MORE_LABEL
		);
	}

	public function cache_interval_callback() {
		printf(
			'<input type="text" id="cache_interval" name="neliosrp_settings[cache_interval]" value="%s" placeholder="%s" />',
			NelioSRPSettings::get_refresh_cache_interval_in_days(),
			NelioSRPSettings::DEFAULT_DAYS_FOR_CACHE
		);
	}

}

if ( is_admin() )
	$my_settings_page = new NelioSRPSettingsPage();

