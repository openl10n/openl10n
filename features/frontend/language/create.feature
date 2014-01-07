Feature: Add locale to a project
    As a user
    I can add new locale to a project
    So I can start translating for this locale

    Scenario: A user add a new locale to the project
        Given I am connected as "johndoe"
          And I am on "/projects/tutorial/languages/"

        When I follow "Add locale"
         And I fill in "Locale" with "fr_BE"
         And I press "Add"

        Then I should be on "/projects/tutorial/languages/"
         And the response should contain "fr_BE -"

    Scenario: A new project must have a default locale
        Given I am connected as "johndoe"
          And I am on "/projects/new"

        When I fill in the following:
            | Name           | Test new locale |
            | Slug           | test-new-locale |
            | Default locale | pt_BR           |
         And I press "Add"

        Then I should be on "/projects/test-new-locale/"

        When I am on "/projects/test-new-locale/languages/"
        Then the response should contain "pt_BR -"

    #Scenario: A user cannot add an existing locale
    #    Given I am connected as "johndoe"
    #      And I am on "/projects/tutorial/locales/new"
    #
    #    When I fill in "Locale" with "fr_FR"
    #     And I press "Add"
    #
    #    Then I should see "This value is already used."
