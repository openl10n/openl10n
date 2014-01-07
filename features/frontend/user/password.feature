Feature: Changing a user password
    As a user
    I can change my own password

    Scenario: A user can change my password
        Given I am connected as "johndoe"
          When I am on "/settings/password"
          And I fill in the following:
            | Old password      | johndoe  |
            | Password          | p@5swOrd |
            | Password (repeat) | p@5swOrd |
          And I press "Update"
          Then I should be on "/projects/"

    Scenario: A user can login with his new password
        Given I am connected as "johndoe" with "p@5swOrd"
          When I am on "/settings/password"
          And I fill in the following:
            | Old password      | p@5swOrd |
            | Password          | johndoe  |
            | Password (repeat) | johndoe  |
          And I press "Update"
          Then I should be on "/projects/"
