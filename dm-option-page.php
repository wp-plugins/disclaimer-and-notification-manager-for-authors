<style>
	input[type='text'], textarea, select {
		width: 400px;
	}

	.disclaimer-authors {
		max-height: 400px;
		overflow-y: scroll;
	}

	.spanz {
		padding: 5px;

		display: -moz-inline-stack;
		display: inline-block;
		*display: inline;
	}

	#welcome_message_type:target {
		background-color: #e5eecc;
		border: 2px solid #d4d4d4;
		padding: 5px 10px;
	}
</style>

<?php $dm_disclaimer_manager_data = get_option( 'dm_disclaimer_manager' ); ?>

<div class="wrap">

	<div id="icon-options-general" class="icon32"></div>
	<h2>Disclaimer and Notification Manager for Authors</h2>
	<?php if ( isset( $_GET['settings-update'] ) && $_GET['settings-update'] ) { ?>
		<div id="message" class="updated"><p><strong>Settings saved. </strong></p></div>
	<?php
	} ?>
	<div id="poststuff">

		<div id="post-body" class="metabox-holder columns-2">

			<!-- main content -->
			<div id="post-body-content">

				<div class="meta-box-sortables ui-sortable">
					<form method="post">
						<div class="postbox">

							<h3><span>Disclaimer / Notification Message</span></h3>

							<div class="inside">
								<table class="form-table">
									<tr>
										<th scope="row"><label for="dm_disclaimer_text">Disclaimer Text</label>
										</th>
										<td>
								<textarea class="widefat" rows="10"
								          name="dm_disclaimer_manager[disclaimer_text]"
								          id="dm_disclaimer_text"><?php echo isset( $dm_disclaimer_manager_data['disclaimer_text'] ) ? $dm_disclaimer_manager_data['disclaimer_text'] : ''; ?></textarea>

											<p class="description">
												Enter
												<strong>Disclaimer / Notification</strong> Text for Guest Authors / Writers
											</p>

											<p>You can also use the following placeholders: <br/>
												<strong>%username%</strong>&nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;Username of
												Author. <br/>
												<strong>%first_name%</strong>&nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;Author's
												First-name. <br/>
												<strong>%last_name%</strong>&nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;Author's
												Last-name. <br/>

											</p>
										</td>
										</td>


									</tr>

								</table>
								<p>
									<?php wp_nonce_field( 'dm_disclaimer_settings_nonce' ); ?>
									<input class="button-primary" type="submit" name="general_settings_submit"
									       value="Save All Changes">
								</p>
							</div>
							<!-- .inside -->

						</div>
						<!-- .postbox -->
						<div class="postbox">

							<h3><span>Disclaimer / Notification CSS</span></h3>

							<div class="inside">
								<table class="form-table">
									<tr>
										<th scope="row"><label for="dm_disclaimer_css">CSS Style</label>
										</th>
										<td>
								<textarea class="widefat" rows="10"
								          name="dm_disclaimer_manager[disclaimer_css]"
								          id="dm_disclaimer_css"><?php echo isset( $dm_disclaimer_manager_data['disclaimer_css'] ) ? $dm_disclaimer_manager_data['disclaimer_css'] : ''; ?></textarea>

											<p class="description">
												The <strong>CSS Style</strong> for the Disclaimer / Notification Text
											</p>
										</td>


									</tr>

								</table>
								<p>
									<?php wp_nonce_field( 'dm_disclaimer_settings_nonce' ); ?>
									<input class="button-primary" type="submit" name="general_settings_submit"
									       value="Save All Changes">
								</p>
							</div>
							<!-- .inside -->

						</div>

						<div class="postbox">

							<h3><span>Disclaimer / Notification Position</span></h3>

							<div class="inside">
								<table class="form-table">
									<tr>
										<th scope="row">Text Position</th>
										<td>
											<select name="dm_disclaimer_manager[disclaimer_position]">
												<option
													value="top" <?php isset( $dm_disclaimer_manager_data['disclaimer_position'] ) ? selected( $dm_disclaimer_manager_data['disclaimer_position'], 'top' ) : '' ?>>
													Top
												</option>
												<option
													value="middle" <?php isset( $dm_disclaimer_manager_data['disclaimer_position'] ) ? selected( $dm_disclaimer_manager_data['disclaimer_position'], 'middle' ) : '' ?>>
													Middle
												</option>
												<option
													value="bottom" <?php isset( $dm_disclaimer_manager_data['disclaimer_position'] ) ? selected( $dm_disclaimer_manager_data['disclaimer_position'], 'bottom' ) : '' ?>>
													Bottom
												</option>
											</select>


											<p class="description">
												Select the position where the
												<strong>Disclaimer / Notification Text</strong> will
												display in an Article or Post</p>


									</tr>

								</table>
								<p>
									<?php wp_nonce_field( 'dm_disclaimer_settings_nonce' ); ?>
									<input class="button-primary" type="submit" name="general_settings_submit"
									       value="Save All Changes">
								</p>
							</div>
							<!-- .inside -->

						</div>


						<div class="postbox">

							<h3><span>Guest Authors</span></h3>

							<div class="inside">
								<table class="form-table">
									<?php $disclaimer_authors = $dm_disclaimer_manager_data['author_with_disclaimer'] ?>
									<tr>
										<th scope="row">Authors with Disclaimers</th>
										<td>
											<?php $all_authors = get_users( array( 'fields' => array( 'user_login' ) ) ); ?>

											<div class="disclaimer-authors">
												<?php foreach ( $all_authors as $instance ) { ?>
													<span class="spanz">
											<input type="checkbox"
											       name="dm_disclaimer_manager[author_with_disclaimer][]"
											       value="<?php echo $instance->user_login; ?>" <?php echo in_array( $instance->user_login, $disclaimer_authors ) ? 'checked' : ''; ?>> <?php echo $instance->user_login; ?>
										</span>
												<?php } ?>
											</div>

											<p class="description">
												Checked Authors will have
												<strong>Disclaimer / Notification</strong> appear at their articles
											</p>
										</td>


									</tr>

								</table>
								<p>
									<?php wp_nonce_field( 'dm_disclaimer_settings_nonce' ); ?>
									<input class="button-primary" type="submit" name="general_settings_submit"
									       value="Save All Changes">
								</p>
							</div>
							<!-- .inside -->

						</div>

					</form>


				</div>
				<!-- .meta-box-sortables .ui-sortable -->

			</div>
			<!-- post-body-content -->

			<!-- sidebar -->
			<div id="postbox-container-1" class="postbox-container">

				<div class="meta-box-sortables">

					<div class="postbox">
						<div class="handlediv"><br></div>
						<h3 class="hndle" style="text-align: center;">
							<span><?php _e( 'Developer', 'wc-no-captcha' ); ?></span>
						</h3>

						<div class="inside">
							<div style="text-align: center; margin: auto">Made with lots of love by <br> <a
									href="http://w3guy.com"><strong>Agbonghama Collins</strong></a></div>
						</div>
					</div>

					<div class="postbox" style="text-align: center">
						<div class="handlediv"><br></div>
						<h3 class="hndle ui-sortable-handle"><span>ProfilePress Plugin</span></h3>

						<div class="inside">
							<p>A shortcode based WordPress form builder that makes building custom login, registration and password reset forms stupidly simple.</p>
							<strong>Features</strong>
							<ul>
								<li>Unlimited front-end login forms</li>
								<li>Unlimited front-end registration forms</li>
								<li>Unlimited password reset forms.</li>
								<li>Automatic login after registration.</li>
								<li>Social Logins.</li>
								<li>Custom user redirect users after login & logout</li>
								<li>One-click widget creator.</li>
								<li>And lots more.</li>
								<li></li>
							</ul>
							<div><a href="https://wordpress.org/plugins/ppress/" target="_blank">
									<button class="button-primary" type="button">Download for Free</button>
								</a></div>
						</div>
					</div>

					<div class="inside">
						<div style="text-align: center; margin: auto">
							<p>
								Is this plugin useful for you? If so, please help support its ongoing development and improvement with a
								<a href="https://flattr.com/submit/auto?user_id=tech4sky&url=https%3A%2F%2Fwordpress.org%2Fplugins%2Fdisclaimer-and-notification-manager-for-authors-for-woocommerce/%2F" target="_blank">donation</a>.
							</p>

							<p>Or, if you are short on funds, there are other ways you can help out:</p>
							<ul>
								<li>Leave a positive review on the plugin's
									<a href="https://wordpress.org/support/view/plugin-reviews/disclaimer-and-notification-manager-for-authors">WordPress listing</a>
								</li>
								<li>Vote "Works" on the plugin's
									<a href="https://wordpress.org/plugins/disclaimer-and-notification-manager-for-authors/#compatibility" target="_blank">WordPress listing</a>
								</li>
								<li>
									<a href="http://twitter.com/home?status=I%20love%20this%20WordPress%20plugin!%20http://wordpress.org/plugins/disclaimer-and-notification-manager-for-authors/" target="_blank">Share your thoughts on Twitter</a>
								</li>
							</ul>
						</div>
					</div>
					<!-- .postbox -->

					<div class="postbox">

						<h3><span>My Blog Recent Updates</span></h3>

						<div class="inside">

							<?php // Get RSS Feed(s)
							include_once( ABSPATH . WPINC . '/feed.php' );

							// Get a SimplePie feed object from the specified feed source.
							$rss = fetch_feed( 'http://feeds.feedburner.com/tech4sky' );

							if ( ! is_wp_error( $rss ) ) : // Checks that the object is created correctly

								// Figure out how many total items there are, but limit it to 5.
								$maxitems = $rss->get_item_quantity( 5 );

								// Build an array of all the items, starting with element 0 (first element).
								$rss_items = $rss->get_items( 0, $maxitems );

							endif;
							?>

							<ul>
								<?php if ( $maxitems == 0 ) : ?>
									<li><?php _e( 'No items', 'my-text-domain' ); ?></li>
								<?php else : ?>
									<?php // Loop through each feed item and display each item as a hyperlink. ?>
									<?php foreach ( $rss_items as $item ) : ?>
										<li>
											<a href="<?php echo esc_url( $item->get_permalink() ); ?>"
											   title="<?php printf( __( 'Posted %s', 'my-text-domain' ), $item->get_date( 'j F Y | g:i a' ) ); ?>">
												<?php echo esc_html( $item->get_title() ); ?>
											</a>
										</li>
									<?php endforeach; ?>
								<?php endif; ?>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<br class="clear">
	</div>
</div>

