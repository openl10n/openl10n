Feature: Project show

    Scenario: User sees domains on the project page
        Given I am connected as "johndoe"
          And I am on "/projects/tutorial"

         Then I should see "Basic"
          And I should see "Advanced"

    Scenario: User is invited to import file in an empty project
        Given I am connected as "johndoe"
          And I am on "/projects/empty"

         Then I should see "There is no translation yet in this project"
          And I should see "Import translations"
