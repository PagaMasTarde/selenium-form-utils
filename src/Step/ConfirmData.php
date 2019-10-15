<?php

namespace Pagantis\SeleniumFormUtils\Step;

use Facebook\WebDriver\WebDriverBy;

/**
 * Class ConfirmData
 *
 * @package Pagantis\SeleniumFormUtils\Step
 */
class ConfirmData extends AbstractStep
{
    /**
     * Handler step
     */
    const STEP = 'ConfirmData';

    /**
     * Pass from confirm-data to next step in Application Form
     *
     * @throws \Exception
     */
    public function run()
    {
        $this->validateStep(self::STEP);
        //Click on confirm:
        $confirmCheckbox = $this->webDriver->findElement(WebDriverBy::className('checkmark'));
        $confirmCheckbox->click();
        $formContinue = $this->webDriver->findElement(WebDriverBy::name('continue_button'));
        $formContinue->click();
    }
}
