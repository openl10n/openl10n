Feature: Project administration
    As a user
    I can edit a project
    So I easily manage information of my project

    Scenario: A user can edit project information
        Given I am connected as "johndoe"
         When I am on "/projects/todelete/edit"
          And I fill in the following:
            | Name           | Delete Me |
            | Default locale | en        |
          And I press "Valid"
         Then I should be on "/projects/todelete/"
          And I should see "Delete Me"

    Scenario: A user can delete a project
        Given I am connected as "johndoe"
          And I am on "/projects/todelete/edit"
         Then I should see "Delete"

         When I follow "Delete"
          And I should see "Are you sur you want to delete the project"

         When I press "Yes"
          And I should be on "/projects/"
          And I should not see "To Delete"

