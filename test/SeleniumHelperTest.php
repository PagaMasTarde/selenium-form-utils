<?php

namespace Test\Pagantis\SeleniumFormUtils;

use Pagantis\SeleniumFormUtils\SeleniumHelper;

/**
 * Class SeleniumHelperTest
 * @package Test\Pagantis\SeleniumFormUtils
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
        SeleniumHelper::cancelForm($this->webDriver) ;
        // Can only compare host because several sites redirect 404 and other accesses to a custom error page and curl
        // fails
        $from = parse_url($this->webDriver->getCurrentUrl(), PHP_URL_HOST);
        $to = parse_url($order->getConfiguration()->getUrls()->getCancel(), PHP_URL_HOST);
        $this->assertContains($from, array($to));
        $this->webDriver->quit();
    }

    /**
     * @throws \Exception
     */
    public function testBasicOrderFinishForm()
    {
        $url = $this->getBasicOrder()->getActionUrls()->getForm();
        $this->webDriver->get($url);
        SeleniumHelper::finishForm($this->webDriver);
        $this->webDriver->quit();
    }
}
