<?php

namespace Pagantis\SeleniumFormUtils\Step\ConfirmData;

use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverSelect;
use Pagantis\SeleniumFormUtils\SeleniumHelper;
use Pagantis\SeleniumFormUtils\Step\AbstractStep;

/**
 * Class Missing
 * @package Pagantis\SeleniumFormUtils\Step\Result\Status
 */
class Missing extends AbstractStep
{
    /**
     * Handler step
     */
    const STEP = '/confirm-data/missing';

    /**
     * Full name
     */
    const FULL_NAME = 'John Doe Martínez';

    /**
     * DNI
     */
    const DNI = '70831384D';

    /**
     * Phone
     */
    const PHONE = '600123123';

    /**
     * Address
     */
    const ADDRESS = 'Paseo Castellana, 95';

    /**
     * City
     */
    const CITY = 'Madrid';

    /**
     * ZipCode
     */
    const ZIP_CODE = '28046';

    /**
     * Pass from confirm-data to next step in Application Form
     *
     * @throws \Exception
     */
    public function run()
    {
        $this->validateStep(self::STEP);
        //Click on confirm:
        $this->waitTobeVisible(WebDriverBy::name('workingStatus'));
        $select = new WebDriverSelect($this->webDriver->findElement(WebDriverBy::name('workingStatus')));
        $select->selectByValue('employed');

        /*
         * Optional Full Name:
         */
        try {
            $name = $this->webDriver->findElement(WebDriverBy::name('name'));
            $name->clear()->sendKeys(self::FULL_NAME);
        } catch (\Exception $exception) {
            unset($exception);
        }

        /*
         * Optional DNI:
         */
        try {
            $name = $this->webDriver->findElement(WebDriverBy::name('dni'));
            $name->clear()->sendKeys(self::DNI);
        } catch (\Exception $exception) {
            unset($exception);
        }

        /*
         * Optional BirthDate:
         */
        try {
            $select = new WebDriverSelect($this->webDriver->findElement(WebDriverBy::name('dob-day')));
            $select->selectByValue('20');
            $select = new WebDriverSelect($this->webDriver->findElement(WebDriverBy::name('dob-month')));
            $select->selectByValue('11');
            $select = new WebDriverSelect($this->webDriver->findElement(WebDriverBy::name('dob-year')));
            $select->selectByValue('1985');
        } catch (\Exception $exception) {
            unset($exception);
        }

        /*
         * Optional Phone:
         */
        try {
            $name = $this->webDriver->findElement(WebDriverBy::name('cellphone'));
            $name->clear()->sendKeys(self::PHONE);
        } catch (\Exception $exception) {
            unset($exception);
        }

        /*
         * Optional address:
         */
        try {
            $name = $this->webDriver->findElement(WebDriverBy::name('address'));
            $name->clear()->sendKeys(self::ADDRESS);
        } catch (\Exception $exception) {
            unset($exception);
        }

        /*
         * Optional city:
         */
        try {
            $name = $this->webDriver->findElement(WebDriverBy::name('city'));
            $name->clear()->sendKeys(self::CITY);
        } catch (\Exception $exception) {
            unset($exception);
        }

        /*
         * Optional zipcode:
         */
        try {
            $name = $this->webDriver->findElement(WebDriverBy::name('zipcode'));
            $name->clear()->sendKeys(self::ZIP_CODE);
        } catch (\Exception $exception) {
            unset($exception);
        }

        /*
         * Optional password:
         */
        try {
            $name = $this->webDriver->findElement(WebDriverBy::name('password'));
            if (null === SeleniumHelper::$mobilePhone) {
                $name->clear()->sendKeys(substr(self::PHONE, -4));
            } else {
                $name->clear()->sendKeys(substr(SeleniumHelper::$mobilePhone, -4));
            }
        } catch (\Exception $exception) {
            unset($exception);
        }

        /*
         * Click form continue
         */
        try {
            $formContinue = $this->webDriver->findElement(WebDriverBy::name('edit_customer_data_form_continue'));
            $formContinue->click();
        } catch (\Exception $exception) {
            unset($exception);
        }

        /*
         * Click login button
         */
        try {
            $formContinue = $this->webDriver->findElement(WebDriverBy::name('login_modal_loginButton'));
            $formContinue->click();
        } catch (\Exception $exception) {
            unset($exception);
        }
    }
}
