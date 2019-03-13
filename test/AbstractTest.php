<?php

namespace Test\Pagantis\SeleniumFormUtils;

use Facebook\WebDriver\Interactions\WebDriverActions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverElement;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Faker\Factory;
use Pagantis\OrdersApiClient\Client;
use Pagantis\OrdersApiClient\Model\Order;
use PHPUnit\Framework\TestCase;

/**
 * Class AbstractTest
 * @package Test\Pagantis\SeleniumFormUtils
 */
abstract class AbstractTest extends TestCase
{
    const PUBLIC_KEY = 'tk_4954690ee76a4ff7875b93b4';
    const PRIVATE_KEY = '4392a844f7904be3';

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
            180000,
            180000
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
        return $this->webDriver->wait(180, 2000)->until($condition);
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
     * @return bool|false|Order|string
     * @throws \Httpful\Exception\ConnectionErrorException
     * @throws \Pagantis\OrdersApiClient\Exception\ClientException
     * @throws \Pagantis\OrdersApiClient\Exception\HttpException
     */
    protected function getBasicOrder()
    {
        $orderClient = new Client(
            self::PUBLIC_KEY,
            self::PRIVATE_KEY
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
