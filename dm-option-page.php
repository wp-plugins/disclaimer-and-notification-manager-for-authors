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
<h2>Disclaimer Manager for Authors</h2>
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

				<h3><span>Disclaimer Message</span></h3>

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
									Enter <strong>Disclaimer</strong> Text for Guest Authors / Writers
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

				<h3><span>Disclaimer CSS Style-sheet</span></h3>

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
									The <strong>CSS Style</strong> for the Disclaimer Text
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

				<h3><span>Disclaimer Position</span></h3>

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
									Select the position where the <strong>Disclaimer Text</strong> will
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
									Checked Authors will have <strong>Disclaimer</strong> appear at their articles
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

			<h3><span>About Developer</span></h3>

			<div class="inside">
				Hi, I am Agbonghama Collins, developer of this plugin.<br/>
				Any question, shoot me an email at <strong>me@w3guy.com</strong>.
			</div>
			<!-- .inside -->

		</div>
		<!-- .postbox -->

	</div>
	<!-- .meta-box-sortables -->

</div>
<!-- #postbox-container-1 .postbox-container -->

</div>
<!-- #post-body .metabox-holder .columns-2 -->

<br class="clear">
</div>
<!-- #poststuff -->

</div> <!-- .wrap -->

