<?php

namespace PagaMasTarde\SeleniumFormUtils;

use Facebook\WebDriver\WebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;
use PagaMasTarde\SeleniumFormUtils\Step\AbstractStep;
use PagaMasTarde\SeleniumFormUtils\Step\Result\Status\Approved;

/**
 * Class SeleniumHelper
 * @package PagaMasTarde\SeleniumFormUtils
 */
class SeleniumHelper
{
    /**
     * Form base domain, initial status to verify before start testing
     */
    const FORM_BASE_URL = 'https://form.pagamastarde.com';

    /**
     * @var WebDriver
     */
    static protected $webDriver;

    /**
     * @var string $mobilePhone needed to identify returning users
     */
    static public $mobilePhone = null;

    /**
     * @param WebDriver $webDriver
     * @param string $mobilePhone
     *
     * @throws \Exception
     */
    public static function finishForm(WebDriver $webDriver, $mobilePhone = null)
    {
        self::$webDriver = $webDriver;
        self::$mobilePhone = $mobilePhone;
        self::waitToLoad();
        self::removeCookiesNotification();
        self::validateFormUrl();
        $maxSteps = 15;
        do {
            $formStep = self::getFormStep();
            $formStepClass = self::getStepClass($formStep);
            /** @var AbstractStep $stepClass */
            $stepClass = new $formStepClass(self::$webDriver);
            $stepClass->run();
            self::waitToLoad();
            --$maxSteps;
        } while ($formStep !== Approved::STEP && $maxSteps > 0);

        if ($maxSteps <= 0) {
            throw new \Exception('Error while finishing form, step: ' . $formStep);
        }
    }

    /**
     * @param WebDriver $webDriver
     * @param string $mobilePhone
     *
     * @throws \Exception
     */
    public static function cancelForm(WebDriver $webDriver, $mobilePhone = null)
    {
        self::$webDriver = $webDriver;
        self::$mobilePhone = $mobilePhone;
        self::waitToLoad();
        self::removeCookiesNotification();
        self::validateFormUrl();

        self::$webDriver->wait()->until(
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
     * Get the step of the form from the URL: '/result/status/approved'
     *
     * @return string
     */
    protected static function getFormStep()
    {
        $path = parse_url(self::$webDriver->getCurrentURL(), PHP_URL_PATH);
        $arguments = explode(DIRECTORY_SEPARATOR, $path);
        $step = '';
        for ($i = 2; $i < count($arguments); $i++) {
            $step .= DIRECTORY_SEPARATOR.$arguments[$i];
        }

        return $step;
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
        $stepClass = 'PagaMasTarde\SeleniumFormUtils\Step';
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
        $element = WebDriverBy::cssSelector(".Loading .is-disabled");
        $condition = WebDriverExpectedCondition::presenceOfElementLocated($element);
        self::$webDriver->wait()->until($condition);
    }

    /**
     * @throws \Facebook\WebDriver\Exception\NoSuchElementException
     * @throws \Facebook\WebDriver\Exception\TimeOutException
     */
    public static function removeCookiesNotification()
    {
        $element = WebDriverBy::id('sg-notification-global-trigger');
        $condition = WebDriverExpectedCondition::presenceOfElementLocated($element);
        self::$webDriver->wait()->until($condition);
        self::$webDriver->findElement($element)->click();
    }
}
