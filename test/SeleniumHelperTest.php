<?php

namespace Test\PagaMasTarde\SeleniumFormUtils;

use PagaMasTarde\SeleniumFormUtils\SeleniumHelper;

/**
 * Class SeleniumHelperTest
 * @package Test\PagaMasTarde\SeleniumFormUtils
 */
class SeleniumHelperTest extends AbstractTest
{
    /**
     * @throws \Exception
     */
    public function testBasicOrderCancelForm()
    {
        $order = $this->getBasicOrder();
        $this->webDriver->get($order->getActionUrls()->getForm());
        SeleniumHelper::cancelForm($this->webDriver);
        $this->assertEquals($this->webDriver->getCurrentUrl(), $order->getConfiguration()->getUrls()->getCancel());
        $this->webDriver->quit();
    }

    /**
     * @throws \Exception
     */
    public function testFinishForm()
    {
        $this->webDriver->get($this->getFormUrl());
        SeleniumHelper::finishForm($this->webDriver);
        $this->webDriver->quit();
    }

    /**
     * @throws \Exception
     */
    public function testBasicOrderFinishForm()
    {
        $this->webDriver->get($this->getBasicOrder()->getActionUrls()->getForm());
        SeleniumHelper::finishForm($this->webDriver);
        $this->webDriver->quit();
    }
}
