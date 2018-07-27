<?php

namespace PagaMasTarde\SeleniumFormUtils\Step;

use Facebook\WebDriver\WebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;

/**
 * Class AbstractStep
 *
 * @package PagaMasTarde\SeleniumFormUtils\Step
 */
abstract class AbstractStep implements StepInterface
{
    /**
     * Class Current Step
     */
    const STEP = '';

    /**
     * @var WebDriver
     */
    protected $webDriver;

    /**
     * AbstractStep constructor.
     *
     * @param WebDriver $webDriver
     */
    public function __construct(WebDriver $webDriver)
    {
        $this->webDriver = $webDriver;
    }

    /**
     * @param WebDriverBy $webDriverBy
     *
     * @return \Facebook\WebDriver\WebDriverElement
     *
     * @throws \Facebook\WebDriver\Exception\NoSuchElementException
     * @throws \Facebook\WebDriver\Exception\TimeOutException
     */
    public function waitTobeClickAble(WebDriverBy $webDriverBy)
    {
        $condition = WebDriverExpectedCondition::elementToBeClickable($webDriverBy);
        $this->webDriver->wait()->until($condition);

        return $this->webDriver->findElement($webDriverBy);
    }

    /**
     * @param WebDriverBy $webDriverBy
     *
     * @return \Facebook\WebDriver\WebDriverElement
     *
     * @throws \Facebook\WebDriver\Exception\NoSuchElementException
     * @throws \Facebook\WebDriver\Exception\TimeOutException
     */
    public function waitTobeVisible(WebDriverBy $webDriverBy)
    {
        $condition = WebDriverExpectedCondition::visibilityOfElementLocated($webDriverBy);
        $this->webDriver->wait()->until($condition);

        return $this->webDriver->findElement($webDriverBy);
    }

    /**
     * @throws \Exception
     */
    public function validateStep()
    {

        $path = parse_url($this->webDriver->getCurrentURL(), PHP_URL_PATH);
        $arguments = explode(DIRECTORY_SEPARATOR, $path);
        $step = '';
        for ($i = 2; $i < count($arguments); $i++) {
            $step .= DIRECTORY_SEPARATOR.$arguments[$i];
        }

        if (self::STEP !== $step) {
            throw new \Exception('Wrong step: ' . $step);
        }
    }
}
