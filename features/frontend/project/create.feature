Feature: Project creation
    As a user
    I can create new projects
    So I can start translating it

    Scenario: A user creates a new project
        Given I am connected as "johndoe"
          And I am on "/projects/"

        Then I should see "Create a new project"

        When I follow "Create a new project"
          And I fill in the following:
            | Name           | Test |
            | Slug           | test |
            | Default locale | en   |
         And I press "Add"

        Then I should be on "/projects/test/"
         And I should see "Test"

    Scenario: An anonymous cannot create a project
        Given I am on "/projects/new"
         Then I should see "Login"

    Scenario: A user cannot create a project with a name already used
        Given I am connected as "johndoe"

         When I am on "/projects/new"
          And I fill in the following:
            | Name           | Tutorial |
            | Slug           | tutorial |
            | Default locale | en   |
          And I press "Add"

         Then I should see "This value is already used."
