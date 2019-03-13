<?php

namespace Pagantis\SeleniumFormUtils\Step\ConfirmData;

use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverSelect;
use Faker\Factory;
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
     * @return string
     */
    protected function getDNI()
    {
        $dni = '0000' . rand(pow(10, 4-1), pow(10, 4)-1);
        $value = (int) ($dni / 23);
        $value *= 23;
        $value= $dni - $value;
        $letter= "TRWAGMYFPDXBNJZSQVHLCKEO";
        $dniLetter= substr($letter, $value, 1);

        return $dni.$dniLetter;
    }

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
            $name->clear()->sendKeys(
                $this->faker->firstName . ' ' . $this->faker->lastName
            );
        } catch (\Exception $exception) {
            unset($exception);
        }

        /*
         * Optional DNI:
         */
        try {
            $name = $this->webDriver->findElement(WebDriverBy::name('dni'));
            $name->clear()->sendKeys($this->getDNI());
        } catch (\Exception $exception) {
            unset($exception);
        }

        /*
         * Optional BirthDate:
         */
        try {
            $select = new WebDriverSelect($this->webDriver->findElement(WebDriverBy::name('dob-day')));
            $select->selectByValue($this->faker->numberBetween(1, 28));
            $select = new WebDriverSelect($this->webDriver->findElement(WebDriverBy::name('dob-month')));
            $select->selectByValue($this->faker->numberBetween(1, 12));
            $select = new WebDriverSelect($this->webDriver->findElement(WebDriverBy::name('dob-year')));
            $select->selectByValue('1975');
        } catch (\Exception $exception) {
            unset($exception);
        }

        /*
         * Optional Phone:
         */
        try {
            $name = $this->webDriver->findElement(WebDriverBy::name('cellphone'));
            $name->clear()->sendKeys('6' . $this->faker->randomNumber(8));
        } catch (\Exception $exception) {
            unset($exception);
        }

        /*
         * Optional address:
         */
        try {
            $name = $this->webDriver->findElement(WebDriverBy::name('address'));
            $name->clear()->sendKeys($this->faker->address. ' ' . $this->faker->city);
        } catch (\Exception $exception) {
            unset($exception);
        }

        /*
         * Optional city:
         */
        try {
            $name = $this->webDriver->findElement(WebDriverBy::name('city'));
            $name->clear()->sendKeys($this->faker->city);
        } catch (\Exception $exception) {
            unset($exception);
        }

        /*
         * Optional zipcode:
         */
        try {
            $name = $this->webDriver->findElement(WebDriverBy::name('zipcode'));
            $name->clear()->sendKeys($this->faker->postcode);
        } catch (\Exception $exception) {
            unset($exception);
        }

        /*
         * Optional password:
         */
        try {
            $name = $this->webDriver->findElement(WebDriverBy::name('password'));
            if (null === SeleniumHelper::$mobilePhone) {
                throw new \Exception('Please provide mobile phone for returning customer');
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
