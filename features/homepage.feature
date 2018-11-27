Feature: Check the major homepage elements exist
  In order to have a consistent homepage interface
  As a HMCTS staff member
  I can see the homepage and everything is there I expect

  Scenario: Staff member can see homepage post
    Given I go to the homepage
    When I should see "Hello world!"
    Then the URL should match "^/$"

  Scenario: Staff member can search
    Given I go to the homepage
    When I enter a search term
    Then the search results load

  Scenario: Staff member can see tags
    Given I go to the homepage
    When I click on a tag
    Then the tag search results load
