<?php
/**
 * Copyright 2013 Nelio Software S.L.
 * This script is distributed under the terms of the GNU General Public
 * License.
 *
 * This script is free software: you can redistribute it and/or modify it under
 * the terms of the GNU General Public License as published by the Free
 * Software Foundation, either version 3 of the License. This script is
 * distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
 * PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * this program. If not, see <http://www.gnu.org/licenses/>.
 */


/*
 * Plugin Name: Nelio Related Posts
 * Description: Get a list of Related Posts by querying your Swiftype account. If Swiftype is not available, it uses WordPress' regular search system.
 * Version: 2.1.1
 * Author: Nelio Software
 * Plugin URI: http://neliosoftware.com
 * Text Domain: neliosrp
 */

// ==========================================================================
// PLUGIN INFORMATION
// ==========================================================================
	define( 'NELIOSRP_PLUGIN_VERSION', '2.1.1' );
	define( 'NELIOSRP_PLUGIN_NAME', 'Nelio Related Posts' );
	define( 'NELIOSRP_PLUGIN_DIR_NAME', basename( dirname( __FILE__ ) ) );

// Defining a few important directories
	define( 'NELIOSRP_ROOT_DIR', rtrim( plugin_dir_path( __FILE__ ), '/' ) );
	define( 'NELIOSRP_DIR', NELIOSRP_ROOT_DIR . '/includes' );
	define( 'NELIOSRP_ADMIN_DIR', NELIOSRP_DIR . '/admin' );

// Some URLs...
	define( 'NELIOSRP_ASSETS_URL', plugins_url() . '/' . NELIOSRP_PLUGIN_DIR_NAME . '/assets' );

// i18n
function neliosrp_i18n() {
	load_plugin_textdomain( 'neliosrp', false, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );
}
add_action( 'plugins_loaded', 'neliosrp_i18n' );


// ==========================================================================
// INCLUDING CODE
// ==========================================================================
	require_once( NELIOSRP_DIR . '/settings.php' );

// ADMIN STUFF
	if ( is_admin() ) {
		require_once( NELIOSRP_ADMIN_DIR . '/nelioab-campaign.php' );
		require_once( NELIOSRP_ADMIN_DIR . '/settings-page.php' );
		require_once( NELIOSRP_ADMIN_DIR . '/edit-post.php' );
	}

// REGULAR STUFF
	require_once( NELIOSRP_DIR . '/utils.php' );
	require_once( NELIOSRP_DIR . '/nelio-srp-main.php' );
	require_once( NELIOSRP_DIR . '/widget.php' );

