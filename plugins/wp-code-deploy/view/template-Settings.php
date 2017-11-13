<div class="wrap">

	<h1><?php echo __( "Settings" ); ?></h1>

	<hr class="wp-header-end">

	<form action="" id="wpcd_settings_form" method="POST">

		<h2><?php echo __( "Local Git User" ); ?></h2>
		<table class="form-table">
			
			<tbody>
				
				<tr>
					<th scope="row">
						<label for="wpcd_user_name"><?php echo __( "Git User Name" ); ?><b>*</b></label>
					</th>

					<td>
						<input type="text" class="wpcd_input regular-text" id="wpcd_user_name" name="wpcd_user_name" value="<?php echo get_option( "_wpcd_username_username" ); ?>">
						<p class="description"><?php echo __( "Your Git username" )?></p>
					</td>
				</tr>

				<tr>
					<th scope="row">
						<label for="wpcd_user_email"><?php echo __( "Git User Email" ); ?><b>*</b></label>
					</th>
					<td>
						<input type="email" class="wpcd_input regular-text" id="wpcd_user_email" name="wpcd_user_email" value="<?php echo get_option( "_wpcd_username_useremail" ); ?>">
						<p class="description"><?php echo __( "Your Git email" )?></p>
					</td>
				</tr>

				<tr>
					<td colspan="2">
						<input type="submit" class="wpcd_submit button button-primary button-large" id="save_user_data"value="Save User">
					</td>
				</tr>

			</tbody>

		</table>

		<h2><?php echo __( "SSH Keys" ); ?></h2>
		<table class="form-table">
	
			<tbody>
	
				<tr>
					<th scope="row">
						<label for="wpcd_public_key"><?php echo __( "Public RSA Key" ); ?><b>*</b></label>
					</th>
					<td>
						<textarea class="wpcd_textarea large-text code" rows="10" cols="50" name="wpcd_public_key" id="wpcd_public_key" readonly="true"><?php echo $public; ?></textarea>
						<p class="description"><?php echo __( "Your public ssh key" )?></p>
					</td>
				</tr>

				<tr>
					<th scope="row">
						<label for="wpcd_private_key"><?php echo __( "Private RSA Key" ); ?><b>*</b></label>
					</th>
					<td>
						<textarea class="wpcd_textarea large-text code" rows="10" cols="50" name="wpcd_private_key" id="wpcd_private_key" readonly="true"><?php echo $private; ?></textarea>
						<p class="description"><?php echo __( "Your private ssh key" )?></p>
					</td>
				</tr>

				<tr>
					<td colspan="<?php (  isset( $public ) && !empty( $public ) && isset( $private ) && !empty( $private )  )? "1" : "2"; ?>">
						<input type="submit" id="generate_keys" class="wpcd_submit button button-primary button-large" value="Generate Keys">
					</td>
					<?php if ( isset( $public ) && !empty($public) && isset( $private ) && !empty($private) ): ?>
						<td>
							<input type="submit" id="add_keys" class="wpcd_submit button button-primary button-large" value="Add SSH Keys">
						</td>
					<?php endif; ?>
				</tr>

			</tbody>

		</table>

	</form>

</div>