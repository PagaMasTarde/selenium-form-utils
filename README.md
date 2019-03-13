# Selenium Form Utils <img src="https://www.pagantis.com/wp-content/uploads/2019/02/cropped-pagantis_logo-1.png" width="100" align="right">

CircleCI: [![CircleCI](https://circleci.com/gh/pagantis/selenium-form-utils/tree/master.svg?style=svg)](https://circleci.com/gh/pagantis/selenium-form-utils/tree/master)


[![Latest Stable Version](https://poser.pugx.org/pagantis/selenium-form-utils/v/stable)](https://packagist.org/packages/pagantis/selenium-form-utils)
[![composer.lock](https://poser.pugx.org/pagantis/selenium-form-utils/composerlock)](https://packagist.org/packages/pagantis/selenium-form-utils)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/pagantis/selenium-form-utils/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/pagantisTarde/selenium-form-utils/?branch=master)

Selenium Form Utils will help you when developing integration test of Paga+Tarde. The utils will go pass paga+tarde form to ensure you can test the Notification and the Redirection.
Be sure that KO and OK controllers work. You can automate your testing using travis-ci or circle-ci.

## How to use

Install the library by:

- Downloading it from [here](https://github.com/pagantis/selenium-form-utils/releases/latest)

- Using Composer:
```php
composer require pagantis/selenium-form-utils
```
Finally, be sure to include the autoloader:
```php
require_once '/path/to/your-project/vendor/autoload.php';
```

Once the library is ready and inside the project the stub objects will available and
the ordersApiClient will also available.

```php

// Once the webDriver of selenium is inside Paga+Tarde form, basically:
// $webdriver->getCurrentUrl == 'form.pagantis.com/....'
// Then you can use this tool to finish the form:

SeleniumHelper::finishForm($this->webDriver);

//The method will end once the form is approved, so the current URL will be OK_URL of the order
//Optionally you can also send the mobilePhone if the user is returning

SeleniumHelper::finishForm($this->webDriver, '600123123');


```

You can also check the cancel action automated

```php

SeleniumHelper::cancelForm($this->webDriver);

```


## To Develop and improve the library:

after doing the modifications please run the precised testing

```bash
docker-compose up -d

docker-compose exec php php-5.3 vendor/bin/phpunit
docker-compose exec php php-5.4 vendor/bin/phpunit
docker-compose exec php php-5.6 vendor/bin/phpunit
docker-compose exec php php-7.0 vendor/bin/phpunit
docker-compose exec php php-7.1 vendor/bin/phpunit
docker-compose exec php php-7.2 vendor/bin/phpunit
```

## Help us to improve

We are happy to accept suggestions or pull requests. If you are willing to help us develop better software
please create a pull request here following the PSR-2 code style and we will use reviewable to check
the code and if al test pass and no issues are detected by SensioLab Insights you could will be ready
to merge.

* [Issue Tracker](https://github.com/pagantis/selenium-form-utils/issues)
