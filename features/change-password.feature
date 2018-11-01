@db
Feature: Subscribers can change their password
  In order to keep my account secure
  As a logged in subscriber
  I can change my password using the frontend

  Background:
    Given there is a user:
      | user_login | user_pass   | user_email        | role       |
      | behat      | supersecret | behat@example.com | subscriber |
    And I am logged in as behat
    And I am on "/change-password/"

  Scenario: A "Change My Password" link is available in the menu
    When I follow "Change My Password"
    Then I should be on "/change-password/"

  Scenario: I can change my password
    When I fill in "Current Password" with "supersecret"
    And I fill in "New Password" with "somethingelse"
    And I press "Change Password"
    Then I should see "Your password has been changed"

  Scenario: I can't change my password if I don't know my current password
    When I fill in "Current Password" with "thewrongpassword"
    And I fill in "New Password" with "somethingelse"
    And I press "Change Password"
    Then I should see "Your password was not changed. Please check below for errors."
    And I should see "Incorrect password"
