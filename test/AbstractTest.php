<?php

namespace Test\PagaMasTarde\SeleniumFormUtils;

use Facebook\WebDriver\Interactions\WebDriverActions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverElement;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Faker\Factory;
use PagaMasTarde\OrdersApiClient\Client;
use PagaMasTarde\OrdersApiClient\Model\Order;
use PHPUnit\Framework\TestCase;
use Test\PagaMasTarde\OrdersApiClient\ClientTest;

/**
 * Class AbstractTest
 * @package Test\PagaMasTarde\SeleniumFormUtils
 */
abstract class AbstractTest extends TestCase
{
    /**
     * @var RemoteWebDriver
     */
    protected $webDriver;

    /**
     * Configure selenium
     */
    protected function setUp()
    {
        $this->webDriver = RemoteWebDriver::create(
            'http://localhost:4444/wd/hub',
            DesiredCapabilities::chrome(),
            60000,
            60000
        );
    }

    /**
     * @param $name
     *
     * @return \Facebook\WebDriver\Remote\RemoteWebElement
     */
    public function findByName($name)
    {
        return $this->webDriver->findElement(WebDriverBy::name($name));
    }

    /**
     * @param $id
     *
     * @return \Facebook\WebDriver\Remote\RemoteWebElement
     */
    public function findById($id)
    {
        return $this->webDriver->findElement(WebDriverBy::id($id));
    }

    /**
     * @param $className
     *
     * @return \Facebook\WebDriver\Remote\RemoteWebElement
     */
    public function findByClass($className)
    {
        return $this->webDriver->findElement(WebDriverBy::className($className));
    }

    /**
     * @param $css
     *
     * @return \Facebook\WebDriver\Remote\RemoteWebElement
     */
    public function findByCss($css)
    {
        return $this->webDriver->findElement(WebDriverBy::cssSelector($css));
    }

    /**
     * @param $link
     *
     * @return \Facebook\WebDriver\Remote\RemoteWebElement
     */
    public function findByLinkText($link)
    {
        return $this->webDriver->findElement(WebDriverBy::partialLinkText($link));
    }

    /**
     * @param WebDriverExpectedCondition $condition
     * @return mixed
     * @throws \Facebook\WebDriver\Exception\NoSuchElementException
     * @throws \Facebook\WebDriver\Exception\TimeOutException
     */
    public function waitUntil(WebDriverExpectedCondition $condition)
    {
        return $this->webDriver->wait()->until($condition);
    }

    /**
     * @param WebDriverElement $element
     *
     * @return WebDriverElement
     */
    public function moveToElementAndClick(WebDriverElement $element)
    {
        $action = new WebDriverActions($this->webDriver);
        $action->moveToElement($element);
        $action->click($element);
        $action->perform();

        return $element;
    }

    /**
     * @param WebDriverElement $element
     *
     * @return WebDriverElement
     */
    public function getParent(WebDriverElement $element)
    {
        return $element->findElement(WebDriverBy::xpath(".."));
    }

    /**
     * Quit browser
     */
    protected function quit()
    {
        $this->webDriver->quit();
    }

    /**
     * @return string
     *
     * @throws \Httpful\Exception\ConnectionErrorException
     * @throws \PagaMasTarde\OrdersApiClient\Exception\HttpException
     * @throws \PagaMasTarde\OrdersApiClient\Exception\ValidationException
     * @throws \ReflectionException
     */
    protected function getFormUrl()
    {
        $orderTestClass = new ClientTest();
        $order = $orderTestClass->testCreateOrder();

        return $order->getActionUrls()->getForm();
    }

    /**
     * @throws \Httpful\Exception\ConnectionErrorException
     * @throws \PagaMasTarde\OrdersApiClient\Exception\HttpException
     * @throws \PagaMasTarde\OrdersApiClient\Exception\ValidationException
     */
    protected function getBasicOrder()
    {
        $orderTestClass = new ClientTest();
        $orderApiConfiguration = $orderTestClass->getApiConfiguration();
        $orderClient = new Client(
            $orderApiConfiguration->getPublicKey(),
            $orderApiConfiguration->getPrivateKey()
        );
        $faker = Factory::create();

        $userAddress =  new Order\User\Address();
        $userAddress
            ->setZipCode($faker->postcode)
            ->setFullName($faker->firstName)
            ->setCountryCode('ES')
            ->setCity($faker->city)
            ->setAddress($faker->address)
        ;

        $orderShippingAddress =  new Order\User\Address();
        $orderShippingAddress
            ->setZipCode($faker->postcode)
            ->setFullName($faker->firstName)
            ->setCountryCode('ES')
            ->setCity($faker->city)
            ->setAddress($faker->address)
        ;
        $orderBillingAddress = new Order\User\Address();
        $orderBillingAddress
            ->setZipCode($faker->postcode)
            ->setFullName($faker->firstName)
            ->setCountryCode('ES')
            ->setCity($faker->city)
            ->setAddress($faker->address)
        ;

        $orderUser = new Order\User();
        $orderUser
            ->setAddress($userAddress)
            ->setFullName($userAddress->getFullName())
            ->setEmail($faker->email)
            ->setBillingAddress($orderBillingAddress)
            ->setShippingAddress($orderShippingAddress)
        ;

        $details = new Order\ShoppingCart\Details();
        $details->setShippingCost($faker->numberBetween(1, 1000));
        $product = new Order\ShoppingCart\Details\Product();
        $product
            ->setAmount($faker->numberBetween(400, 5000))
            ->setQuantity(1)
            ->setDescription($faker->text);
        $details->addProduct($product);

        $orderShoppingCart = new Order\ShoppingCart();
        $orderShoppingCart
            ->setDetails($details)
            ->setPromotedAmount(0)
            ->setTotalAmount($product->getAmount() + $details->getShippingCost())
        ;
        $orderConfigurationUrls = new Order\Configuration\Urls();
        $orderConfigurationUrls
            ->setCancel($faker->url)
            ->setKo($faker->url)
            ->setOk($faker->url)
        ;
        $orderChannel = new Order\Configuration\Channel();
        $orderChannel
            ->setAssistedSale(false)
            ->setType(Order\Configuration\Channel::ONLINE)
        ;
        $orderConfiguration = new Order\Configuration();
        $orderConfiguration
            ->setChannel($orderChannel)
            ->setUrls($orderConfigurationUrls)
        ;

        $metadata = new Order\Metadata();
        $metadata->addMetadata('a', 'b');

        $order = new Order();
        $order
            ->setConfiguration($orderConfiguration)
            ->setShoppingCart($orderShoppingCart)
            ->setMetadata($metadata)
            ->setUser($orderUser)
        ;

        $orderCreated = $orderClient->createOrder($order);

        return $orderCreated;
    }
}
