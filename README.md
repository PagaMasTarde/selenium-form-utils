# Selenium Form Utils <img src="https://pagamastarde.com/img/icons/logo.svg" width="100" align="right">

[![CircleCI](https://circleci.com/gh/PagaMasTarde/selenium-form-utils/tree/master.svg?style=svg)](https://circleci.com/gh/PagaMasTarde/selenium-form-utils/tree/master)[![Latest Stable Version](https://poser.pugx.org/pagamastarde/selenium-form-utils/v/stable)](https://packagist.org/packages/pagamastarde/selenium-form-utils)
[![composer.lock](https://poser.pugx.org/pagamastarde/selenium-form-utils/composerlock)](https://packagist.org/packages/pagamastarde/selenium-form-utils)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/PagaMasTarde/selenium-form-utils/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/PagaMasTarde/selenium-form-utils/?branch=master)

Selenium Form Utils will help you when developing integration test of Paga+Tarde. The utils will go pass paga+tarde form to ensure you can test the Notification and the Redirection.
Be sure that KO and OK controllers work. You can automate your testing using travis-ci or circle-ci.

## How to use

Install the library by:

- Downloading it from [here](https://github.com/PagaMasTarde/selenium-form-utils/releases/latest)

https://github.com/PagaMasTarde/selenium-form-utils/releases/latest

- Using Composer:
```php
composer require pagamastarde/selenium-form-utils
```
Finally, be sure to include the autoloader:
```php
require_once '/path/to/your-project/vendor/autoload.php';
```

Once the library is ready and inside the project the stub objects will available and
the ordersApiClient will also available.

```php

// Once the webDriver of selenium is inside Paga+Tarde form, basically:
// $webdriver->getCurrentUrl == 'form.pagamastarde.com/....'
// Then you can use this tool to finish the form:

SeleniumHelper::finishForm($this->webDriver);

//The method will end once the form is approved, so the current URL will be OK_URL of the order
```

You can also check the cancel action automated

```php

SeleniumHelper::cancelForm($this->webDriver);

```

## Help us to improve

We are happy to accept suggestions or pull requests. If you are willing to help us develop better software
please create a pull request here following the PSR-2 code style and we will use reviewable to check
the code and if al test pass and no issues are detected by SensioLab Insights you could will be ready
to merge.

* [Issue Tracker](https://github.com/PagaMasTarde/selenium-form-utils/issues)
