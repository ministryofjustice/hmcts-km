<?php
	global $post;
	$public_value = get_post_meta( $post->ID, '_public_editor', false );
	$welsh_value = get_post_meta( $post->ID, '_welsh_editor', false );
	if (!empty( $public_value ) || !empty( $welsh_value )){
		$public_text = $public_value[0];
		$welsh_text = $welsh_value[0];
	}else{
		$public_text = '';
		$welsh_text = '';
	}
?>
<article <?php post_class( 'entry' ); ?>>
	<div class="entry-wrapper">
		<header>
			<h1 class="entry-title"><?php the_title(); ?></h1>
			<?php get_template_part( 'templates/entry-meta' ); ?>
		</header>
		<div class="entry-content">
			<?php
				if(!empty(get_the_content())){
					echo '<div class="app-contact-panel private">';
					the_content();
					echo '</div>';
				}
			?>
		</div>
		<div class="entry-content">
			<?php
			if(!empty($public_text)){
				echo '<div class="app-contact-panel public">';
					echo '<h1>Advice for your customer</h1>';
					echo '<p>' . $public_text . '</p>';

				if(!empty($welsh_text)){
					echo '<a data-toggle="collapse" data-target="#welsh" class="btn-hidden_panel" >View this in Welsh</a>';
					echo '<div id="welsh" class="collapse app-contact-panel welsh">';
						echo $welsh_text ;
					echo '</div>';
				}

				echo '</div>';
			}
?>
<br />
<hr>
Article tagged as: <?php the_category(', '); ?>
		</div>

		<footer>
			<?php
			wp_link_pages(
				[
					'before' => '<nav class="page-nav"><p>' . __( 'Pages:', 'sage' ),
					'after'  => '</p></nav>',
				]
			);
?>
		</footer>
	</div>
</article>
