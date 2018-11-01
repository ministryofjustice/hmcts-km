Feature: The WordPress dashboard is only accessible to admins
  In order to maintain a consistent user interface
  As a subscriber (IMB Member)
  I cannot access the WordPress dashboard

  Scenario: Admins can access wp-admin
    Given I am logged in as an admin
    When I go to wp-admin
    Then I should be on the "Dashboard" screen

  Scenario: Subscribers are redirected to the homepage
    Given I am logged in as a subscriber
    When I go to "/wp-admin/"
    Then the URL should match "^/$"
    And I should see "Latest News"
    And I should not see "Dashboard"

  Scenario: Admins should see the admin toolbar on the frontend
    Given I am logged in as an admin
    When I go to the homepage
    Then I should see the admin toolbar

  Scenario: Subscribers should not see the admin toolbar
    Given I am logged in as a subscriber
    When I go to the homepage
    Then I should not see the admin toolbar
