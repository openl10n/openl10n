Feature: Delete locale from a project
    As a user
    I can delete a locale to a project

    Scenario: A user can delete a locale
        Given I am connected as "johndoe"
          And I am on "/projects/tutorial/languages/it_IT/delete"

        Then I should see "Are you sur you want to remove locale it_IT from project Tutorial?"

        When I press "Yes"
          And I should be on "/projects/tutorial/languages/"
          And the response should not contain "it_IT -"

    Scenario: A user cannot delete the project's default locale
        Given I am connected as "johndoe"
          And I am on "/projects/tutorial/languages/en/delete"
        Then I should see "You cannot remove locale en of project Tutorial"
