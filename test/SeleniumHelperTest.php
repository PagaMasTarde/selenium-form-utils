<?php

namespace Test\PagaMasTarde\SeleniumFormUtils;

use PagaMasTarde\SeleniumFormUtils\SeleniumHelper;

/**
 * Class ClientTest
 * @package Test\PagaMasTarde\SeleniumFormUtils
 */
class ClientTest extends AbstractTest
{
    /**
     * testFinishForm
     */
    public function testFinishForm()
    {
        $this->webDriver->get('https://github.com');
        SeleniumHelper::finishForm($this->webDriver);
    }
}