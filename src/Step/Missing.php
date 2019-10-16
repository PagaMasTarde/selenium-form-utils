<?php

namespace Pagantis\SeleniumFormUtils\Step;

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
     * @throws \Exception
     */
    public function run($rejected = false)
    {
        $this->validateStep(self::STEP);

        /*
         * Mandatory DNI:
         */
        $name = $this->webDriver->findElement(WebDriverBy::name('dni'));
        $name->clear()->sendKeys($this->getDNI());

        /*
         * Mandatory BirthDate:
         */
        $dob = $this->webDriver->findElement(WebDriverBy::name('dob'));
        $dob->clear()->sendKeys(
            $this->faker->numberBetween(1, 28).
            $this->faker->numberBetween(1, 12).
            '1975'
        );

        /*
         * Mandatory address:
         */
        $name = $this->webDriver->findElement(WebDriverBy::name('address'));
        $name->clear()->sendKeys($this->faker->address. ' ' . $this->faker->city);

        /*
         * Optional city:
         */
        $name = $this->webDriver->findElement(WebDriverBy::name('city'));
        $name->clear()->sendKeys($this->faker->city);

        /*
         * Optional zipcode:
         */
        $name = $this->webDriver->findElement(WebDriverBy::name('zipcode'));
        $name->clear()->sendKeys('28045');

        /*
         * Optional Phone:
         */
        $name = $this->webDriver->findElement(WebDriverBy::name('mobilePhone'));
        $name->clear()->sendKeys('6' . $this->faker->randomNumber(8));

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
            $formContinue = $this->webDriver->findElement(WebDriverBy::name('continue_button'));
            $formContinue->click();
        } catch (\Exception $exception) {
            unset($exception);
        }
    }
}
