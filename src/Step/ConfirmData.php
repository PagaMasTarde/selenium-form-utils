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
     * First step Confirm retrieved data
     *
     * @param bool $rejected
     * @return bool
     * @throws \Exception
     */
    public function run($rejected = false)
    {
        $this->validateStep(self::STEP);
        //Click on confirm:
        $confirmCheckbox = $this->webDriver->findElement(WebDriverBy::className('checkmark'));
        $confirmCheckbox->click();
        $formContinue = $this->webDriver->findElement(WebDriverBy::name('continue_button'));
        $formContinue->click();

        return true;
    }
}
