Feature: Project locales list

    Scenario: User looks at project locales list
        Given I am connected as "john"
          And I am on "/projects/tutorial/languages/"

         Then the response should contain "en -"
          And the response should contain "fr_FR -"
