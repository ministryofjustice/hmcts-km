<?php

namespace Roots\Sage\Metaboxs;

/**
 * Register a meta box using a class.
 */

class Custom_Meta_Box {

  /**
   * Constructor.
   */
  public function __construct() {
    if ( is_admin() ) {
      add_action( 'load-post.php',     array( $this, 'init' ) );
      add_action( 'load-post-new.php', array( $this, 'init' ) );
    }
  }

  /**
   * Meta box initialization.
   */
  public function init(){
    add_action( 'add_meta_boxes', array($this, 'add') );
    add_action( 'save_post', array($this, 'save') );
  }

  // this function add's the meta box
  public function add(){
    add_meta_box(
      'meta-box',
      __( 'Welsh Text', 'textdomain' ),
      array( $this, 'display' ),
      'post',
      'advanced',
      'default'
    );
  }

  // this renders the metabox to display on screen
  public function display($post){

    $values = get_post_custom( $post->ID );
    $text = isset( $values['meta_box_text'] ) ? $values['meta_box_text'] : '';

    // Add nonce for security and authentication.
    wp_nonce_field( 'custom_nonce_action', 'custom_nonce' );

    ?>
    <textarea name="meta_box_text" id="meta_box_text" rows="8" cols="80"><?php echo $text[0]; ?></textarea>
    <?php

  }

  // this saves the data inputted by the user
  public function save($post_id){
    // Add nonce for security and authentication.
    $nonce_name   = isset( $_POST['custom_nonce'] ) ? $_POST['custom_nonce'] : '';
    $nonce_action = 'custom_nonce_action';

    // Check if nonce is valid.
    if ( ! wp_verify_nonce( $nonce_name, $nonce_action ) ) {
      return;
    }

    // Check if user has permissions to save data.
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
      return;
    }

    // Check if not an autosave.
    if ( wp_is_post_autosave( $post_id ) ) {
      return;
    }

    // Check if not a revision.
    if ( wp_is_post_revision( $post_id ) ) {
      return;
    }

    // Make sure your data is set before trying to save it
    if( isset( $_POST['meta_box_text'] ) ){
      update_post_meta( $post_id, 'meta_box_text', wp_kses( $_POST['meta_box_text'], $allowed ) );
    }

  }

}

new Custom_Meta_Box();
