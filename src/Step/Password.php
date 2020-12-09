<?php

namespace Pagantis\SeleniumFormUtils\Step;

use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Clearpay\Clearpay\Test\ClearpayMagentoTest;

/**
 * Class Password
 *
 * @package Clearpay\SeleniumFormUtils\Step
 */
class Password extends AbstractStep
{
    /**
     * Handler step
     */
    const STEP = 'Password';

    const PASSWORD = 'P4gantis$';

    /**
     * Default message for errors
     */
    const ERROR = 'Parece que no ha funcionado';

    /**
     * First step Confirm retrieved data
     *
     * @param bool $rejected
     * @return bool
     * @throws \Exception
     */
    public function run($rejected = false)
    {
        //Wait after redirection
        $simulatorElementSearch = WebDriverBy::name('password');
        $condition  = WebDriverExpectedCondition::presenceOfElementLocated($simulatorElementSearch);
        $this->webDriver->wait()->until($condition);

        //Fill email
        $fillEmail = $this->webDriver->findElement($simulatorElementSearch)->clear()->sendKeys(self::PASSWORD);

        //Click on confirm
        $formContinue = $this->webDriver->findElement(WebDriverBy::id('continueBtn'));
        $formContinue->click();

        sleep(5);

        return true;
    }
}
