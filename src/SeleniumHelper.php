<?php

namespace Pagantis\SeleniumFormUtils;

use Facebook\WebDriver\WebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Pagantis\SeleniumFormUtils\Step\AbstractStep;
use Pagantis\SeleniumFormUtils\Step\Rejected;
use Pagantis\SeleniumFormUtils\Step\AccountVerification;

/**
 * Class SeleniumHelper
 * @package Clearpay\SeleniumFormUtils
 */
class SeleniumHelper
{
    /**
     * Form base domain, initial status to verify before start testing
     */
    const FORM_BASE_URL = 'clearpay.com';

    /**
     *
     */
    const CLEARPAY_TITLE = 'Clearpay';

    /**
     * @var WebDriver
     */
    protected static $webDriver;

    /**
     * @param WebDriver $webDriver
     * @param bool      $rejected
     * @return string Useful to parse the exit step
     * @throws \Facebook\WebDriver\Exception\NoSuchElementException
     * @throws \Facebook\WebDriver\Exception\TimeOutException
     */
    public static function finishForm(WebDriver $webDriver, $rejected = false)
    {
        try {
            self::$webDriver = $webDriver;
            self::waitToLoad();
            self::validateFormUrl();
            $maxSteps = 20;
            do {
                self::waitToLoad();
                $formStep = self::getFormStep();
                if(self::stepIsExcluded($formStep)){
                    $continue = true;
                    continue;
                }
                $formStepClass = self::getStepClass($formStep);
                /** @var AbstractStep $stepClass */
                $stepClass = new $formStepClass(self::$webDriver);
                $continue = $stepClass->run($rejected);
                --$maxSteps;
            } while ($continue && $maxSteps>0);
        } catch (\Exception $exception) {
            echo $exception->getMessage();
            echo self::$webDriver->getCurrentURL();
        }

        if ($maxSteps <= 0) {
            throw new \Exception('Error while finishing form, step: ' . $formStep);
        }

        return $formStep;
    }

    /**
     * @param $currentStep
     *
     * @return bool
     */
    public static function stepIsExcluded($currentStep)
    {
        return (substr($currentStep,0,4) === '004.');
    }

    /**
     * @param WebDriver $webDriver
     *
     * @throws \Exception
     */
    public static function cancelForm(WebDriver $webDriver)
    {
        self::$webDriver = $webDriver;
        self::waitToLoad();
        self::validateFormUrl();

        self::$webDriver->wait(90, 1500)->until(
            WebDriverExpectedCondition::elementToBeClickable(
                WebDriverBy::name('back_to_store_button')
            )
        );

        $formCancel = self::$webDriver->findElement(WebDriverBy::name('back_to_store_button'));
        $formCancel->click();
    }

    /**
     * @throws \Exception
     */
    protected static function validateFormUrl()
    {
        $currentUrl = self::$webDriver->getCurrentURL();
        if (strpos($currentUrl, self::FORM_BASE_URL) === false) {
            throw new \Exception('Unable to identify form url');
        }
    }

    /**
     * Get the step of the url
     *
     * @return string
     */
    protected static function getFormStep()
    {
        $formStep = explode(DIRECTORY_SEPARATOR, self::$webDriver->getCurrentURL());

        return array_pop($formStep);
    }

    /**
     * Turn the form step into a selenium handler class:
     * from: 'status-approved' to 'StatusApproved'
     *
     * @param $formStep
     *
     * @return string
     */
    protected static function getStepClass($formStep)
    {
        $formSteps = explode(DIRECTORY_SEPARATOR, $formStep);
        $stepClass = 'Pagantis\SeleniumFormUtils\Step';
        foreach ($formSteps as $formStep) {
            if ($formStep !== '') {
                $stepClass .= "\\".str_replace('-', '', ucwords($formStep, '-'));
            }
        }

        return $stepClass;
    }

    /**
     * @throws \Facebook\WebDriver\Exception\NoSuchElementException
     * @throws \Facebook\WebDriver\Exception\TimeOutException
     */
    public static function waitToLoad()
    {
        $condition = WebDriverExpectedCondition::titleContains(self::CLEARPAY_TITLE);
        self::$webDriver->wait(90, 1500)
                        ->until($condition, self::$webDriver->getCurrentURL());
    }
}
