<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">

  <label class="sr-only"><?php _e( 'Search for:', 'sage' ); ?></label>
  <div class="input-group">
	<input type="search" value="<?php echo get_search_query(); ?>" name="s" class="search-field form-control" placeholder="<?php _e( 'Search articles...', 'sage' ); ?>" required>
	<div class="input-group">
		<?php

		wp_dropdown_categories(
			[
				'show_option_all' => 'All posts',
				'orderby'         => 'name',
				'echo'            => 1,
				'selected'        => $cat,
				'hierarchical'    => true,
				'query_var'       => true,
				'class'           => 'dropdown-menu',
				'id'              => 'custom-cat-drop',
				'value_field'     => 'term_id',
			]
		);

		?>
	</div>
	<span class="input-group-btn">
	  <button type="submit" class="search-submit btn btn-default"><?php _e( 'Search', 'sage' ); ?></button>
	</span>
  </div>
</form>
