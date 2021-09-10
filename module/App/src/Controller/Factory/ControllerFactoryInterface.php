<?php

namespace App\Controller\Factory;

use App\Controller\ControllerInterface;

/**
 * Class ControllerFactoryInterface
 *
 * @package App\Controller\Factory
 */
interface ControllerFactoryInterface
{

    /**
     * @return ControllerInterface
     */
    public function create(): ControllerInterface;
}
