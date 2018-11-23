<?php

namespace Roots\Sage\Emails;

/**
 * Email Addresses
 */
$GLOBALS['valid_domains'] = [
  'hmcts.net',
  'justice.gov.uk',
  'digital.justice.gov.uk',
];

// Allow Login Only from gov email addresses
function is_valid_email_domain($login, $email, $errors)
{
  $valid = false; // sets default validation to false
  foreach ($GLOBALS['valid_domains'] as $d) {
    $d_length = strlen($d);
    $current_email_domain = strtolower(substr($email, -($d_length), $d_length));
    if ($current_email_domain == strtolower($d)) {
      $valid = true;
      break;
    }
  }
  // Return error message for invalid domains
  if ($valid === false) {
    $errors->add('domain_whitelist_error', __('<strong>ERROR</strong>: Login is only allowed from .gov emails. If you think you are seeing this in error, please contact the Intranet Team.'));
  }
}

add_action('register_post', 'is_valid_email_domain', 10, 3);
add_action('registration_errors', 'is_valid_email_domain', 10, 3);
