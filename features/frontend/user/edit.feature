Feature: User edition
    As a user
    I can edit my settings

    Scenario: A user can edit his information
        Given I am connected as "johndoe"
         When I am on "/settings/"
          And I fill in the following:
            | Display name      | Mister X            |
            | Prefered language | it_IT               |
            | Email             | misterx@example.org |
          And I press "Update"
         Then I should be on "/projects/"
         When I am on "/profile/johndoe"
          And I should see "Mister X"
          And the response should contain "it_IT"
          And I should see "misterx@example.org"
          And I should see "johndoe"
