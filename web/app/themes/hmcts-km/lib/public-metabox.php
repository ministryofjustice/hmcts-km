<?php

namespace Roots\Sage\Metaboxs;

/**
 * Register a meta box using a class.
 */

class Custom_Public_Meta_Box
{

  /**
   * Constructor.
   */
    public function __construct()
    {
        if (is_admin()) {
            add_action('load-post.php', array( $this, 'init' ));
            add_action('load-post-new.php', array( $this, 'init' ));
        }
    }

  /**
   * Meta box initialization.
   */
    public function init()
    {
        add_action('add_meta_boxes', array($this, 'add'));
        add_action('save_post', array($this, 'save'));
    }

  // this function add's the meta box
    public function add()
    {
        add_meta_box(
            'public-box',
            __('Public Text', 'textdomain'),
            array( $this, 'display' ),
            ['post','page'],
            'advanced',
            'default'
        );
    }

  // this renders the metabox to display on screen
    public function display($post)
    {


        $values = get_post_custom($post->ID);
      // Add nonce for security and authentication.
        wp_nonce_field('custom_nonce_action', 'custom_nonce');

        $public_value = get_post_meta($post->ID, '_public_editor', false);

        if (!empty($public_value) || !empty($welsh_value)) {
            $public_text = $public_value[0];
        } else {
            $public_text = '';
        }

        wp_editor($public_text, '_public_editor');
    }

  // this saves the data inputted by the user
    public function save($post_id)
    {
      // Add nonce for security and authentication.
        $nonce_name   = isset($_POST['custom_nonce']) ? $_POST['custom_nonce'] : '';
        $nonce_action = 'custom_nonce_action';

      // Check if nonce is valid.
        if (! wp_verify_nonce($nonce_name, $nonce_action)) {
            return;
        }

      // Check if user has permissions to save data.
        if (! current_user_can('edit_post', $post_id)) {
            return;
        }

      // Check if not an autosave.
        if (wp_is_post_autosave($post_id)) {
            return;
        }

      // Check if not a revision.
        if (wp_is_post_revision($post_id)) {
            return;
        }

      // OK, we're authenticated: we need to find and save the data
        if (isset($_POST['_public_editor'])) {
            update_post_meta($post_id, '_public_editor', $_POST['_public_editor']);
        }
    }
}

new Custom_Public_Meta_Box();
