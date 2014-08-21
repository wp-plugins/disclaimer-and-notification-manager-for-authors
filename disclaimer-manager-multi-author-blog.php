<?php

/*
Plugin Name: Disclaimer and Notification Manager for Authors
Plugin URI: http://w3guy.com
Description: This plugin simplify the process of adding Diclaimers at the top or bottom of an article written by a guest contributor.
Version: 1.0
Author: Agbonghama Collins
Author URI: http://w3guy.com
*/


require_once 'dm-meta-box.php';


class Disclaimer_Manager {

	static $instance;

	/**
	 * hook all actions and filters
	 */
	public function __construct() {
		add_action(
			'admin_menu',
			array(
				$this,
				'plugin_submenu_dashobard'
			) );

		add_action(
			'wp_enqueue_scripts',
			array(
				$this,
				'enqueue_css_stylesheet'
			) );

		register_activation_hook( __FILE__, array( $this, 'default_settings_on_activation' ) );
	}

	function default_settings_on_activation() {

		//get users array excluding admin for use as default option
		$users_object = get_users( array( 'fields' => array( 'user_login' ), 'exclude' => 1 ) );

		$all_users_exclude_admin = array();
		foreach ( $users_object as $key ) {
			$all_users_exclude_admin[] = $key->user_login;
		}


		$disclaimer_manager_options = array(
			'disclaimer_text'        => '&lt;div class="disclaimer-text"&gt;
	&lt;p&gt;This post was written by &lt;strong&gt;%first_name% %last_name%&lt;/strong&gt;.&lt;/p&gt;

	&lt;p&gt;The views expressed here belong to the author and do not necessarily reflect our views and opinions.&lt;/p&gt;
&lt;/div&gt;',

			'disclaimer_css'         => '.disclaimer-text {
    border-top: 1px solid #D2D2D2;
    border-bottom: 1px solid #D2D2D2;
    margin-top: 4px 1px;
    background-color: #FFFFCC;
}',

			'disclaimer_position'    => 'bottom',

			'author_with_disclaimer' => $all_users_exclude_admin,
		);

		update_option( 'dm_disclaimer_manager', $disclaimer_manager_options );
	}

	function plugin_submenu_dashobard() {

		add_users_page( 'Disclaimer', 'Disclaimer Manager', 'manage_options', 'dislcaimer-manager-w3guy', array(
			$this,
			'dmmb_option_page_function'
		) );
	}

	function dmmb_option_page_function() {

		require_once 'dm-option-page.php';
		self::save_plugin_option( @$_POST['dm_disclaimer_manager'] );
	}

	static function save_plugin_option( $form_post_data ) {

		if ( isset( $_POST['general_settings_submit'] ) && check_admin_referer( 'dm_disclaimer_settings_nonce', '_wpnonce' ) ) {

			$option_data = array();

			foreach ( $form_post_data as $key => $value ) {
				if ( $key == 'disclaimer_text' ) {
					$option_data['disclaimer_text'] = esc_attr( stripslashes( $value ) );
					continue;
				}

				if ( $key == 'author_with_disclaimer' ) {
					$option_data['author_with_disclaimer'] = $value;
					continue;
				}
				$option_data[ $key ] = esc_attr( $value );

			}

			update_option( 'dm_disclaimer_manager', $option_data );

			$css_file_handle = fopen( plugin_dir_path( __FILE__ ) . 'dm-disclaimer-manager.css', 'w+' );
			fwrite( $css_file_handle, $option_data['disclaimer_css'] );
			fclose( $css_file_handle );

			// redirect with added query string after submission
			wp_redirect( add_query_arg( 'settings-update', 'true' ) );
		}
	}


	function enqueue_css_stylesheet() {
		wp_enqueue_style( 'disclaimer-manager', plugin_dir_url( __FILE__ ) . 'dm-disclaimer-manager.css' );

	}

	static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}
}

Disclaimer_Manager::get_instance();