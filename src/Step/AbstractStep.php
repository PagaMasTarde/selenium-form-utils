<?php

namespace Pagantis\SeleniumFormUtils\Step;

use Facebook\WebDriver\WebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Faker\Factory;

/**
 * Class AbstractStep
 *
 * @package Pagantis\SeleniumFormUtils\Step
 */
abstract class AbstractStep implements StepInterface
{
    /**
     * @var WebDriver
     */
    protected $webDriver;

    /**
     * @var Factory
     */
    protected $faker;

    /**
     * AbstractStep constructor.
     *
     * @param WebDriver $webDriver
     */
    public function __construct(WebDriver $webDriver)
    {
        $this->webDriver = $webDriver;
        $this->faker = Factory::create();
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
        $this->webDriver->wait(90, 1500)->until($condition);

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
        $this->webDriver->wait(90, 1500)->until($condition);

        return $this->webDriver->findElement($webDriverBy);
    }

    /**
     * @param string $step
     *
     * @throws \Exception
     */
    public function validateStep($step)
    {
        $element = WebDriverBy::cssSelector(".Loading .is-disabled");
        $condition = WebDriverExpectedCondition::presenceOfElementLocated($element);
        $this->webDriver->wait(90, 1500)->until($condition);

        $path = parse_url($this->webDriver->getCurrentURL(), PHP_URL_PATH);
        $arguments = explode(DIRECTORY_SEPARATOR, $path);
        $tempStep = '';
        for ($i = 2; $i < count($arguments); $i++) {
            $tempStep .= DIRECTORY_SEPARATOR.$arguments[$i];
        }

        if ($step !== $tempStep) {
            throw new \Exception('Wrong step: ' . $tempStep);
        }
    }

    /**
     * @param $iFrameLocator
     *
     * @throws \Facebook\WebDriver\Exception\NoSuchElementException
     * @throws \Facebook\WebDriver\Exception\TimeOutException
     */
    public function moveToIFrame($iFrameLocator)
    {
        $condition = WebDriverExpectedCondition::frameToBeAvailableAndSwitchToIt($iFrameLocator);
        $this->webDriver->wait(90, 1500)->until($condition);
    }

    /**
     * Switch to parent window
     */
    public function moveToParent()
    {
        $handles=$this->webDriver->getWindowHandles();
        $parent = end($handles);
        $this->webDriver->switchTo()->window($parent);
    }
}
