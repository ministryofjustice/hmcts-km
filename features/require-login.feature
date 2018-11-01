Feature: Require users to be logged in to view the site
  In order to view the website
  Users should be required to
  Login to their account

  Scenario: Anonymous users cannot view pages
    When I go to the homepage
    Then I should see "Username or Email Address"
    And the URL should match "wp-login\.php"
    And I should not see "Latest News"

  Scenario: A logged in user can view pages
    Given I am logged in as a subscriber
    When I go to the homepage
    Then I should see "Latest News"
    And I should see "Logout"
