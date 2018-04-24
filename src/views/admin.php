<div class="wrap">
	<h2><?php echo esc_html__( 'Features', 'features' ); ?></h2>

	<?php if ( $description = apply_filters( 'features_description', '' ) ): ?>
		<p><?php echo esc_html( $description ); ?></p>
	<?php endif; ?>

	<?php if ( empty( $features ) ): ?>
		<p><?php echo esc_html__( 'No features exists, try to add some!', 'features' ); ?></p>
	<?php else: ?>
		<form method="post" action="options-general.php?page=features" novalidate="novalidate">
			<?php wp_nonce_field( 'features_update', 'features_nonce' ); ?>
			<table class="form-table">
				<tbody>
					<?php foreach ( $features as $key => $value ): ?>
					<tr>
						<th scope="row"><?php echo esc_html( isset( $labels[$key] ) ? $labels[$key] : $key ); ?></th>
						<td>
							<fieldset>
								<legend class="screen-reader-text"><span><?php echo esc_html( $key ); ?></span></legend>
								<label for="features[<?php echo esc_attr( $key ); ?>]">
									<input name="features[<?php echo esc_attr( $key ); ?>]" type="hidden" value="0" />
									<input name="features[<?php echo esc_attr( $key ); ?>]" type="checkbox" id="feature_<?php echo esc_attr( $key ); ?>" value="1" <?php checked( $value, true ); ?>>
									<?php echo esc_html__( 'Enable', 'features' ); ?>
								</label>
							</fieldset>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			<p class="submit">
				<input type="submit" name="submit" id="submit" class="button button-primary" value="<?php echo esc_html__( 'Save Changes', 'features' ); ?>">
			</p>
		</form>
	<?php endif; ?>
</div>
