<?php

namespace PagaMasTarde\SeleniumFormUtils\Step;

use Facebook\WebDriver\WebDriverBy;

/**
 * Class ConfirmData
 *
 * @package PagaMasTarde\SeleniumFormUtils\Step
 */
class ConfirmData extends AbstractStep
{
    /**
     * Handler step
     */
    const STEP = '/confirm-data';

    /**
     * Pass from confirm-data to next step in Application Form
     *
     * @throws \Exception
     */
    public function run()
    {
        $this->validateStep(self::STEP);
        //Click on confirm:
        $confirmCheckbox = $this->webDriver->findElement(WebDriverBy::className('Form-checkboxSkin'));
        $confirmCheckbox->click();
        $formContinue = $this->webDriver->findElement(WebDriverBy::name('form-continue'));
        $formContinue->click();
    }
}
