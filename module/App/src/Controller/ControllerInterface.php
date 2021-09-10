<?php

namespace App\Controller;

/**
 * Interface ControllerInterface
 *
 * @package App\Controller
 */
interface ControllerInterface
{

    /**
     * @param array  $vars
     * @param string $template
     * @param bool   $useLayout
     */
    public function render(array $vars, string $template, $useLayout = true);
}
