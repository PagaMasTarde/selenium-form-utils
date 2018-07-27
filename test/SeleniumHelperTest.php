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
    public function testFinishForm()
    {
        //$this->webDriver->get($this->getFormUrl());
        $this->webDriver->get('https://form.pagamastarde.com/3d993762ef7740ca9dc0050e1e433cdd/confirm-data');
        SeleniumHelper::finishForm($this->webDriver);
    }
}
