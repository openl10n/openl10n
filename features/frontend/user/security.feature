Feature: A user must be logged

    Scenario: Homepage should lead to login
        Given I am on "/"
         Then I should be on "/login"
