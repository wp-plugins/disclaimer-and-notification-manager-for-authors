<?php

/**
 * The Class.
 */
class Disclaimer_Manager_Meta_Box {

	static $instance;

	/**
	 * Hook into the appropriate actions when the class is constructed.
	 */
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
		add_action( 'save_post', array( $this, 'save' ) );

		// add disclaimer to post content
		add_filter( 'the_content', array( $this, 'dispay_disclaimer_text' ) );
	}

	/**
	 * Adds the meta box container.
	 */
	public function add_meta_box() {
		add_meta_box(
			'disclaimer_manager',
			__( 'Disclaimer / Notification Manager', 'myplugin_textdomain' ),
			array( $this, 'render_meta_box_content' ),
			'post',
			'advanced',
			'high'
		);
	}


	public function save( $post_id ) {

		/*
		 * We need to verify this came from the our screen and with proper authorization,
		 * because save_post can be triggered at other times.
		 */

		// Check if our nonce is set.
		if ( ! isset( $_POST['disclaimer_manager_nonce'] ) ) {
			return $post_id;
		}

		$nonce = $_POST['disclaimer_manager_nonce'];

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $nonce, 'disclaimer_manager' ) ) {
			return $post_id;
		}

		// // If this is an autosave, our form has not been submitted,
		//  so we don't want to anything.

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}

		// Check the user's permissions.
		if ( 'page' == $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return $post_id;
			}

		} else {

			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return $post_id;
			}
		}

		/* OK, its safe for us to save the data now. */

		// Sanitize the user input.
		$disclaimer_text = esc_attr( $_POST['disclaimer_metabox_data'] );

		// Update the meta field.
		update_post_meta( $post_id, '_disclaimer_post_meta', $disclaimer_text );
	}


	/**
	 * Render Meta Box content.
	 *
	 * @param WP_Post $post The post object.
	 */
	public function render_meta_box_content( $post ) {

		$default_disclaimer_text = get_option( 'dm_disclaimer_manager' )['disclaimer_text'];

		// Add an nonce field so we can check for it later.
		wp_nonce_field( 'disclaimer_manager', 'disclaimer_manager_nonce' );

		// Use get_post_meta to retrieve an existing value from the database.
		$value = get_post_meta( $post->ID, '_disclaimer_post_meta', true );

		?>
		<textarea class="widefat" rows="6" name="disclaimer_metabox_data"
		          id="dm_disclaimer_css"><?php echo isset( $value ) ? $value : $default_disclaimer_text; ?></textarea>
		<p class="description" align="right">
			Disclaimer / Notification to be displayed at the end of Author's article or post.
		</p>
	<?php
	}

	/*
	 * add disclaimer to post content
	 */

	static function formatted_disclaimer_text() {
		global $post;


		// plugin db option
		$plugin_db_options = get_option( 'dm_disclaimer_manager' );

		// get author details
		$author_username   = get_the_author_meta( 'user_login' );
		$author_first_name = get_the_author_meta( 'first_name' );
		$author_last_name  = get_the_author_meta( 'last_name' );


		// get the disclaimer text for each post
		$metabox_post_disclaimer = get_post_meta( $post->ID, '_disclaimer_post_meta', true );

		// if metabox disclaimer is emty, use that of the plugin default settings
		$disclaimer_text = empty( $metabox_post_disclaimer ) ? $plugin_db_options['disclaimer_text'] : $metabox_post_disclaimer;

		// decode escaped / encoded html
		$disclaimer_text = htmlspecialchars_decode( $disclaimer_text );

		// replace placeholders with actual values
		$search  = array(
			'%username%',
			'%first_name%',
			'%last_name%'
		);
		$replace = array(
			$author_username,
			$author_first_name,
			$author_last_name
		);

		$formatted_disclaimer_text = str_replace( $search, $replace, $disclaimer_text );

		return $formatted_disclaimer_text;
	}

	function dispay_disclaimer_text( $content ) {
		global $post;


		$plugin_db_options = get_option( 'dm_disclaimer_manager' );


		// get formatted disclaimer text
		$disclaimer_text = self::formatted_disclaimer_text();

		$disclaimer_position = $plugin_db_options['disclaimer_position'];

		$authors_with_disclaimers = $plugin_db_options['author_with_disclaimer'];


		if ( in_array( get_the_author_meta( 'user_login' ), $authors_with_disclaimers ) ) {


			if ( $disclaimer_position == 'top' ) {

				$content = $disclaimer_text . $content;
			} elseif ( $disclaimer_position == 'middle' ) {
				$para_content = explode( '</p>', $content );
				$halfway_mark = ceil( count( $para_content ) / 2 );

				$first_half_content  = implode( '</p> ', array_slice( $para_content, 0, $halfway_mark ) );
				$second_half_content = implode( '</p> ', array_slice( $para_content, $halfway_mark ) );

				$content = $first_half_content . $disclaimer_text . $second_half_content;
			} elseif ( $disclaimer_position == 'bottom' ) {
				$content .= $disclaimer_text;

			}
		}

		return $content;

	}


	static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new Disclaimer_Manager_Meta_Box;
		}

		return self::$instance;
	}
}

Disclaimer_Manager_Meta_Box::get_instance();