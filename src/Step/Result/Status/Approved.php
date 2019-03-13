<?php

namespace Pagantis\SeleniumFormUtils\Step\Result\Status;

use Pagantis\SeleniumFormUtils\Step\AbstractStep;

/**
 * Class Approved
 * @package Pagantis\SeleniumFormUtils\Step\Result\Status
 */
class Approved extends AbstractStep
{
    /**
     * Handler step
     */
    const STEP = '/result/status/approved';

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
