<?php

namespace PagaMasTarde\SeleniumFormUtils;

use Facebook\WebDriver\WebDriver;

/**
 * Class SeleniumHelper
 * @package PagaMasTarde\SeleniumFormUtils
 */
class SeleniumHelper
{
    /**
     * @var WebDriver
     */
    static protected $webDriver;

    /**
     * @param WebDriver $webDriver
     */
    public static function finishForm(WebDriver $webDriver)
    {
        self::$webDriver = $webDriver;
        self::$webDriver->get('https://www.google.es');
    }
}
