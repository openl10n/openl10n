Feature: Delete a user
    As a user
    I can delete my account

    Scenario: A user can delete a user
        Given I am connected as "user"
          And I am on "/settings/leave"
          Then I should see "Are you sur you want to remove your account?"
        When I press "Yes, delete my account"
          And I should be on "/login"
