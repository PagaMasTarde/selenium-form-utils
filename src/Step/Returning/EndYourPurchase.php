<?php

namespace PagaMasTarde\SeleniumFormUtils\Step\Returning;

use Facebook\WebDriver\WebDriverBy;
use PagaMasTarde\SeleniumFormUtils\Step\AbstractStep;
use PagaMasTarde\SeleniumFormUtils\Step\ConfirmData\Missing;

/**
 * Class EndYourPurchase
 *
 * @package PagaMasTarde\SeleniumFormUtils\Step
 */
class EndYourPurchase extends AbstractStep
{
    /**
     * Handler step
     */
    const STEP = '/returning/end-your-purchase';

    /**
     * Pass from returning to next step in Application Form
     *
     * @throws \Exception
     */
    public function run()
    {
        $this->validateStep(self::STEP);
        //Click on confirm:
        $confirmCheckbox = $this->webDriver->findElement(WebDriverBy::className('Form-checkboxSkin'));
        $confirmCheckbox->click();
        $formContinue = $this->webDriver->findElement(WebDriverBy::name('one_click_buy'));
        $formContinue->click();
    }
}
