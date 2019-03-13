<?php

namespace Pagantis\SeleniumFormUtils\Step;

use Facebook\WebDriver\WebDriverBy;
use Pagantis\SeleniumFormUtils\Step\ConfirmData\Missing;

/**
 * Class Application
 *
 * @package Pagantis\SeleniumFormUtils\Step
 */
class Application extends AbstractStep
{
    /**
     * Handler step
     */
    const STEP = '/application';

    const CARD_NUMBER = '4507670001000009';

    const CARD_CVC = '989';

    const CARD_HOLDER = 'John Doe';

    /**
     * Pass from confirm-data to next step in Application Form
     *
     * @throws \Exception
     */
    public function run()
    {
        $this->validateStep(self::STEP);
        //Click on confirm:

        /*
         * Optional Full Name:
         */
        try {
            $name = $this->webDriver->findElement(WebDriverBy::name('name'));
            $name->clear()->sendKeys(Missing::FULL_NAME);
        } catch (\Exception $exception) {
            unset($exception);
        }

        try {
            $this->moveToIFrame('hosted-field-number');
            $this->waitTobeVisible(WebDriverBy::name('credit-card-number'));
            $creditCardNumber = $this->webDriver->findElement(WebDriverBy::name('credit-card-number'));
            $creditCardNumber->clear()->sendKeys(self::CARD_NUMBER);
            $this->moveToParent();
            $this->moveToIFrame('hosted-field-name');
            $cardHolder = $this->webDriver->findElement(WebDriverBy::name('name'));
            $cardHolder->clear()->sendKeys(self::CARD_HOLDER);
            $this->moveToParent();
            $this->moveToIFrame('hosted-field-cvv');
            $cvv = $this->webDriver->findElement(WebDriverBy::name('cvv'));
            $cvv->clear()->sendKeys(self::CARD_CVC);
            $this->moveToParent();
            $this->moveToIFrame('hosted-field-expirationDate');
            $expiration = $this->webDriver->findElement(WebDriverBy::name('expiration'));
            $expiration->clear()->sendKeys('12'. date('y'));
            $this->moveToParent();
            $acceptedTerms = $this->webDriver->findElement(WebDriverBy::className('Form-checkboxSkin'));
            $acceptedTerms->click();
        } catch (\Exception $exception) {
            unset($exception);
        }

        $formContinue = $this->webDriver->findElement(WebDriverBy::name('form-continue'));
        $formContinue->click();
    }
}
