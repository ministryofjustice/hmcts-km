<?php
/**
 * Template Name: Change Password
 */

/**
 * @param string $message Error message to show
 */
function form_error($message)
{
    ?>
    <div class="help-block">
        <div class="text-danger">
            <?= $message ?>
        </div>
    </div>
    <?php
}

/**
 * Get the input value to use for the specified field.
 * Use this to pre-populate form inputs with field data that was submitted by the user.
 *
 * @param string $name The field name
 * @return string Value for field input
 */
function input_value($name)
{
    global $form;

    if (isset($_POST[$name]) && $form['success'] == false) {
        return esc_attr($_POST[$name]);
    } else {
        return '';
    }
}

/**
 * Conditionally return the 'has-error' class if the specified field has errors.
 * If the field doesn't have errors, return an empty string.
 *
 * @param string $name The field name
 * @return string
 */
function field_error_class($name)
{
    global $form;

    if (isset($form['errors'][$name])) {
        return 'has-error';
    } else {
        return '';
    }
}

?>
<article <?php post_class('entry'); ?>>
    <div class="entry-wrapper">
        <header>
            <h1 class="entry-title">Change My Password</h1>
        </header>
        <div class="entry-content">
            <div class="well">
                <p>Change the password you use to log in to your IMB Members account.</p>

                <form action="<?= esc_url(get_the_permalink()) ?>" method="post" class="form-horizontal change-password-form">
                    <?php

                    if (isset($form)) {
                        if ($form['success']) {
                            ?>
                            <div class="alert alert-success" role="alert">
                                <i class="glyphicon glyphicon-ok"></i>
                                Your password has been changed
                            </div>
                            <?php
                        } else {
                            ?>
                            <div class="alert alert-danger" role="alert">
                                <i class="glyphicon glyphicon-alert"></i>
                                Your password was not changed.
                                <?php if (!empty($form['errors'])) : ?>
                                    Please check below for errors.
                                <?php else : ?>
                                    Please try again.
                                <?php endif; ?>
                            </div>
                            <?php
                        }
                    }

                    ?>
                    <?php wp_nonce_field('change-password', 'password_nonce', false); ?>
                    <div class="form-group">
                        <label for="current_password" class="col-sm-3 control-label">Email Address</label>
                        <div class="col-sm-9">
                            <p class="form-control-static">
                                <?= wp_get_current_user()->user_email ?>
                            </p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="current_password" class="col-sm-3 control-label">Current Password</label>
                        <div class="col-sm-9">
                            <div class="input-append input-group password-field <?= field_error_class('password') ?>">
                                <input id="current_password" name="password" class="form-control" type="password" required value="<?= input_value('password') ?>">
                            </div>
                            <?php
                            if (isset($form['errors']['password'])) {
                                form_error($form['errors']['password']);
                            }
                            ?>
                            <div class="help-block">The password you currently log in with</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="new_password" class="col-sm-3 control-label">New Password</label>
                        <div class="col-sm-9">
                            <div class="input-append input-group password-field <?= field_error_class('new_password') ?>">
                                <input id="new_password" name="new_password" class="form-control" type="password" required value="<?= input_value('new_password') ?>">
                            </div>
                            <?php
                            if (isset($form['errors']['new_password'])) {
                                form_error($form['errors']['new_password']);
                            }
                            ?>
                            <div class="help-block">Choose a new password</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-9">
                            <button type="submit" class="btn btn-primary">Change Password</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</article>
