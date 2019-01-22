<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">

  <label class="sr-only"><?php _e( 'Search for:', 'sage' ); ?></label>

  <div class="input-group">

	<input type="search" value="<?php echo get_search_query(); ?>" name="s" class="search-field form-control" placeholder="<?php _e( 'Search by keyword', 'sage' ); ?>">

    <div class="input-group-dropdown">
		<?php
		wp_dropdown_categories(
			[
				'show_option_all' => 'Pages and articles',
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
	  Or search by selecting a specific category.
    </div>

	<span class="input-group-btn">
	  <button type="submit" class="search-submit btn btn-default"><?php _e( 'Search', 'sage' ); ?></button>
	</span>

  </div>
</form>
