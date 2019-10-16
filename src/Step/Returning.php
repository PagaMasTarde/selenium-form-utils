<?php

namespace Pagantis\SeleniumFormUtils\Step;

use Facebook\WebDriver\WebDriverBy;

/**
 * Class Returning
 *
 * @package Pagantis\SeleniumFormUtils\Step
 */
class Returning extends AbstractStep
{
    /**
     * Handler step
     */
    const STEP = 'Returning';

    /**
     * Return to shop without make a purchase
     *
     * @param bool $rejected
     * @throws \Exception
     */
    public function run($rejected = false)
    {
        $this->validateStep(self::STEP);
        //Click on confirm:
        $expiration = $this->webDriver->findElement(WebDriverBy::id('expireDate'));
        $expiration->clear()->sendKeys('12'. date('y'));
        $this->moveToParent();
        $formContinue = $this->webDriver->findElement(WebDriverBy::name('one_click_expiration_date_confirm'));
        $formContinue->click();
    }
}
