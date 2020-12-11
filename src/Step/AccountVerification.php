<?php

namespace Pagantis\SeleniumFormUtils\Step;

use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Clearpay\Clearpay\Test\ClearpayMagentoTest;

/**
 * Class AccountVerification
 *
 * @package Clearpay\SeleniumFormUtils\Step
 */
class AccountVerification extends AbstractStep
{
    /**
     * Handler step
     */
    const STEP = 'AccountVerification';

    const EMAIL = 'antonio@clearpay.com';

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
        $simulatorElementSearch = WebDriverBy::name('email');
        $condition  = WebDriverExpectedCondition::presenceOfElementLocated($simulatorElementSearch);
        $this->webDriver->wait()->until($condition);

        //Fill email
        $fillEmail = $this->webDriver->findElement($simulatorElementSearch)->clear()->sendKeys(self::EMAIL);

        //Click on confirm
        $formContinue = $this->webDriver->findElement(WebDriverBy::id('continueBtn'));
        $formContinue->click();

        sleep(5);

        return true;
    }
}
