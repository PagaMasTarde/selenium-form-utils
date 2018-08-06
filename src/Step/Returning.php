<?php

namespace PagaMasTarde\SeleniumFormUtils\Step;

use Facebook\WebDriver\WebDriverBy;

/**
 * Class Returning
 *
 * @package PagaMasTarde\SeleniumFormUtils\Step
 */
class Returning extends AbstractStep
{
    /**
     * Handler step
     */
    const STEP = '/returning';

    /**
     * Pass from returning to next step in Application Form
     *
     * @throws \Exception
     */
    public function run()
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
