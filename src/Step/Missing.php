<?php

namespace Pagantis\SeleniumFormUtils\Step;

use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;
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
    const STEP = 'Missing';

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
     * Second step fill the form data (dni, address...)
     *
     * @param bool $rejected
     * @return bool
     * @throws \Exception
     */
    public function run($rejected = false)
    {
        $this->validateStep(self::STEP);

        /*
         * Field DNI:
         */
        try {
            $name = $this->webDriver->findElement(WebDriverBy::name('dni'));
            $name->clear()->sendKeys($this->getDNI());
        } catch (\Exception $exception) {
            unset($exception);
        }
        /*
         * Field BirthDate:
         */
        try {
            $dob = $this->webDriver->findElement(WebDriverBy::name('dob'));
            $dob->clear()->sendKeys('12/12/1979');
        } catch (\Exception $exception) {
            unset($exception);
        }
        /*
         * Field address:
         */
        try {
            $name = $this->webDriver->findElement(WebDriverBy::name('address'));
            $name->clear()->sendKeys($this->faker->address. ' ' . $this->faker->city);
        } catch (\Exception $exception) {
            unset($exception);
        }
        /*
         * Field city:
         */
        try {
            $name = $this->webDriver->findElement(WebDriverBy::name('city'));
            $name->clear()->sendKeys($this->faker->city);
        } catch (\Exception $exception) {
            unset($exception);
        }
        /*
         * Field zipcode:
         */
        try {
            $name = $this->webDriver->findElement(WebDriverBy::name('zipcode'));
            $name->clear()->sendKeys('28045');
        } catch (\Exception $exception) {
            unset($exception);
        }
        /*
         * Field Phone:
         */
        try {
            $name = $this->webDriver->findElement(WebDriverBy::name('mobilePhone'));
            $name->clear()->sendKeys('6' . $this->faker->randomNumber(8));
        } catch (\Exception $exception) {
            unset($exception);
        }
        /*
         * Field Full Name:
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
         * Field password:
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
        $element = WebDriverBy::name("continue_button");
        try {
            $condition = WebDriverExpectedCondition::elementToBeClickable($element);
            $this->webDriver->wait(90, 1500)->until($condition);
            $formContinue = $this->webDriver->findElement($element);
            $formContinue->click();
        } catch (\Exception $exception) {
            sleep(10);
            unset($exception);
        }

        return true;
    }
}
