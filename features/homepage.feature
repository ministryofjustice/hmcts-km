Feature: Check the major homepage elements exist
  In order to have a consistent homepage interface
  As a HMCTS staff member (not logged in)
  I can see the homepage and everything is there I expect

  Scenario: I can see homepage knowlege articles/posts
    Given I go to the homepage
    #When I should see "Hello world!"
    And I should see "Knowledge article post"

    #Scenario: I can use the search
    #Given I go to the homepage
    #When I enter a search term
    #Then the search results load

    #Scenario: I can see tags
    #Given I go to the homepage
    #When I click on a tag
    #Then the tag search results load
