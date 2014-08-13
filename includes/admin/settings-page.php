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
			'Nelio Related Posts',
			'Related Posts',
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
			<h2>Nelio Related Posts (powered by Swiftype)</h2>		   
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
			'Related Posts',
		// ================================================================
			array( $this, 'print_section_info' ),
			'neliosrp-settings'
		);  

		add_settings_field(
			'section_title',
			'Section Title',
		// ----------------------------------------------------------------
			array( $this, 'section_title_callback' ),
			'neliosrp-settings',
			'rel_posts_section'
		);	  

		add_settings_field(
			'max_num_of_rel_posts',
			'Number of Related Posts',
		// ----------------------------------------------------------------
			array( $this, 'max_num_of_rel_posts_callback' ),
			'neliosrp-settings',
			'rel_posts_section'
		);	  

		add_settings_field(
			'use_excerpt',
			'Use Excerpt (if available)',
		// ----------------------------------------------------------------
			array( $this, 'use_excerpt_callback' ),
			'neliosrp-settings',
			'rel_posts_section'
		);	  

		add_settings_field(
			'max_num_of_words_in_excerpt',
			'Words in Excerpt',
		// ----------------------------------------------------------------
			array( $this, 'max_num_of_words_in_excerpt_callback' ),
			'neliosrp-settings',
			'rel_posts_section'
		);	  

		add_settings_field(
			'read_more_label', 
			'Label for Read More', 
		// ----------------------------------------------------------------
			array( $this, 'read_more_label_callback' ), 
			'neliosrp-settings', 
			'rel_posts_section'
		);	  


		add_settings_field(
			'two_columns', 
			'Two Columns', 
		// ----------------------------------------------------------------
			array( $this, 'two_columns_label_callback' ), 
			'neliosrp-settings', 
			'rel_posts_section'
		);	  


		add_settings_field(
			'auto_append', 
			'Location of Rel. Posts', 
		// ----------------------------------------------------------------
			array( $this, 'auto_append_label_callback' ), 
			'neliosrp-settings', 
			'rel_posts_section'
		);	  


		add_settings_section(
			'cache_section',
		// ================================================================
			'Cache',
		// ================================================================
			array( $this, 'print_section_info' ),
			'neliosrp-settings'
		);  

		add_settings_field(
			'cache_interval', 
			'Update Interval (days)', 
			array( $this, 'cache_interval_callback' ), 
			'neliosrp-settings', 
			'cache_section'
		);	  

	}

	public function print_section_info() {
	}

	public function section_title_callback() {
		printf(
			'<input type="text" id="section_title" name="neliosrp_settings[section_title]" value="%s" placeholder="%s" />',
			NelioSRPSettings::get_title(),
			NelioSRPSettings::DEFAULT_SECTION_TITLE
		);
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

	public function two_columns_label_callback() { ?>
		<input type="checkbox" id="two_columns" name="neliosrp_settings[two_columns]" <?php
			checked( NelioSRPSettings::use_two_columns() );
		?> /><?php
	}

	public function auto_append_label_callback() {
		$field_name = 'auto_append';
		printf(
			'<select id="%1$s" name="neliosrp_settings[%1$s]" style="width:100%;" value="%s">',
			$field_name,
			(NelioSRPSettings::append_to_content_automatically() ? '1':'0')
		);
		?>
			<option value='1'><?php _e( 'Append automatically after post\'s content', 'nelioab' ); ?></option>
			<option value='0'<?php
				if ( !NelioSRPSettings::append_to_content_automatically() )
					echo ' selected="selected"';
			?>><?php _e( 'Place manually in your theme', 'nelioab' ); ?></option>
		</select>
		<br><span id="<?php echo $field_name; ?>-descr" class="description"><?php
			_e( 'Edit your theme and call the following function from wherever you want the related posts to appear:<br><strong>neliosrp_the_related_posts();</strong>' );
		?></span>
		<script>
			jQuery(document).ready(function() {
				var change = function() {
					var option = jQuery("#<?php echo $field_name; ?>").attr('value');
					var descr = jQuery("#<?php echo $field_name; ?>-descr");
					if ( option == 0 ) descr.show();
					else descr.hide();
				};
				change();
				jQuery("#<?php echo $field_name; ?>").on("change", function() { change(); });
			});
		</script>
		<?php
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

?>
