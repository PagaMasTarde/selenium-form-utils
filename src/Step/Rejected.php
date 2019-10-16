<?php

namespace Pagantis\SeleniumFormUtils\Step;

use Facebook\WebDriver\WebDriverBy;

/**
 * Class Returning
 *
 * @package Pagantis\SeleniumFormUtils\Step
 */
class Rejected extends AbstractStep
{
    /**
     * Handler step
     */
    const STEP = 'Rejected';

    /**
     * Forth step reject an order and return tu shop
     *
     * @param bool $rejected
     * @return bool
     * @throws \Exception
     */
    public function run($rejected = false)
    {
        $this->validateStep(self::STEP);
        $formContinue = $this->webDriver->findElement(WebDriverBy::name('back_to_store_button'));
        $formContinue->click();

        return false;
    }
}
