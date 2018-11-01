@db
Feature: Subscribers can login after having changed their password
  In order to login to my account, after I've changed my password
  As a subscriber
  I can login using my new password

  Background:
    Given there is a user:
      | user_login | user_pass   | user_email        | role       |
      | behat      | supersecret | behat@example.com | subscriber |
    And I am logged in as behat
    And I am on "/change-password/"
    And I fill in "Current Password" with "supersecret"
    And I fill in "New Password" with "somethingelse"
    And I press "Change Password"
    And I should see "Your password has been changed"
    And I reset my session

  Scenario: I can login using my new password
    When I fill in "Username or Email Address" with "behat"
    And I fill in "Password" with "somethingelse"
    And I press "Log In"
    Then I should be logged in

  Scenario: I cannot login using my old password
    Then I should not be able to log in as behat
