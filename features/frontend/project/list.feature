Feature: Project list

    Scenario: User looks at project list
        Given I am connected as "johndoe"
          And I am on "/projects"

         Then I should see "Tutorial"
          And I should see "Empty"
