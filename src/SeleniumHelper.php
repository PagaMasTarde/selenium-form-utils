<?php

namespace Pagantis\SeleniumFormUtils;

use Facebook\WebDriver\WebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Pagantis\SeleniumFormUtils\Step\AbstractStep;
use Pagantis\SeleniumFormUtils\Step\Rejected;

/**
 * Class SeleniumHelper
 * @package Pagantis\SeleniumFormUtils
 */
class SeleniumHelper
{
    /**
     * Form base domain, initial status to verify before start testing
     */
    const FORM_BASE_URL = 'https://form.sbx.pagantis.com';

    /**
     * @var WebDriver
     */
    protected static $webDriver;

    /**
     * @var string $mobilePhone needed to identify returning users
     */
    public static $mobilePhone = null;

    /**
     * @var array $arraySteps
     */
    public static $arraySteps = array (
        '25' => 'ConfirmData',
        '50' => 'Missing',
        '75' => 'Application',
        '100' => 'Rejected',
    );

    /**
     * @param WebDriver $webDriver
     * @param bool      $rejected
     * @return string Useful to parse the exit step
     * @throws \Facebook\WebDriver\Exception\NoSuchElementException
     * @throws \Facebook\WebDriver\Exception\TimeOutException
     */
    public static function finishForm(WebDriver $webDriver, $rejected = false)
    {
        self::$webDriver = $webDriver;
        self::waitToLoad();
        self::validateFormUrl();
        $maxSteps = 20;
        do {
            self::waitToLoad();
            $formStep = self::getFormStep();
            $formStepClass = "\\".self::getStepClass($formStep);
            /** @var AbstractStep $stepClass */
            $stepClass = new $formStepClass(self::$webDriver);
            $continue = $stepClass->run($rejected);
            --$maxSteps;
        } while ($continue && $formStep !== Rejected::STEP && $maxSteps > 0);

        if ($maxSteps <= 0) {
            throw new \Exception('Error while finishing form, step: ' . $formStep);
        }

        return $formStep;
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
     * Get the step of the breadcrumb progress bar
     *
     * @return string
     */
    protected static function getFormStep()
    {

        return self::$arraySteps[
            self::$webDriver->findElement(WebDriverBy::cssSelector(".ProgressBar progress"))
            ->getAttribute("value")
        ];
    }

    /**
     * Turn the form step into a selenium handler class:
     * from: '/result/status-approved' to '\Result\StatusApproved'
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
        $element = WebDriverBy::cssSelector(".MainContainer");
        $condition = WebDriverExpectedCondition::presenceOfElementLocated($element);
        self::$webDriver->wait(90, 1500)->until($condition);
    }
}
