<?php

use Behat\Behat\Context\BehatContext;
use Behat\MinkExtension\Context\MinkContext;
use Behat\Behat\Context\ClosuredContextInterface;
use Behat\Behat\Context\Step\When;
use Behat\Behat\Context\TranslatedContextInterface;
use Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

/**
 * Features context.
 */
class FeatureContext extends BehatContext
{
    /**
     * Initializes context.
     * Every scenario gets its own context object.
     *
     * @param array $parameters context parameters (set them up through behat.yml)
     */
    public function __construct(array $parameters)
    {
        $this->useContext('mink', new MinkContext());
    }

    /**
     * Login a user.
     *
     * @Given /^I am connected as "([^"]*)"$/
     */
    public function iAmConnectedAs($pseudo)
    {
        return array(
            new When('I am on "/login"'),
            new When('I fill in "Username" with "'.$pseudo.'"'),
            new When('I fill in "Password" with "'.$pseudo.'"'),
            new When('I press "Login"'),
        );
    }

    /**
     * Login a user with a specific password.
     *
     * @Given /^I am connected as "([^"]*)" with "([^"]*)"$/
     */
    public function iAmConnectedAsWith($username, $password)
    {
        return array(
            new When('I am on "/login"'),
            new When('I fill in "Username" with "'.$username.'"'),
            new When('I fill in "Password" with "'.$password.'"'),
            new When('I press "Login"'),
        );
    }
}
