Feature: Project locales list

    Scenario: User looks at project locales list
        Given I am connected as "john"
          And I am on "/projects/tutorial/languages/"

         Then I should see "(en)"
          And I should see "(fr_FR)"
