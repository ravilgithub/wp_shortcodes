<div class="form-field briz-meta-checkbox-wrap">
	<span class="briz-meta-title">
		<?php _e( $params[ 'title' ] ); ?>
	</span>

	<!--
		Если checkbox'ы не выбраны то в $_POST будет пустое поле,
		что позволит удалить его из БД.
	-->
	<input type="hidden" name="<?php echo $key; ?>" value="">

	<?php foreach ( $params[ 'options' ] as $k => $v ) : ?>
		<label>
			<input
				name="<?php echo $key . '[]'; ?>"
				type="checkbox"
				value="<?php echo $k; ?>"
				<?php checked( true, in_array( $k, (array) $value ) ); ?>
			/>
			<?php echo $v; ?>
		</label>
	<?php endforeach; ?>

	<p class="description">
		<?php _e( $params[ 'desc'] ); ?>
	</p>
</div>
