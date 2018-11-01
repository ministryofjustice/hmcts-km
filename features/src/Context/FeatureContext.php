<?php

namespace ImbMembers\Features\Context;

use Behat\Behat\Context\Context;
use Behat\Mink\Exception\DriverException;
use Behat\Mink\Exception\ExpectationException;
use PaulGibbs\WordpressBehatExtension\Context\RawWordpressContext;
use PaulGibbs\WordpressBehatExtension\Context\Traits\UserAwareContextTrait;

/**
 * Define application features from the specific context.
 */
class FeatureContext extends RawWordpressContext implements Context
{
    use UserAwareContextTrait;

    /**
     * Initialise context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the context constructor through behat.yml.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Reset the browser session and nagivate to the homepage after each scenario.
     *
     * Navigating to the homepage means the body element will no longer have a '.logged-in' class,
     * which is used by \PaulGibbs\WordpressBehatExtension\Context\Traits\UserAwareContextTrait to
     * determine if a user is logged in.
     *
     * @AfterScenario
     *
     * @When I reset my session
     */
    public function resetSessionAndGoToHomepage()
    {
        $this->getSession()->reset();
        $this->visitPath('/');
    }

    /**
     * @Then I should be logged in
     */
    public function iShouldBeLoggedIn()
    {
        return $this->loggedIn();
    }

    /**
     * @Then I should see the admin toolbar
     */
    public function iShouldSeeTheAdminToolbar()
    {
        try {
            $this->getElement('Toolbar')->getTagName();
        } catch (DriverException $e) {
            throw new ExpectationException(
                'The admin toolbar isn\'t on the page, but it should be.',
                $this->getSession()->getDriver()
            );
        }
    }

    /**
     * @Then I should not see the admin toolbar
     */
    public function iShouldNotSeeTheAdminToolbar()
    {
        try {
            $this->getElement('Toolbar')->getTagName();
        } catch (DriverException $e) {
            // Expectation fulfilled.
            return;
        }

        throw new ExpectationException(
            'The admin toolbar is on the page, but it shouldn\'t be.',
            $this->getSession()->getDriver()
        );
    }
}
