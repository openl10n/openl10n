Feature: Translation file export

    Scenario: A user can export translation file
        Given I am connected as "johndoe"
          And I am on "/projects/tutorial/export"
         Then I should see "Export translations"
