<?php

namespace Pagantis\SeleniumFormUtils\Step;

/**
 * Interface StepInterface
 * @package Pagantis\SeleniumFormUtils\Step
 */
interface StepInterface
{
    /**
     * @param bool $rejected
     * @return void
     */
    public function run($rejected = false);
}
