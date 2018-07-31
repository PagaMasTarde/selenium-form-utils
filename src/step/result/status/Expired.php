<?php

namespace PagaMasTarde\SeleniumFormUtils\Step\Result\Status;

use PagaMasTarde\SeleniumFormUtils\Step\AbstractStep;

/**
 * Class Expired
 * @package PagaMasTarde\SeleniumFormUtils\Step\Result\Status
 */
class Expired extends AbstractStep
{
    /**
     * Handler step
     */
    const STEP = '/result/status/expired';

    /**
     * Pass from confirm-data to next step in Application Form
     *
     * @throws \Exception
     */
    public function run()
    {
        $this->validateStep(self::STEP);
    }
}
