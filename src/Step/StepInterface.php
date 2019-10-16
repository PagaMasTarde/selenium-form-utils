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
     * @return bool
     */
    public function run($rejected = false);
}
